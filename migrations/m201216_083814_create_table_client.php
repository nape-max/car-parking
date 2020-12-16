<?php

use yii\db\Migration;

/**
 * Class m201216_083814_create_table_client
 */
class m201216_083814_create_table_client extends Migration
{
    // /**
    //  * {@inheritdoc}
    //  */
    // public function safeUp()
    // {

    // }

    // /**
    //  * {@inheritdoc}
    //  */
    // public function safeDown()
    // {
    //     echo "m201216_083814_create_table_client cannot be reverted.\n";

    //     return false;
    // }

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('client', [
            'id' => $this->primaryKey(),
            'full_name' => $this->string()->notNull(),
            'gender' => $this->string(1)->notNull(),
            'phone' => $this->string(20)->notNull(),
            'address' => $this->string(),
        ]);
    }

    public function down()
    {
        $this->dropTable('client');
    }
}
