<?php

namespace dashboard\repositories;

use common\models\CarListing;

class CarListingRepository
{
    public static function findById($id)
    {
        return CarListing::findOne(['id' => $id]);
    }

    public static function delete(CarListing $carListing)
    {
        $carListing->delete();
    }
}
