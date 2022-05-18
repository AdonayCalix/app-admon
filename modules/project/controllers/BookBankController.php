<?php

namespace app\modules\project\controllers;

use app\controllers\base\BaseController;
use app\modules\project\components\BookBankFile;
use app\modules\project\models\base\Project;
use app\modules\project\repository\Months;
use app\modules\project\repository\Years;

class BookBankController extends BaseController
{
    public function actionGenerate(): string
    {
        return $this->renderIsAjax('_form', [

        ]);
    }

    public function actionGetMonths()
    {
        return json_encode(Months::get());
    }

    public function actionGetYears()
    {
        return json_encode(Years::get());
    }

    public function actionGetProjects()
    {
        return json_encode(Project::find()
            ->select(['project.id as id', 'project.alias as label'])
            ->orderBy('id')->asArray()->all());
    }

    public function actionDownload($project_id, $date)
    {

        (new BookBankFile($project_id, $date))
            ->initializeExcel()
            ->getDates()
            ->writeHeaders()
            ->writeContent()
            ->downloadFile();
    }
}