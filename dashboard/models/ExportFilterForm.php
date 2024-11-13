<?php

namespace dashboard\models;

use yii\base\Model;

class ExportFilterForm extends Model
{
    public $make;
    public $model;
    public $year;
    public $status;
    public $buyer_id;

    public function rules()
    {
        return [
            [['make', 'model', 'status'], 'string'],
            [['year', 'buyer_id'], 'integer'],
        ];
    }
}
