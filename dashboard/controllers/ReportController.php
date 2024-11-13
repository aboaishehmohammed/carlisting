<?php

namespace dashboard\controllers;

use common\models\User;
use Yii;
use dashboard\models\ExportFilterForm;
use dashboard\models\ExportJob;
use dashboard\services\ExportService;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ReportController extends Controller
{
    private ExportService $exportService;

    public function __construct($id, $module, $config = [])
    {
        $this->exportService = new ExportService();
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['export-list', 'export', 'download'],
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
                    'download' => ['get'],
                    'export' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ExportJob::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $filterModel = new ExportFilterForm();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'filterModel' => $filterModel
        ]);
    }

    public function actionGenerateReport()
    {
        $filterModel = new ExportFilterForm();

        if (Yii::$app->request->isPost) {
            // Load the submitted data
            $filterModel->load(Yii::$app->request->post());

            // If the form is valid, create the export job
            if ($filterModel->validate() && $this->exportService->createExportJob($filterModel->attributes)) {
                Yii::$app->session->setFlash('success', 'Export job created and added to the queue.');
                return $this->redirect(['index']);
            } else {
                Yii::$app->session->setFlash('error', 'Failed to create export job.');
            }
        }

        $buyers = User::find()
            ->where(['role' => User::ROLE_BUYER])
            ->select(['id', 'username'])
            ->asArray()
            ->all();

        $buyersList = ArrayHelper::map($buyers, 'id', 'username');
        return $this->render('generate-report', [
            'filterModel' => $filterModel,
            'buyersList'   => $buyersList
        ]);
    }

    public function actionDownload($file)
    {
        $filePath = Yii::getAlias('@exports/' . basename($file));
        if (file_exists($filePath)) {
            return Yii::$app->response->sendFile($filePath);
        }

        throw new NotFoundHttpException('The requested file does not exist.');
    }
}
