<?php

namespace app\modules\movement\controllers;

use app\controllers\base\BaseController;
use app\modules\movement\models\MovementSearch;
use Yii;

class VoluntaryContributionController extends BaseController
{
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}