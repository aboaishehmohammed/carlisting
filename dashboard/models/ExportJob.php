<?php

namespace dashboard\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class ExportJob extends ActiveRecord
{
    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    public static function tableName()
    {
        return 'export_jobs';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

}
