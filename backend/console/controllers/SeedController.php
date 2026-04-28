<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use console\seeders\UserAddressSeeder;
use console\seeders\CatalogSeeder;
use console\seeders\BasketSeeder;
use console\seeders\OrderSeeder;

class SeedController extends Controller
{
    /**
     * Seeds: user, address, user_address.
     *
     * php yii seed/user-addresses
     */
    public function actionUserAddresses(int $debug = 1, int $batch_size = 25, int $count = 10, $seed = null): void
    {
        $seeder = new UserAddressSeeder(Yii::$app->db, $seed !== null ? (int) $seed : null);
        $seeder->seed($debug, $batch_size, $count);
    }

    /**
     * Seeds: store, product_category, product.
     *
     * php yii seed/catalog
     */
    public function actionCatalog(int $debug = 1, int $batch_size = 25, int $count = 10, $seed = null): void
    {
        $seeder = new CatalogSeeder(Yii::$app->db, $seed !== null ? (int) $seed : null);
        $seeder->seed($debug, $batch_size, $count);
    }

    /**
     * Seeds: basket, basket_product.
     *
     * php yii seed/baskets
     */
    public function actionBaskets(int $debug = 1, int $batch_size = 25, int $count = 10, $seed = null): void
    {
        $seeder = new BasketSeeder(Yii::$app->db, $seed !== null ? (int) $seed : null);
        $seeder->seed($debug, $batch_size, $count);
    }

    /**
     * Seeds: order, order_product.
     *
     * php yii seed/orders
     */
    public function actionOrders(int $debug = 1, int $batch_size = 25, int $count = 10, $seed = null): void
    {
        $seeder = new OrderSeeder(Yii::$app->db, $seed !== null ? (int) $seed : null);
        $seeder->seed($debug, $batch_size, $count);
    }

    /**
     * Seeds all core graphs in dependency order.
     *
     * php yii seed/all
     */
    public function actionAll(int $debug = 1, int $batch_size = 25, int $count = 10, $seed = null): void
    {
        $this->actionUserAddresses($debug, $batch_size, $count, $seed);
        $this->actionCatalog($debug, $batch_size, $count, $seed);
        $this->actionBaskets($debug, $batch_size, $count, $seed);
        $this->actionOrders($debug, $batch_size, $count, $seed);
    }
}

// php yii seed/all
