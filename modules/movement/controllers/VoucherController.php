<?php

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\movement\components\vouchers\VoucherFile;
use app\modules\movement\models\base\Movement;
use app\modules\movement\models\MovementDetail;
use app\modules\movement\models\MovementSearch;
use PhpOffice\PhpSpreadsheet\Exception;
use Yii;

class VoucherController extends BaseController
{
    public function actionList(): string
    {
        $searchModel = new MovementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @throws Exception
     */
    public function actionGetFile($movement_id, $project_id)
    {
        $name = Movement::findOne($movement_id)->number;
        $movementDetailId = MovementDetail::findOne(['transfer_id' => $movement_id, 'kind' => 'Egreso'])->id ?? 0;


        (new VoucherFile($movementDetailId, $project_id))
            ->setVoucherFormatFilePath()
            ->initializeExcel()
            ->setMovement()
            ->setVoucherElements()
            ->setHeader()
            ->setNumberTbCheque()
            ->setEmissionDate()
            ->setBeneficiary()
            ->setAmountInWords()
            ->setConcept()
            ->setDetail()
            ->downloadFile("Voucher {$name}.xlsx");
    }
}