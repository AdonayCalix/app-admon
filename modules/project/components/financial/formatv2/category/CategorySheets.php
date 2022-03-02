<?php

namespace app\modules\project\components\financial\formatv2\category;

use app\modules\project\models\BudgetCategory;
use app\modules\project\models\ProjectPeriod;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CategorySheets
{
    private $excelObject;
    private $budgetCategories;
    private $period_id;

    public function __construct(
        Spreadsheet $excelObject,
        array       $budgetCategory,
        int         $period_id
    )
    {
        $this->excelObject = $excelObject;
        $this->budgetCategories = $budgetCategory;
        $this->period_id = $period_id;
    }

    public function create()
    {
        foreach ($this->budgetCategories as $category) {
            $clonedWorksheet = clone $this->excelObject->getSheetByName('CLONE');
            $clonedWorksheet->setTitle("{$category->identifier}");
            $clonedWorksheet->setCellValue('C2', "{$category->identifier}. {$category->name}");
            $clonedWorksheet->setCellValue('C3', ProjectPeriod::findOne($this->period_id)->name);
            try {
                $this->excelObject->addSheet($clonedWorksheet);
            } catch (Exception $e) {
            }
        }
    }
}