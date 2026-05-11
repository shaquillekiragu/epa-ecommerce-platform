<?php

namespace api\controllers;

use Yii;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use api\models\Order;
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

        return Order::find()
            ->where(['store_id' => $store_id])
            ->orderBy(['placed_at' => SORT_DESC])
            ->all();
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

        $order->status = 'shipped';
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
