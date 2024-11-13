<?php
namespace dashboard\controllers;

use common\models\CarListing;
use common\models\CarListingSearch;
use dashboard\services\SalesDashboardService;
use dashboard\services\ImageService;
use dashboard\repositories\CarListingRepository;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

class CarListingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->identity->isAdmin();
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CarListingSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionCreate()
    {
        $model = new CarListing();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
                ImageService::saveImages($model);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $existingImages = $model->images;

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            $model->imageFiles = UploadedFile::getInstances($model, 'imageFiles');
            if (!empty($model->imageFiles)) {
                ImageService::deleteOldImages($existingImages);
                ImageService::saveImages($model);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        CarListingRepository::delete($model);
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = CarListingRepository::findById($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionSales()
    {
        $totalSales = SalesDashboardService::getTotalSales();
        $totalRevenue = SalesDashboardService::getTotalRevenue();
        $mostSalesModels = SalesDashboardService::getMostSalesModels();
        $popularModels = SalesDashboardService::getPopularModels();

        return $this->render('sales', [
            'totalSales' => $totalSales,
            'totalRevenue' => $totalRevenue,
            'popularModels' => $popularModels,
            'mostSalesModels' => $mostSalesModels,
        ]);
    }
}
