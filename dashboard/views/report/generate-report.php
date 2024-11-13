<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Generate Report';

?>

<div class="container mt-4">
    <h1><?= Html::encode($this->title) ?></h1>
        <div class="card card-body">
            <?php $form = ActiveForm::begin([
                'action' => ['generate-report'],
                'method' => 'post',
                'options' => ['class' => 'form-horizontal'],
            ]); ?>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($filterModel, 'buyer_id')->dropDownList($buyersList, [
                        'prompt' => 'Select Buyer'
                    ])->label('Buyer') ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($filterModel, 'make')->textInput(['placeholder' => 'Enter make']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($filterModel, 'model')->textInput(['placeholder' => 'Enter model']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($filterModel, 'year')->textInput(['placeholder' => 'Enter year']) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($filterModel, 'status')->dropDownList([
                        'available' => 'Available',
                        'sold' => 'Sold',
                    ], ['prompt' => 'Select Status']) ?>
                </div>
            </div>
            <div class="form-group mt-3">
                <?= Html::submitButton('Generate report', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
</div>
