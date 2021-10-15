<?php

namespace app\modules\project\controllers;

use yii\web\Controller;

/**
 * Default controller for the `project` module
 */
class DefaultController extends Controller
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
