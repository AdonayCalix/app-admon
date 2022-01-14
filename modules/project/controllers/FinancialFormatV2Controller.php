<?php

namespace app\modules\project\controllers;

use app\controllers\base\BaseController;
use app\modules\project\components\financial\formatv2\FinancialFormatV2File;
use app\modules\project\models\base\Project;
use app\modules\project\repository\Months;
use app\modules\project\repository\Years;
use PhpOffice\PhpSpreadsheet\Exception;

class FinancialFormatV2Controller extends BaseController
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

    /**
     * @throws Exception
     */
    public function actionVeamos()
    {

        (new FinancialFormatV2File(3, 1, 1))
            ->initializeExcel()
            ->setSummarize()
            ->setCategories()
            ->removeCloneSheet()
            ->downloadFile();
    }
}