<?php

namespace dashboard\services;

namespace dashboard\services;

use common\models\CarImage;
use common\models\CarListing;
use Yii;

class ImageService
{
    public static function saveImages(CarListing $carListing)
    {
        $imageDir = Yii::getAlias('@webroot/uploads/car_images');
        if (!is_dir($imageDir)) {
            mkdir($imageDir, 0777, true);
        }

        foreach ($carListing->imageFiles as $file) {
            $filePath = $imageDir . '/' . uniqid() . '.' . $file->extension;
            if ($file->saveAs($filePath)) {
                $carImage = new CarImage();
                $carImage->car_listing_id = $carListing->id;
                $carImage->image_path = 'uploads/car_images/' . basename($filePath);
                $carImage->created_at = time();
                $carImage->save(false);
            }
        }
    }

    public static function deleteOldImages($images)
    {
        foreach ($images as $image) {
            $filePath = Yii::getAlias('@webroot/' . $image->image_path);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            $image->delete();
        }
    }
}
