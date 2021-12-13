<?php

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\movement\models\VoucherFormatForm;
use Yii;
use yii\web\UploadedFile;

class VoucherController extends BaseController
{
    public function actionUploadVoucherFormat(): string
    {
        $model = new VoucherFormatForm;

        if (Yii::$app->request->post()) {
            $model->excelFile = UploadedFile::getInstance($model, 'excelFile');
            $model->upload();
        }

        return $this->render('_uploadForm', ['model' => $model]);
    }
}