<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="container mt-4">
    <span class=" mb-3" type="button" data-bs-toggle="collapse" data-bs-target="#filterCollapse" aria-expanded="false" aria-controls="filterCollapse">
        Show Filters
    </span>

    <div class="collapse" id="filterCollapse">
        <div class="card card-body">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($searchModel, 'title')->textInput(['placeholder' => 'Title']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($searchModel, 'make')->textInput(['placeholder' => 'Make']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($searchModel, 'mileage')->textInput(['placeholder' => 'Mileage']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($searchModel, 'model')->textInput(['placeholder' => 'Model']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($searchModel, 'year')->textInput(['placeholder' => 'Year']) ?>
                </div>
                <div class="col-md-4">
                    <?= $form->field($searchModel, 'price')->textInput(['placeholder' => 'Price']) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($searchModel, 'status')->dropDownList([
                        'available' => 'Available',
                        'sold' => 'Sold',
                    ], ['prompt' => 'Select Status']) ?>
                </div>
            </div>

            <div class="form-group mt-3">
                <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
