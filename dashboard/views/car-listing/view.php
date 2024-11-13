<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var common\models\CarListing $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Car Listings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="car-listing-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'make',
            'model',
            'year',
            'price',
            'mileage',
            'description:ntext',
            'status',
            [
                'label' => 'Images',
                'format' => 'raw',
                'value' => function ($model) {
                    $imagesHtml = '';
                    foreach ($model->images as $image) {
                        $imagesHtml .= Html::img('@web/' . $image->image_path, ['style' => 'width:150px; margin-right: 10px;']);
                    }
                    return $imagesHtml;
                },
            ],
        ],
    ]) ?>

</div>
