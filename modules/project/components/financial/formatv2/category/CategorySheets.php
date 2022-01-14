<?php

namespace app\modules\project\components\financial\formatv2\category;

use app\modules\project\models\BudgetCategory;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CategorySheets
{
    private $excelObject;
    private $budgetCategories;

    public function __construct(
        Spreadsheet $excelObject,
        array       $budgetCategory
    )
    {
        $this->excelObject = $excelObject;
        $this->budgetCategories = $budgetCategory;
    }

    public function create()
    {
        foreach ($this->budgetCategories as $category) {
            $clonedWorksheet = clone $this->excelObject->getSheetByName('CLONE');
            $clonedWorksheet->setTitle("{$category->identifier}");
            try {
                $this->excelObject->addSheet($clonedWorksheet);
            } catch (Exception $e) {
            }
        }
    }
}