<?php

namespace api\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use api\models\Order;
use api\models\Orderproduct;
use api\models\Product;
use api\models\Store;

class MerchantController extends _ApiController
{
    public $auth_required = true;
    public $modelClass = Store::class;

    public function actions()
    {
        return [];
    }

    public function actionStores()
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        return Store::find()
            ->where(['merchant_id' => $merchant_id])
            ->orderBy(['id' => SORT_ASC])
            ->all();
    }

    public function actionStoresCreate()
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        $body = Yii::$app->request->getBodyParams();

        $store = new Store();
        $store->load($body, '');
        $store->merchant_id = $merchant_id;
        $store->allow_update = true;
        $store->allow_delete = true;

        if (!$store->save()) {
            throw new BadRequestHttpException(json_encode($store->errors) ?: 'Could not create store.');
        }

        return $store;
    }

    public function actionStoresUpdate($id)
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        $store = Store::findOne(['id' => (int) $id, 'merchant_id' => $merchant_id]);
        if ($store === null) {
            throw new NotFoundHttpException('Store not found.');
        }

        $body = Yii::$app->request->getBodyParams();
        $store->load($body, '');
        $store->allow_update = true;
        $store->allow_delete = true;

        if (!$store->save()) {
            throw new BadRequestHttpException(json_encode($store->errors) ?: 'Could not update store.');
        }

        return $store;
    }

    public function actionStore()
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        $store_id = (int) Yii::$app->request->get('id', 0);
        if ($store_id <= 0) {
            throw new BadRequestHttpException('Store id is required.');
        }

        $store = Store::findOne(['id' => $store_id, 'merchant_id' => $merchant_id]);
        if ($store === null) {
            throw new NotFoundHttpException('Store not found.');
        }

        return $store;
    }

    private function buildOrderLineItems(Order $order): array
    {
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

        return $items;
    }

    /**
     * @param Order[] $orders
     * @return list<array<string, mixed>>
     */
    private function ordersToRows(array $orders): array
    {
        $out = [];
        foreach ($orders as $order) {
            /** @var Order $order */
            $row = $order->toArray();
            $row['item_count'] = (int) Orderproduct::find()
                ->where(['order_id' => $order->id])
                ->sum('quantity');
            $row['customer_display_name'] = $order->getCustomerName() ?? '';
            $row['customer_email'] = $order->getCustomerEmail() ?? '';
            $out[] = $row;
        }
        return $out;
    }

    public function actionOrders()
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        $store_id = (int) Yii::$app->request->get('store', 0);
        if ($store_id <= 0) {
            throw new BadRequestHttpException('store query param is required.');
        }

        $store = Store::findOne(['id' => $store_id, 'merchant_id' => $merchant_id]);
        if ($store === null) {
            throw new ForbiddenHttpException('Not your store.');
        }

        $orders = Order::find()
            ->where(['store_id' => $store_id])
            ->with('customer')
            ->orderBy(['placed_at' => SORT_DESC])
            ->all();
        return $this->ordersToRows($orders);
    }

    public function actionOrdersAll()
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        $store_ids = Store::find()
            ->select('id')
            ->where(['merchant_id' => $merchant_id])
            ->column();

        if (empty($store_ids)) {
            return [];
        }

        $orders = Order::find()
            ->where(['store_id' => $store_ids])
            ->with('customer')
            ->orderBy(['placed_at' => SORT_DESC])
            ->all();

        return $this->ordersToRows($orders);
    }

    public function actionOrderView($id)
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        $order = Order::find()
            ->where(['id' => (int) $id])
            ->with('customer')
            ->one();
        if ($order === null) {
            throw new NotFoundHttpException('Order not found.');
        }

        $store = Store::findOne(['id' => $order->store_id, 'merchant_id' => $merchant_id]);
        if ($store === null) {
            throw new ForbiddenHttpException('Not your order.');
        }

        $items = $this->buildOrderLineItems($order);

        return [
            'id' => $order->id,
            'store_id' => $order->store_id,
            'customer_id' => $order->customer_id,
            'status' => $order->status,
            'price_total' => (float) $order->price_total,
            'placed_at' => $order->placed_at,
            'items' => $items,
            'customer_display_name' => $order->getCustomerName() ?? '',
            'customer_email' => $order->getCustomerEmail() ?? '',
        ];
    }

    public function actionOrderStatus($id)
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        $order = Order::findOne(['id' => (int) $id]);
        if ($order === null) {
            throw new NotFoundHttpException('Order not found.');
        }

        $store = Store::findOne(['id' => $order->store_id, 'merchant_id' => $merchant_id]);
        if ($store === null) {
            throw new ForbiddenHttpException('Not your order.');
        }

        $body = Yii::$app->request->getBodyParams();
        $status = (string) ($body['status'] ?? '');
        if ($status !== 'shipped') {
            throw new BadRequestHttpException("Only status='shipped' is supported here.");
        }

        if ($order->status !== Order::STATUS_PAID) {
            throw new BadRequestHttpException('Only paid orders can be marked as shipped.');
        }

        $order->status = Order::STATUS_SHIPPED;
        if (!$order->save()) {
            throw new BadRequestHttpException(json_encode($order->errors));
        }

        return $order;
    }

    public function actionProducts()
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;
        $body = Yii::$app->request->getBodyParams();

        $store_id = (int) ($body['store_id'] ?? 0);
        if ($store_id <= 0) {
            throw new BadRequestHttpException('store_id is required.');
        }

        $store = Store::findOne(['id' => $store_id, 'merchant_id' => $merchant_id]);
        if ($store === null) {
            throw new ForbiddenHttpException('Not your store.');
        }

        $product = new Product();
        $product->load($body, '');
        $product->store_id = $store_id;
        $product->allow_update = true;
        $product->allow_delete = true;
        if ($product->thumbnail === null || trim((string) $product->thumbnail) === '') {
            $product->thumbnail = '/images/product-placeholder.svg';
        }
        if ($product->is_active === null) {
            $product->is_active = true;
        }

        if (!$product->save()) {
            throw new BadRequestHttpException(json_encode($product->errors));
        }

        return $product;
    }

    public function actionProductsList()
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        $store_id = (int) Yii::$app->request->get('store', 0);
        if ($store_id <= 0) {
            throw new BadRequestHttpException('store query param is required.');
        }

        $store = Store::findOne(['id' => $store_id, 'merchant_id' => $merchant_id]);
        if ($store === null) {
            throw new ForbiddenHttpException('Not your store.');
        }

        return Product::find()
            ->where(['store_id' => $store_id])
            ->orderBy(['id' => SORT_DESC])
            ->all();
    }

    public function actionProductView($id)
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        $product = Product::findOne(['id' => (int) $id]);
        if ($product === null) {
            throw new NotFoundHttpException('Product not found.');
        }

        $store = Store::findOne(['id' => $product->store_id, 'merchant_id' => $merchant_id]);
        if ($store === null) {
            throw new ForbiddenHttpException('Not your product.');
        }

        return $product;
    }

    public function actionProductUpdate($id)
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        $product = Product::findOne(['id' => (int) $id]);
        if ($product === null) {
            throw new NotFoundHttpException('Product not found.');
        }

        $store = Store::findOne(['id' => $product->store_id, 'merchant_id' => $merchant_id]);
        if ($store === null) {
            throw new ForbiddenHttpException('Not your product.');
        }

        $body = Yii::$app->request->getBodyParams();
        $product->load($body, '');
        $product->allow_update = true;
        $product->allow_delete = true;
        if ($product->thumbnail === null || trim((string) $product->thumbnail) === '') {
            $product->thumbnail = '/images/product-placeholder.svg';
        }
        if ($product->is_active === null) {
            $product->is_active = true;
        }

        if (!$product->save()) {
            throw new BadRequestHttpException(json_encode($product->errors));
        }

        return $product;
    }

    public function actionDeleteProduct($id)
    {
        $this->requireRole('merchant');
        $merchant_id = (int) Yii::$app->user->id;

        $product = Product::findOne(['id' => (int) $id]);
        if ($product === null) {
            throw new NotFoundHttpException('Product not found.');
        }

        $store = Store::findOne(['id' => $product->store_id, 'merchant_id' => $merchant_id]);
        if ($store === null) {
            throw new ForbiddenHttpException('Not your product.');
        }

        $product->delete();

        return ['ok' => true];
    }
}
