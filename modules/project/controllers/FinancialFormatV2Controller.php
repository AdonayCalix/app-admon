<?php

namespace app\modules\project\controllers;

use app\controllers\base\BaseController;
use app\modules\project\components\financial\formatv2\FinancialFormatV2File;
use app\modules\project\models\base\Project;
use app\modules\project\models\ProjectBudget;
use app\modules\project\models\ProjectPeriod;
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

    public function actionGetPeriods($budget_id)
    {
        return json_encode(ProjectPeriod::getPeriods($budget_id));
    }

    public function actionGetBudgets($project_id)
    {
        $out = \Yii::$app->db->createCommand(
            "select id, name as label from project_budget where project_id = {$project_id}"
        )->queryAll();
        return json_encode($out);
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
    public function actionDownload($project_id, $budget_id, $period_id)
    {
        (new FinancialFormatV2File($project_id, $budget_id, $period_id))
            ->initializeExcel()
            ->setSummarize()
            ->setCategories()
            ->setConsolidate()
            ->removeCloneSheet()
            ->downloadFile();
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
            ->setConsolidate()
            ->removeCloneSheet()
            ->downloadFile();
    }
}