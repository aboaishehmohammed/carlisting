<?php
namespace storefront\services;

use storefront\repositories\CarListingRepository;
use Yii;
use common\models\CarListing;
use yii\data\ActiveDataProvider;

class CarListingService
{
    private $CarListingRepository;

    public function __construct(CarListingRepository $CarListingRepository)
    {
        $this->CarListingRepository = $CarListingRepository;
    }

    /**
     * Get the data provider for car listings with search filters.
     *
     * @param array $queryParams
     * @return array
     */
    public function getCarListings(array $queryParams)
    {
        return $this->CarListingRepository->searchCars($queryParams);
    }

    /**
     * Find an available car by ID.
     *
     * @param int $id
     * @return CarListing|null
     */
    public function findAvailableCar($id)
    {
        return $this->CarListingRepository->findAvailableCar($id);
    }

    /**
     * Purchase a car by marking it as sold and assigning the buyer.
     *
     * @param int $carId
     * @param int $buyerId
     * @return bool
     */
    public function purchaseCar($carId, $buyerId)
    {
        $car = $this->CarListingRepository->findAvailableCar($carId);
        if ($car === null) {
            return false;
        }
        return $this->CarListingRepository->markAsSold($car, $buyerId);
    }


    /**
     * Get the list of cars purchased by a user with pagination.
     *
     * @param int $userId
     * @param int $pageSize
     * @return ActiveDataProvider
     */
    public function getCarsByBuyer($userId, $pageSize = 10)
    {
        $query = $this->CarListingRepository->findByBuyerId($userId);
        return $this->CarListingRepository->getDataProvider($query, $pageSize);
    }
}
