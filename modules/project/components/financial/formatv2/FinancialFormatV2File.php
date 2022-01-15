<?php

namespace app\modules\project\components\financial\formatv2;

use app\components\ExcelExport;
use app\modules\movement\models\MovementSubDetail;
use app\modules\project\components\financial\formatv2\category\CategorySheets;
use app\modules\project\components\financial\formatv2\category\ContentCategory;
use app\modules\project\components\financial\formatv2\category\FooterCategory;
use app\modules\project\components\financial\formatv2\category\HeaderCategory;
use app\modules\project\components\financial\formatv2\consolidate\ContentConsolidate;
use app\modules\project\components\financial\formatv2\summary\ContentSummarize;
use app\modules\project\models\base\MovementsByCategory;
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
    private $period_id;
    private $budget_id;

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
        $this->budget_id = $budget_id;
        $this->period_id = $project_period_id;
        $this->budget = ProjectBudget::findOne(['project_budget.project_id' => $project_id]);
        $this->name_file = 'Formato Financiero V2.xlsx';
    }

    public function initializeExcel(): FinancialFormatV2File
    {
        $this->excelObject = $this->initExcel('/web/excel/financial_format/' . 'format_v2.xlsx');
        $this->excelSheet = $this->excelObject->getSheetByName('CEPROSAF');
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

    public function setSummarize(): FinancialFormatV2File
    {
        (new ContentSummarize($this->budget_id, $this->period_id, $this->excelSheet))
            ->write()
            ->setStyles();
        return $this;
    }

    public function setConsolidate(): FinancialFormatV2File
    {
        $this->excelSheet = $this->excelObject->getSheetByName('CONSOLIDADO');
        (new ContentConsolidate($this->budget_id, $this->period_id, $this->excelSheet))
            ->write()
            ->setStyles();
        return $this;
    }

    public function setCategories(): FinancialFormatV2File
    {
        (new CategorySheets(
            $this->excelObject,
            $this->budget->budgetCategories)
        )->create();

        foreach ($this->budget->budgetCategories as $category) {
            $this->excelSheet = $this->excelObject->getSheetByName($category->identifier);

            (new HeaderCategory($this->excelSheet, $category->subCategories))
                ->wirte()
                ->setStyles();

            $query = MovementsByCategory::get($category->id, $this->project->id, $this->period_id);

            (new ContentCategory($this->excelSheet, $query, $category->subCategories))
                ->write()
                ->setStyles();

            (new FooterCategory($this->excelSheet, $query->count(), $category->subCategories))
                ->write()
                ->setStyles();
        }

        return $this;
    }

    public function downloadFile(): FinancialFormatV2File
    {
        $this->downloadExcel($this->excelObject, $this->name_file);
        return $this;
    }
}