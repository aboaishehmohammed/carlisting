<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "cars".
 *
 * @property int $id
 * @property string $title
 * @property string $make
 * @property string $model
 * @property int $year
 * @property float $price
 * @property int|null $mileage
 * @property string|null $description
 * @property string|null $status
 * @property int $created_at
 * @property int $updated_at
 */
class CarListing extends \yii\db\ActiveRecord
{
    const STATUS_AVAILABLE = 'available';
    const STATUS_SOLD = 'sold';
    public $imageFiles;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'car_listing';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'make', 'model', 'year', 'price'], 'required'],
            [['year', 'mileage', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['imageFiles'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 3],
            ['status', 'default', 'value' => self::STATUS_AVAILABLE],
            ['status', 'in', 'range' => [ self::STATUS_AVAILABLE,  self::STATUS_SOLD]],
            [['description', 'status'], 'string'],
            [['title', 'make', 'model'], 'string', 'max' => 255],
        ];
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'make' => 'Make',
            'model' => 'Model',
            'year' => 'Year',
            'price' => 'Price',
            'mileage' => 'Mileage',
            'description' => 'Description',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getBuyer()
    {
        return $this->hasOne(User::class, ['id' => 'buyer_id']);
    }

    public function getImages()
    {
        return $this->hasMany(CarImage::class, ['car_listing_id' => 'id']);
    }
}
