<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $model common\models\CarListing */
?>

<div class="card h-100 shadow-sm border-0 rounded">
    <div class="card-body">
        <h5 class="card-title"><?= Html::encode($model->title) ?></h5>
        <p class="card-text"><strong>Make:</strong> <?= Html::encode($model->make) ?></p>
        <p class="card-text"><strong>Model:</strong> <?= Html::encode($model->model) ?></p>
        <p class="card-text"><strong>Year:</strong> <?= Html::encode($model->year) ?></p>
        <p class="card-text"><strong>Price:</strong> $<?= Html::encode(number_format($model->price, 2)) ?></p>
    </div>
</div>
