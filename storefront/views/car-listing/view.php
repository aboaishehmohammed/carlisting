<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $model common\models\CarListing */
$this->title = $model->title;
?>

<h1><?= Html::encode($this->title) ?></h1>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'title',
        'make',
        'model',
        'year',
        'price',
        'mileage',
        'description',
    ],
]) ?>

<?php if ($model->status == 'available'): ?>
    <?= Html::beginForm(['car-listing/purchase', 'id' => $model->id], 'post') ?>
    <?= Html::submitButton('Purchase', ['class' => 'btn btn-success', 'name' => 'purchase']) ?>
    <?= Html::endForm() ?>
<?php else: ?>
    <p class="text-danger">This car has already been sold.</p>
<?php endif; ?>
