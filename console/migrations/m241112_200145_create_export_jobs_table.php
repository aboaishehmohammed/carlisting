<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%export_jobs}}`.
 */
class m241112_200145_create_export_jobs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%export_jobs}}', [
            'id' => $this->primaryKey(),
            'status' => "ENUM('pending', 'completed', 'failed') NOT NULL DEFAULT 'pending'",
            'file_path' => $this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%export_jobs}}');
    }
}
