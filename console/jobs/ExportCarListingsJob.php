<?php

namespace console\jobs;

use dashboard\models\ExportJob;
use Yii;
use yii\base\BaseObject;
use yii\queue\JobInterface;
use common\models\CarListing;
use yii\helpers\FileHelper;

class ExportCarListingsJob extends BaseObject implements JobInterface
{
    public $id;
    public $filterParams;

    public function execute($queue)
    {
        Yii::info("Starting ExportCarListingsJob for ExportJob ID: {$this->id}", __METHOD__);

        $exportJob = ExportJob::findOne($this->id);
        if (!$exportJob) {
            Yii::error("ExportJob not found with ID: {$this->id}", __METHOD__);
            return;
        }

        $fileName = 'car_listings_' . time() . '.csv';
        $filePath = Yii::getAlias('@exports/' . $fileName);
        FileHelper::createDirectory(Yii::getAlias('@exports'));

        $query = CarListing::find()->with('buyer');

        $query->filterWhere(['make' => $this->filterParams['make'] ?? null])
            ->andFilterWhere(['model' => $this->filterParams['model'] ?? null])
            ->andFilterWhere(['year' => $this->filterParams['year'] ?? null])
            ->andFilterWhere(['buyer_id' => $this->filterParams['buyer_id'] ?? null])
            ->andFilterWhere(['status' => $this->filterParams['status'] ?? null]);

        if (($file = fopen($filePath, 'w')) === false) {
            Yii::error("Unable to create file at: {$filePath}", __METHOD__);
            return;
        }
        fputcsv($file, ['ID', 'Buyer', 'Title', 'Make', 'Model', 'Year', 'Price', 'Mileage', 'Description', 'Status']);

        foreach ($query->each() as $car) {
            $buyerName = $car->buyer ? $car->buyer->username : 'N/A';

            fputcsv($file, [
                $car->id,
                $buyerName,
                $car->title,
                $car->make,
                $car->model,
                $car->year,
                $car->price,
                $car->mileage,
                $car->description,
                $car->status,
            ]);
        }

        fclose($file);

        $exportJob->status = ExportJob::STATUS_COMPLETED;
        $exportJob->file_path = $filePath;
        if ($exportJob->save()) {
            Yii::info("ExportCarListingsJob completed successfully for ExportJob ID: {$this->id}", __METHOD__);
        } else {
            Yii::error("Failed to update ExportJob status for ID: {$this->id}", __METHOD__);
        }
    }
}
