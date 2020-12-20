<?php

use yii\db\Migration;

/**
 * Class m201220_142246_alter_column_car__is_on_parking
 */
class m201220_142246_alter_column_car__is_on_parking extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m201220_142246_alter_column_car__is_on_parking cannot be reverted.\n";

        return false;
    }

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->alterColumn('car', 'is_on_parking', $this->boolean()->notNull()->defaultValue(true));
    }

    public function down()
    {
        echo "m201220_142246_alter_column_car__is_on_parking cannot be reverted.\n";

        return false;
    }
}
