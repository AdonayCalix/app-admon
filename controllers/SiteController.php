<?php

namespace app\controllers;

use app\controllers\base\BaseController;
use app\modules\project\models\base\ClassActivity;
use Yii;
use function Symfony\Component\Translation\t;

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
}
