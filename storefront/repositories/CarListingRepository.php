<?php
namespace storefront\repositories;

use common\models\CarListing;
use storefront\models\CarSearchForm;
use yii\data\ActiveDataProvider;

class CarListingRepository
{
    /**
     * Find an available car by ID.
     *
     * @param int $id
     * @return CarListing|null
     */
    public function findAvailableCar($id)
    {
        return CarListing::findOne(['id' => $id, 'status' => 'available']);
    }

    /**
     * Get a data provider for listing cars based on search criteria.
     *
     * @param array $queryParams
     * @return array
     */
    public function searchCars(array $queryParams)
    {
        $searchModel = new CarSearchForm();
        return [
            'dataProvider' =>$searchModel->search($queryParams),
            'searchModel' =>$searchModel
        ];
    }

    /**
     * Save a car listing purchase by updating its status and buyer ID.
     *
     * @param CarListing $car
     * @param int $buyerId
     * @return bool
     */
    public function markAsSold(CarListing $car, $buyerId)
    {
        $car->buyer_id = $buyerId;
        $car->status = 'sold';
        return $car->save();
    }

    /**
     * Find cars purchased by a specific user.
     *
     * @param int $userId
     * @return \yii\db\ActiveQuery
     */
    public function findByBuyerId($buyerId)
    {
        return CarListing::find()
            ->joinWith('buyer')
            ->where(['buyer_id' => $buyerId]);
    }

    /**
     * Get an ActiveDataProvider for cars based on the query.
     *
     * @param \yii\db\ActiveQuery $query
     * @param int $pageSize
     * @return ActiveDataProvider
     */
    public function getDataProvider($query, $pageSize = 10)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
    }
}
