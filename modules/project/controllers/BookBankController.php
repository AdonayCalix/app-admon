<?php

namespace app\modules\project\controllers;

use app\controllers\base\BaseController;

class BookBankController extends BaseController
{
    public function actionGenerate(): string
    {
        return $this->renderIsAjax('_form', [

        ]);
    }
}