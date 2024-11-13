<?php
$this->registerJsFile('https://cdn.jsdelivr.net/npm/chart.js');

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $totalSales int */
/* @var $totalRevenue float */
/* @var $popularModels array */
/* @var $mostSalesModels array */

$this->title = 'Sales Dashboard';
?>
<div class="container mt-4">
    <h1 class="mb-4"><?= Html::encode($this->title) ?></h1>

    <!-- Statistics Section -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Sales</h5>
                    <p class="card-text display-4"><?= Html::encode($totalSales) ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text display-4">$<?= Html::encode(number_format($totalRevenue, 2)) ?></p>
                </div>
            </div>
        </div>
    </div>


    <!-- Chart Section with Two Charts Side-by-Side -->
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    Most Popular Car Models
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Model</th>
                            <th>Model Count</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($popularModels as $model): ?>
                            <tr>
                                <td><?= Html::encode($model['model']) ?></td>
                                <td><?= Html::encode($model['model_count']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    Most Sales Chart
                </div>
                <div class="card-body">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$modelsJson = json_encode(array_column($mostSalesModels, 'model'));
$salesCountsJson = json_encode(array_column($mostSalesModels, 'sales_count'));

$script = <<<JS
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: $modelsJson,
            datasets: [{
                label: 'Sales Count',
                data: $salesCountsJson,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1, 
                    }
                }
            }
        }
    });
JS;
$this->registerJs($script);
?>
