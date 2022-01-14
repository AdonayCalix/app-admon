<?php

namespace app\modules\project\components\financial\formatv2\summary;

use app\components\ExcelExport;
use app\modules\project\models\ProjectBudget;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContentSummarize extends ExcelExport
{
    /**
     * @var array
     */
    private $project_budget;
    private $excelSheet;

    const FIRST_ROW = 8;

    public function __construct(
        int       $budget_id,
        int       $period_id,
        Worksheet $excelSheet
    )
    {
        $this->excelSheet = $excelSheet;
        $this->project_budget = ProjectBudget::getCategories($budget_id, $period_id);
    }

    public function write(): ContentSummarize
    {
        $this->setContentTable(
            $this->excelSheet,
            "A8",
            (new SummarizeSource($this->project_budget))->get()
        );
        return $this;
    }
}