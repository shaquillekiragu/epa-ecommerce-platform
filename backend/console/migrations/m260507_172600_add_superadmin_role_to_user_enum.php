<?php

use yii\db\Migration;

class m260507_172600_add_superadmin_role_to_user_enum extends Migration
{
    public function safeUp()
    {
        // MySQL enum alteration. If you use Postgres/SQLite in other envs, adjust accordingly.
        if ($this->db->driverName !== 'mysql') {
            return true;
        }

        $this->execute('ALTER TABLE {{%user}} MODIFY COLUMN role enum("customer","merchant","superadmin") NOT NULL DEFAULT "customer"');
    }

    public function safeDown()
    {
        if ($this->db->driverName !== 'mysql') {
            return true;
        }

        // Revert to original enum values; any existing superadmin rows must be migrated manually before downgrade.
        $this->execute('ALTER TABLE {{%user}} MODIFY COLUMN role enum("customer","merchant") NOT NULL DEFAULT "customer"');
    }
}
