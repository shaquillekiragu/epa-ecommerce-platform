<?php

namespace api\controllers;

use Yii;
use yii\db\Expression;
use yii\db\Transaction;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use api\models\Basket;
use api\models\Basketproduct;
use api\models\Order;
use api\models\Orderproduct;
use api\models\Product;

class CustomerController extends _ApiController
{
    public $auth_required = true;
    public $modelClass = \api\models\User::class;

    public function actions()
    {
        return [];
    }

    public function actionUser()
    {
        $this->requireRole('customer');
        /** @var \common\models\User $user */
        $user = Yii::$app->user->identity;
        return (new \api\models\User())->findOne($user->id);
    }

    public function actionBasket()
    {
        $this->requireRole('customer');
        $basket = $this->getOrCreateBasket((int) Yii::$app->user->id);
        return $this->serializeBasket($basket);
    }

    public function actionBasketAdd()
    {
        $this->requireRole('customer');
        $body = Yii::$app->request->getBodyParams();
        $product_id = (int) ($body['product_id'] ?? 0);
        $quantity = (int) ($body['quantity'] ?? 0);
        if ($product_id <= 0 || $quantity <= 0) {
            throw new BadRequestHttpException('product_id and quantity are required.');
        }

        $product = Product::findOne($product_id);
        if ($product === null || !$product->is_active) {
            throw new NotFoundHttpException('Product not found.');
        }

        $basket = $this->getOrCreateBasket((int) Yii::$app->user->id);

        $existing = Basketproduct::findOne(['basket_id' => $basket->id, 'product_id' => $product_id]);
        $new_qty = $quantity + (int) ($existing?->quantity ?? 0);
        $new_qty = min($new_qty, (int) $product->number_in_stock);
        if ($new_qty <= 0) {
            throw new BadRequestHttpException('Insufficient stock.');
        }

        $item = $existing ?? new Basketproduct();
        $item->basket_id = $basket->id;
        $item->product_id = $product_id;
        $item->quantity = $new_qty;

        if (!$item->save()) {
            throw new BadRequestHttpException(json_encode($item->errors));
        }

        $this->recalcBasketTotal($basket);
        return $this->serializeBasket($basket);
    }

    public function actionBasketItem($id)
    {
        $this->requireRole('customer');
        $basket = $this->getOrCreateBasket((int) Yii::$app->user->id);

        $item = Basketproduct::findOne(['basket_id' => $basket->id, 'product_id' => (int) $id]);
        if ($item === null) {
            throw new NotFoundHttpException('Basket item not found.');
        }

        $body = Yii::$app->request->getBodyParams();
        $quantity = (int) ($body['quantity'] ?? 0);
        if ($quantity < 0) {
            throw new BadRequestHttpException('Invalid quantity.');
        }

        $product = Product::findOne((int) $id);
        if ($product === null || !$product->is_active) {
            throw new NotFoundHttpException('Product not found.');
        }

        if ($quantity === 0) {
            $item->delete();
        } else {
            $item->quantity = min($quantity, (int) $product->number_in_stock);
            if (!$item->save()) {
                throw new BadRequestHttpException(json_encode($item->errors));
            }
        }

        $this->recalcBasketTotal($basket);
        return $this->serializeBasket($basket);
    }

    public function actionCheckout()
    {
        $this->requireRole('customer');
        $user_id = (int) Yii::$app->user->id;
        $basket = Basket::findOne(['customer_id' => $user_id]);
        if ($basket === null) {
            throw new BadRequestHttpException('Basket is empty.');
        }

        $items = Basketproduct::find()->where(['basket_id' => $basket->id])->all();
        if (empty($items)) {
            throw new BadRequestHttpException('Basket is empty.');
        }

        $db = Yii::$app->db;
        $tx = $db->beginTransaction(Transaction::SERIALIZABLE);
        try {
            // Group by store_id because Order requires store_id.
            $groups = [];
            foreach ($items as $item) {
                $product = Product::findOne($item->product_id);
                if ($product === null || !$product->is_active) {
                    throw new BadRequestHttpException('Basket contains invalid product.');
                }
                if ($product->number_in_stock < $item->quantity) {
                    throw new BadRequestHttpException('Insufficient stock for one or more items.');
                }
                $groups[(int) $product->store_id][] = [$item, $product];
            }

            $created_orders = [];

            foreach ($groups as $store_id => $rows) {
                $order_total = 0.0;
                foreach ($rows as [$item, $product]) {
                    $order_total += ((float) $product->price_in_gbp) * ((int) $item->quantity);
                }

                $order = new Order();
                $order->customer_id = $user_id;
                $order->store_id = (int) $store_id;
                $order->price_total = $order_total;
                $order->order_datetime = date('Y-m-d H:i:s');
                $order->status = 'pending_payment';
                $order->allow_update = true;
                $order->allow_delete = true;

                if (!$order->save()) {
                    throw new BadRequestHttpException(json_encode($order->errors));
                }

                foreach ($rows as [$item, $product]) {
                    $op = new Orderproduct();
                    $op->order_id = $order->id;
                    $op->product_id = $product->id;
                    $op->price_at_purchase_in_gbp = (float) $product->price_in_gbp;
                    $op->quantity = (int) $item->quantity;
                    $op->allow_update = true;
                    $op->allow_delete = true;

                    if (!$op->save()) {
                        throw new BadRequestHttpException(json_encode($op->errors));
                    }
                }

                $created_orders[] = $order;
            }

            // Clear basket after checkout creation.
            Basketproduct::deleteAll(['basket_id' => $basket->id]);
            $basket->price_total = 0;
            $basket->save(false, ['price_total']);

            $tx->commit();

            return [
                'orders' => array_map(static fn (Order $o) => [
                    'id' => $o->id,
                    'store_id' => $o->store_id,
                    'status' => $o->status,
                    'price_total' => $o->price_total,
                    'order_datetime' => $o->order_datetime,
                ], $created_orders),
            ];
        } catch (\Throwable $e) {
            $tx->rollBack();
            throw $e;
        }
    }

    public function actionOrders()
    {
        $this->requireRole('customer');
        $user_id = (int) Yii::$app->user->id;
        return Order::find()
            ->where(['customer_id' => $user_id])
            ->orderBy(['order_datetime' => SORT_DESC])
            ->all();
    }

    private function getOrCreateBasket(int $customer_id): Basket
    {
        $basket = Basket::findOne(['customer_id' => $customer_id]);
        if ($basket !== null) {
            return $basket;
        }

        $basket = new Basket();
        $basket->customer_id = $customer_id;
        $basket->price_total = 0;
        $basket->allow_update = true;
        $basket->allow_delete = true;
        if (!$basket->save()) {
            throw new BadRequestHttpException(json_encode($basket->errors));
        }

        return $basket;
    }

    private function recalcBasketTotal(Basket $basket): void
    {
        $items = Basketproduct::find()->where(['basket_id' => $basket->id])->all();
        $total = 0.0;
        foreach ($items as $item) {
            $product = Product::findOne($item->product_id);
            if ($product === null) {
                continue;
            }
            $total += ((float) $product->price_in_gbp) * ((int) $item->quantity);
        }
        $basket->price_total = $total;
        $basket->save(false, ['price_total']);
    }

    private function serializeBasket(Basket $basket): array
    {
        $items = Basketproduct::find()->where(['basket_id' => $basket->id])->all();
        $out = [];
        foreach ($items as $item) {
            $product = Product::findOne($item->product_id);
            if ($product === null) {
                continue;
            }
            $out[] = [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'price_in_gbp' => (float) $product->price_in_gbp,
                'quantity' => (int) $item->quantity,
                'line_total' => (float) $product->price_in_gbp * (int) $item->quantity,
            ];
        }

        return [
            'id' => $basket->id,
            'customer_id' => $basket->customer_id,
            'price_total' => (float) $basket->price_total,
            'items' => $out,
        ];
    }
}
