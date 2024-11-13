<?php
namespace storefront\controllers;

use Yii;
use storefront\services\CarListingService;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

class CarListingController extends Controller
{
    private $carListingService;

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
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'purchase'],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isBuyer();
                        },
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $data = $this->carListingService->getCarListings(Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $data['dataProvider'],
            'searchModel' => $data['searchModel'],
        ]);
    }

    public function actionView($id)
    {
        $model = $this->carListingService->findAvailableCar($id);

        if (!$model) {
            throw new NotFoundHttpException("Car not found or already sold.");
        }

        return $this->render('view', ['model' => $model]);
    }

    public function actionPurchase($id)
    {
        if ($this->carListingService->purchaseCar($id, Yii::$app->user->id)) {
            Yii::$app->session->setFlash('success', 'Car purchased successfully!');
        } else {
            Yii::$app->session->setFlash('error', 'Failed to purchase the car. Please try again.');
        }

        return $this->redirect(['index']);
    }
}
