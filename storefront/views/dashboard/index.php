<?php
use yii\widgets\ListView;
use yii\helpers\Html;

?>
<h1 class="mb-4">My Purchased Cars</h1>

<div class="container mt-4">
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
