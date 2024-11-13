<?php

use common\models\CarListing;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\LinkPager;

/** @var yii\web\View $this */
/** @var common\models\CarListingSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Car Listings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-listing-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div>
        <?= Html::a('Create Car', ['create'], ['class' => 'btn btn-success']) ?>
        <?= $this->render('_search', ['searchModel' => $searchModel]); ?>
    </div>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'make',
            'model',
            'year',
            'price',
            'mileage',
            'status',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, CarListing $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
        'pager' => [
            'class' => LinkPager::class,
            'pagination' => $dataProvider->pagination,
            'maxButtonCount' => 5,
            'firstPageLabel' => 'First',
            'lastPageLabel' => 'Last',
            'nextPageLabel' => '→',
            'prevPageLabel' => '←',
            'options' => [
                'class' => 'pagination pagination-sm', // Smaller pagination size
            ],
            'linkOptions' => [
                'class' => 'page-link', // Styling links as Bootstrap pagination
            ],
            'pageCssClass' => 'page-item', // Styling page numbers
            'disabledPageCssClass' => 'd-none', // Styling disabled buttons
        ],    ]); ?>


</div>
