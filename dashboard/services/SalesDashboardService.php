<?php

namespace dashboard\services;

use common\models\CarListing;
use Yii;

class SalesDashboardService
{
    public static function getTotalSales()
    {
        return (new \yii\db\Query())
            ->from('car_listing')
            ->where(['status' => CarListing::STATUS_SOLD])
            ->count();
    }

    public static function getTotalRevenue()
    {
        return (new \yii\db\Query())
            ->from('car_listing')
            ->where(['status' => CarListing::STATUS_SOLD])
            ->sum('price');
    }

    public static function getMostSalesModels()
    {
        return (new \yii\db\Query())
            ->select(['model', 'COUNT(model) AS sales_count'])
            ->from('car_listing')
            ->where(['status' => 'sold'])
            ->groupBy('model')
            ->orderBy(['sales_count' => SORT_DESC])
            ->limit(5)
            ->all();
    }

    public static function getPopularModels()
    {
        return (new \yii\db\Query())
            ->select(['model', 'COUNT(*) AS model_count'])
            ->from('car_listing')
            ->groupBy('model')
            ->orderBy(['model_count' => SORT_DESC])
            ->limit(5)
            ->all();
    }
}
