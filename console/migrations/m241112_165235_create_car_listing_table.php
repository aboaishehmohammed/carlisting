<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cars}}`.
 */
class m241112_165235_create_car_listing_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_listing}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'make' => $this->string()->notNull(),
            'model' => $this->string()->notNull(),
            'year' => $this->integer()->notNull(),
            'price' => $this->decimal(10, 2)->notNull(),
            'mileage' => $this->integer(),
            'description' => $this->text(),
            'status' => "ENUM('available', 'sold') DEFAULT 'available'",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%CarListing}}');
    }
}
