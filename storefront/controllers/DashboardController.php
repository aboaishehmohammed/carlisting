<?php
namespace storefront\controllers;

use storefront\services\CarListingService;
use Yii;
use yii\web\Controller;
use common\models\CarListing;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

class DashboardController extends Controller
{
    protected $carListingService;

    public function __construct($id, $module, CarListingService $carListingService, $config = [])
    {
        $this->carListingService = $carListingService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $userId = Yii::$app->user->id;
        $dataProvider = $this->carListingService->getCarsByBuyer($userId);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }}
