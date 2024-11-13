<?php
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = 'Reports list';

?>

<div class="container mt-4">
    <h1><?= Html::encode($this->title) ?></h1>
<?=  Html::a('Export a report', ['generate-report'], [
    'class' => 'btn btn-info mb-3',
    'role' => 'button'
]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'status',
            [
                'attribute' => 'file_path',
                'label' => 'Download',
                'format' => 'raw',
                'enableSorting' => false,
                'value' => function ($model) {
                    return $model->status === 'completed' ? Html::a('Download', Url::to(['download', 'file' => $model->file_path]), ['target' => '_blank']) : '-';
                },
            ]
        ],
    ]); ?>
</div>
