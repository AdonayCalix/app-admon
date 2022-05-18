<?php

namespace app\controllers;

use app\controllers\base\BaseController;
use Yii;

class SiteController extends BaseController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;

        switch ($exception) {

            case ($exception instanceof \yii\web\NotFoundHttpException):
                return $this->render('pnf', ['exception' => $exception->getMessage()]);
                break;

            case ($exception instanceof \yii\web\ForbiddenHttpException):
                return $this->render('prohibido', ['exception' => $exception->getMessage()]);
                break;

            default:
                return $this->render('error', ['exception' => $exception]);
                break;
        }
    }
}
