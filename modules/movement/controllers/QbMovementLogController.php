<?php

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use Yii;
use app\modules\movement\models\QbMovementLog;
use app\models\QbMovementLogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QbMovementLogController implements the CRUD actions for QbMovementLog model.
 */
class QbMovementLogController extends BaseController
{
    /**
     * Lists all QbMovementLog models.
     * @return string
     */
    public function actionIndex(): string
    {
        $searchModel = new QbMovementLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
