<?php

namespace console\controllers;

use Yii;
use console\seeders\UserAddressSeeder;
use yii\console\Controller;

class SeedController extends Controller
{
    public function actionUsers(int $debug = 1, int $batch_size = 25, int $count = 10, $seed = null): void
    {
        $seeder = new UserAddressSeeder(Yii::$app->db, $seed !== null ? (int) $seed : null);
        $seeder->seed($debug, $batch_size, $count);
    }
}

// Future seeders:
// - catalog (store + product_category + product)
// - basket (basket + basket_product)
// - orders (order + order_product)
