<?php

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\movement\components\checks\RequestCheck;
use app\modules\movement\models\MovementDetail;
use app\modules\movement\models\MovementSearch;
use Yii;

class CheckController extends BaseController
{
    public function actionList()
    {
        $searchModel = new MovementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionGetRequestCheck($movement_id, $project_id)
    {
        (new RequestCheck($movement_id, $project_id))
            ->initializeExcel()
            ->setMovement()
            ->setProject()
            ->writeContent()
            ->setBanner()
            ->downloadFile('CHEQUE.xlsx');
    }
}