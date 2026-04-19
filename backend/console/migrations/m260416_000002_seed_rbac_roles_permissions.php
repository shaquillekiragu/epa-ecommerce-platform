<?php

use yii\db\Migration;
use yii\rbac\DbManager;

/**
 * Seeds RBAC roles/permissions and initial assignments.
 */
class m260416_000002_seed_rbac_roles_permissions extends Migration
{
    public function safeUp()
    {
        /** @var DbManager $auth */
        $auth = Yii::$app->authManager;

        // Roles
        $customer = $auth->createRole('customer');
        $customer->description = 'Customer';
        $auth->add($customer);

        $merchant = $auth->createRole('merchant');
        $merchant->description = 'Merchant';
        $auth->add($merchant);

        $superadmin = $auth->createRole('superadmin');
        $superadmin->description = 'Superadmin';
        $auth->add($superadmin);

        // Permissions
        $manageUsers = $auth->createPermission('manageUsers');
        $manageUsers->description = 'Manage users';
        $auth->add($manageUsers);

        $manageOrders = $auth->createPermission('manageOrders');
        $manageOrders->description = 'Manage orders';
        $auth->add($manageOrders);

        $manageBaskets = $auth->createPermission('manageBaskets');
        $manageBaskets->description = 'Manage baskets';
        $auth->add($manageBaskets);

        $manageProducts = $auth->createPermission('manageProducts');
        $manageProducts->description = 'Manage products';
        $auth->add($manageProducts);

        $manageStores = $auth->createPermission('manageStores');
        $manageStores->description = 'Manage stores';
        $auth->add($manageStores);

        // Role → permissions
        $auth->addChild($customer, $manageBaskets);
        $auth->addChild($customer, $manageOrders);

        $auth->addChild($merchant, $manageProducts);
        $auth->addChild($merchant, $manageOrders);
        $auth->addChild($merchant, $manageStores);

        // Superadmin inherits all other roles, plus extras
        $auth->addChild($superadmin, $customer);
        $auth->addChild($superadmin, $merchant);

        $auth->addChild($superadmin, $manageUsers);

        // Assign roles to existing users based on user.role column
        $rows = (new \yii\db\Query())
            ->select(['id', 'role'])
            ->from('{{%user}}')
            ->all($this->db);

        foreach ($rows as $row) {
            $userId = (string) $row['id'];
            $dbRole = $row['role'];

            if ($dbRole === 'merchant') {
                $auth->assign($merchant, $userId);
            } else {
                $auth->assign($customer, $userId);
            }
        }

        // If user id 1 exists, also grant superadmin
        $user1Exists = (new \yii\db\Query())
            ->from('{{%user}}')
            ->where(['id' => 1])
            ->exists($this->db);

        if ($user1Exists) {
            $auth->assign($superadmin, '1');
        }
    }

    public function safeDown()
    {
        /** @var DbManager $auth */
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}

