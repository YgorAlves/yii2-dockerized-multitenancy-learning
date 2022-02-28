<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tenants}}`.
 */
class m220224_225432_create_tenants_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_bin ENGINE=InnoDB';
        }

        $this->createTable('{{%tenants}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'domain' => $this->string()->unique()->notNull(),
            'database' => $this->string()->unique()->notNull(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tenants}}');
    }
}
