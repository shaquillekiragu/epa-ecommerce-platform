<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
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

    // php yii seed/all

    /**
     * Clears all domain tables that seeders populate.
     *
     * Use: php yii seed/clear-all 1
     */
    public function actionClearAll(int $force = 0): void
    {
        if ($force !== 1) {
            Console::output('Refusing to clear tables without force=1.');
            Console::output('Run: php yii seed/clear-all 1');
            return;
        }

        $db = Yii::$app->db;

        // Only clear core domain tables, not RBAC/migration meta tables.
        $tables = [
            '{{%order_product}}',
            '{{%order}}',
            '{{%basket_product}}',
            '{{%basket}}',
            '{{%product}}',
            '{{%store}}',
            '{{%product_category}}',
            '{{%user_address}}',
            '{{%address}}',
            '{{%user}}',
        ];

        $tx = $db->beginTransaction();

        try {
            $driver = $db->driverName;

            if ($driver === 'mysql') {
                $db->createCommand('SET FOREIGN_KEY_CHECKS=0')->execute();
            }

            Console::output('Clearing tables...');
            Console::startProgress(0, count($tables));

            $done = 0;
            foreach ($tables as $table) {
                $schema = $db->schema->getTableSchema($table, true);
                if ($schema !== null) {
                    $db->createCommand()->truncateTable($table)->execute();
                }

                $done++;
                Console::updateProgress($done, count($tables));
            }

            Console::endProgress();

            if ($driver === 'mysql') {
                $db->createCommand('SET FOREIGN_KEY_CHECKS=1')->execute();
            }

            $tx->commit();
            Console::output('Done.');
        } catch (\Throwable $e) {
            $tx->rollBack();

            try {
                if ($db->driverName === 'mysql') {
                    $db->createCommand('SET FOREIGN_KEY_CHECKS=1')->execute();
                }
            } catch (\Throwable $ignored) {
                // ignore
            }

            throw $e;
        }
    }
}
