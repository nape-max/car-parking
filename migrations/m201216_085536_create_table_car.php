<?php

use yii\db\Migration;

/**
 * Class m201216_085536_create_table_car
 */
class m201216_085536_create_table_car extends Migration
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
    //     echo "m201216_085536_create_table_car cannot be reverted.\n";

    //     return false;
    // }

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('car', [
            'id' => $this->primaryKey(),
            'brand' => $this->string()->notNull(),
            'model' => $this->string()->notNull(),
            'color' => $this->string()->notNull(),
            'license_plate_number' => $this->string()->notNull()->unique(),
            'is_on_parking' => $this->boolean()->notNull(),
            'client_id' => $this->integer(),
        ]);

        $this->createIndex(
            'idx-car-client_id',
            'car',
            'client_id',
        );

        $this->addForeignKey(
            'fk-car-client_id',
            'car',
            'client_id',
            'client',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-car-client_id',
            'client'
        );

        $this->dropIndex(
            'idx-car-client_id',
            'car'
        );

        $this->dropTable('car');
    }
}
