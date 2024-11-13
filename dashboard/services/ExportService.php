<?php
namespace dashboard\services;

use console\jobs\ExportCarListingsJob;
use dashboard\models\ExportJob;
use Yii;

class ExportService
{
    /**
     * Creates an export job and pushes it to the queue
     *
     * @param array $filterParams
     * @return bool whether the job was successfully created
     */

    public function createExportJob(array $filterParams): bool
    {
        $exportJob = new ExportJob();
        $exportJob->status = ExportJob::STATUS_PENDING;

        if ($exportJob->save()) {
            Yii::$app->queue->push(new ExportCarListingsJob([
                'id' => $exportJob->id,
                'filterParams' => $filterParams,
            ]));
            return true;
        }

        return false;
    }
}
