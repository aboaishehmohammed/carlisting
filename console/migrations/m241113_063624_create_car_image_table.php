<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car_image}}`.
 */
class m241113_063624_create_car_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car_image}}', [
            'id' => $this->primaryKey(),
            'car_listing_id' => $this->integer()->notNull(),
            'image_path' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-car_image-car_listing_id', '{{%car_image}}', 'car_listing_id');
        $this->addForeignKey(
            'fk-car_image-car_listing_id',
            '{{%car_image}}',
            'car_listing_id',
            '{{%car_listing}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-car_image-car_listing_id', '{{%car_image}}');
        $this->dropTable('{{%car_image}}');
    }
}
