<?php

namespace app\modules\expense\controllers;

use app\controllers\base\BaseController;
use yii\web\Controller;

/**
 * Default controller for the `expense` module
 */
class DefaultController extends BaseController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex(): string
    {
        return $this->render('index');
    }
}
