<?php

use yii\db\Migration;

/**
 * Class m241112_191351_modify_buyer_id_in_car_listing_table
 */
class m241112_191351_modify_buyer_id_in_car_listing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%car_listing}}', 'buyer_id', $this->integer()->null());

        $this->addForeignKey(
            'fk-car_listing-buyer_id',
            '{{%car_listing}}',
            'buyer_id',
            '{{%user}}',
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241112_191351_modify_buyer_id_in_car_listing_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241112_191351_modify_buyer_id_in_car_listing_table cannot be reverted.\n";

        return false;
    }
    */
}
