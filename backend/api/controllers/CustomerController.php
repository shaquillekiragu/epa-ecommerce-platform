<?php

namespace api\controllers;

use Yii;
use yii\db\Transaction;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use common\models\Address;
use api\models\Basket;
use api\models\Basketproduct;
use api\models\Order;
use api\models\Orderproduct;
use api\models\Product;
use api\models\Useraddress;

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

        $product = Product::activeCatalogQuery()->andWhere(['id' => $product_id])->one();
        if ($product === null) {
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

        $product = Product::activeCatalogQuery()->andWhere(['id' => (int) $id])->one();
        if ($product === null) {
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
                $product = Product::activeCatalogQuery()->andWhere(['id' => $item->product_id])->one();
                if ($product === null) {
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
                $order->placed_at = date('Y-m-d H:i:s');
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
        $orders = Order::find()
            ->where(['customer_id' => $user_id])
            ->orderBy(['order_datetime' => SORT_DESC])
            ->all();

        $out = [];
        foreach ($orders as $order) {
            /** @var Order $order */
            $row = $order->toArray();
            $row['item_count'] = (int) Orderproduct::find()
                ->where(['order_id' => $order->id])
                ->sum('quantity');
            $out[] = $row;
        }

        return $out;
    }

    public function actionOrderView($id)
    {
        $this->requireRole('customer');
        $user_id = (int) Yii::$app->user->id;
        $order = Order::findOne(['id' => (int) $id, 'customer_id' => $user_id]);
        if ($order === null) {
            throw new NotFoundHttpException('Order not found.');
        }

        $lines = Orderproduct::find()->where(['order_id' => $order->id])->all();
        $items = [];
        foreach ($lines as $line) {
            /** @var Orderproduct $line */
            $product = Product::findOne((int) $line->product_id);
            if ($product === null) {
                continue;
            }
            $unit = (float) $line->price_at_purchase_in_gbp;
            $qty = (int) $line->quantity;
            $items[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'thumbnail' => (string) ($product->thumbnail ?? ''),
                'price_at_purchase_in_gbp' => $unit,
                'quantity' => $qty,
                'line_total' => $unit * $qty,
            ];
        }

        return [
            'id' => $order->id,
            'store_id' => $order->store_id,
            'status' => $order->status,
            'price_total' => (float) $order->price_total,
            'order_datetime' => $order->order_datetime,
            'items' => $items,
        ];
    }

    public function actionAddresses()
    {
        $this->requireRole('customer');
        $user_id = (int) Yii::$app->user->id;

        $links = Useraddress::find()->where(['user_id' => $user_id])->all();
        $out = [];

        foreach ($links as $link) {
            /** @var Useraddress $link */
            $row = $this->serializeCustomerAddressRow($link);
            if ($row !== null) {
                $out[] = $row;
            }
        }

        return $out;
    }

    public function actionAddressesCreate()
    {
        $this->requireRole('customer');
        $user_id = (int) Yii::$app->user->id;
        $body = Yii::$app->request->getBodyParams();

        $address_type = (string) ($body['address_type'] ?? '');
        if (!in_array($address_type, ['shipping', 'billing', 'both'], true)) {
            throw new BadRequestHttpException('address_type must be shipping, billing, or both.');
        }

        $building_number = (string) ($body['building_number'] ?? '');
        $street_name = (string) ($body['street_name'] ?? '');
        $city = (string) ($body['city'] ?? '');
        $country = (string) ($body['country'] ?? '');
        $post_code = (string) ($body['post_code'] ?? '');
        $region_raw = trim((string) ($body['region'] ?? ''));
        $region = $region_raw === '' ? null : $region_raw;

        if ($building_number === '' || $street_name === '' || $city === '' || $country === '' || $post_code === '') {
            throw new BadRequestHttpException('building_number, street_name, city, country, and post_code are required.');
        }

        $db = Yii::$app->db;
        $tx = null;
        $link = null;
        try {
            $tx = $db->beginTransaction(Transaction::SERIALIZABLE);
            $addr = new Address();
            $addr->address_type = $address_type;
            $addr->building_number = $building_number;
            $addr->street_name = $street_name;
            $addr->city = $city;
            $addr->region = $region;
            $addr->country = $country;
            $addr->post_code = $post_code;
            $addr->allow_update = true;
            $addr->allow_delete = true;

            if (!$addr->save()) {
                throw new BadRequestHttpException(json_encode($addr->errors));
            }

            $link = new Useraddress();
            $link->user_id = $user_id;
            $link->address_id = (int) $addr->id;

            if (!$link->save()) {
                throw new BadRequestHttpException(json_encode($link->errors));
            }

            $tx->commit();
        } catch (\Throwable $e) {
            if ($tx !== null) {
                $tx->rollBack();
            }
            throw $e;
        }

        /** @var Useraddress $link */
        $row = $this->serializeCustomerAddressRow($link);
        if ($row === null) {
            throw new BadRequestHttpException('Address could not be loaded after save.');
        }

        return $row;
    }

    /**
     * @return array<string, mixed>|null
     */
    private function serializeCustomerAddressRow(Useraddress $link): ?array
    {
        $addr = Address::findOne((int) $link->address_id);
        if ($addr === null) {
            return null;
        }

        return [
            'id' => (int) $link->id,
            'address_id' => (int) $addr->id,
            'address_type' => $addr->address_type,
            'building_number' => $addr->building_number,
            'street_name' => $addr->street_name,
            'city' => $addr->city,
            'region' => $addr->region,
            'post_code' => $addr->post_code,
            'country' => $addr->country,
        ];
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
                'product_name' => $product->name,
                'product_slug' => (string) $product->slug,
                'thumbnail' => (string) ($product->thumbnail ?? ''),
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
