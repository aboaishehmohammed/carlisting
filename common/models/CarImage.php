<?php
namespace common\models;

use yii\db\ActiveRecord;

class CarImage extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%car_image}}';
    }

    public function rules()
    {
        return [
            [['car_listing_id', 'image_path', 'created_at'], 'required'],
            [['car_listing_id', 'created_at'], 'integer'],
            [['image_path'], 'string', 'max' => 255],
        ];
    }

    public function getCarListing()
    {
        return $this->hasOne(CarListing::class, ['id' => 'car_listing_id']);
    }
}
