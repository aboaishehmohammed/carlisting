<?php

use yii\db\Migration;

/**
 * Class m241112_161459_add_role_column_to_user
 */
class m241112_161459_add_role_column_to_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%user}}', 'role', "ENUM('admin', 'buyer') NOT NULL DEFAULT 'buyer'");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m241112_161459_add_role_column_to_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241112_161459_add_role_column_to_user cannot be reverted.\n";

        return false;
    }
    */
}
