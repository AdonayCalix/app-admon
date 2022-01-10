<?php

namespace app\modules\project\components;

use app\components\ExcelExport;
use app\modules\project\models\Project;
use app\modules\project\models\ProjectBudget;
use phpDocumentor\Reflection\Types\This;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class FinancialFormatV2File extends ExcelExport
{

    /**
     * @var Project
     */
    private $project;

    private $budget;
    private $project_period_id;

    /**
     * @var Spreadsheet
     */
    private $excelObject;
    private $excelSheet;

    /**
     * @var string
     */
    private $name_file;

    public function __construct(int $project_id, int $budget_id, int $project_period_id)
    {
        $this->project = Project::findOne($project_id);
        $this->budget = ProjectBudget::findOne(['project_budget.project_id' => $project_id]);
        $this->name_file = 'Formato Financiero V2.xlsx';
    }

    public function initializeExcel(): FinancialFormatV2File
    {
        $this->excelObject = $this->initExcel('/web/excel/financial_format/' . 'format_v2.xlsx');
        $this->excelSheet = $this->excelObject->getSheetByName('CEPROSAF');
        return $this;
    }

    public function createCategorySheets(): FinancialFormatV2File
    {
        foreach ($this->budget->budgetCategories as $category) {
            $clonedWorksheet = clone $this->excelObject->getSheetByName('CLONE');
            $clonedWorksheet->setTitle("{$category->identifier}");
            try {
                $this->excelObject->addSheet($clonedWorksheet);
            } catch (Exception $e) {
            }
        }

        return $this;
    }

    /**
     * @throws Exception
     */
    public function removeCloneSheet(): FinancialFormatV2File
    {
        $sheetIndex = $this->excelObject->getIndex(
            $this->excelObject->getSheetByName('CLONE')
        );
        $this->excelObject->removeSheetByIndex($sheetIndex);

        return $this;
    }

    public function setContentCategory(): FinancialFormatV2File
    {
        foreach ($this->budget->budgetCategories as $category) {
            $this->excelSheet = $this->excelObject->getSheetByName($category->identifier);

            $this->setContentTable($this->excelSheet, 'F5', array_column($category->subCategories, 'account_number'));
            $this->setContentTable($this->excelSheet, 'F6', array_column($category->subCategories, 'name'));

        }

        return $this;
    }

    public function downloadFile(): FinancialFormatV2File
    {
        $this->downloadExcel($this->excelObject, $this->name_file);
        return $this;
    }

}