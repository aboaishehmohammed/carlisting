<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;

?>

<div class="container mt-4">
    <h1 class="mb-4">Available Cars</h1>

    <div class="accordion mb-4" id="searchAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="searchHeading">
                <button class="accordion-button collapsed" type="button"
                        data-bs-toggle="collapse" data-bs-target="#searchForm" aria-expanded="false"
                        aria-controls="searchForm">
                    Search Filters
                </button>
            </h2>
            <div id="searchForm" class="accordion-collapse collapse" aria-labelledby="searchHeading"
                 data-bs-parent="#searchAccordion">
                <div class="accordion-body bg-light rounded border">
                    <?php $form = ActiveForm::begin([
                        'method' => 'get',
                        'options' => ['class' => 'g-3'],
                        'fieldConfig' => [
                            'template' => "{label}\n{input}\n{error}",
                            'labelOptions' => ['class' => 'form-label'],
                            'inputOptions' => ['class' => 'form-control'],
                            'errorOptions' => ['class' => 'invalid-feedback'],
                        ],
                    ]); ?>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($searchModel, 'make')->textInput(['placeholder' => 'Make']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($searchModel, 'model')->textInput(['placeholder' => 'Model']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($searchModel, 'year_from')->textInput(['type' => 'number', 'placeholder' => 'Year from']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($searchModel, 'year_to')->textInput(['type' => 'number', 'placeholder' => 'Year to']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <?= $form->field($searchModel, 'price_from')->textInput(['type' => 'number', 'placeholder' => 'Price from']) ?>
                        </div>
                        <div class="col-md-6">
                            <?= $form->field($searchModel, 'price_to')->textInput(['type' => 'number', 'placeholder' => 'Price to']) ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-end">
                            <?= Html::submitButton('Search', ['class' => 'btn btn-primary px-4 py-2']) ?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Car Listings Grid -->
    <div class="row">
        <?php foreach ($dataProvider->getModels() as $index => $model): ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <?= $this->render('_car', ['model' => $model]); ?>
        </div>

        <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
        <?= \yii\widgets\LinkPager::widget([
            'pagination' => $dataProvider->pagination,
            'options' => ['class' => 'pagination'], // Add the pagination class
            'linkContainerOptions' => ['class' => 'page-item'], // Apply Bootstrap page-item class to each container
            'linkOptions' => ['class' => 'page-link'], // Apply Bootstrap page-link class to each link
            'prevPageLabel' => '«', // Customize previous button label
            'nextPageLabel' => '»', // Customize next button label
            'firstPageLabel' => 'First', // Optional: Label for the first page button
            'lastPageLabel' => 'Last', // Optional: Label for the last page button
            'maxButtonCount' => 5, // Number of page buttons to show
            'disabledPageCssClass' => 'd-none', // Styling disabled buttons
        ]) ?>
    </div>

</div>

