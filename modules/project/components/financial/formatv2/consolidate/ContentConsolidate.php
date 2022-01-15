<?php

namespace app\modules\project\components\financial\formatv2\consolidate;

use app\components\ExcelExport;
use app\modules\project\models\ProjectBudget;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContentConsolidate extends ExcelExport
{
    /**
     * @var array
     */
    private $project_budget;
    private $excelSheet;
    private $source;

    const FIRST_ROW = 8;

    public function __construct(
        int       $budget_id,
        int       $period_id,
        Worksheet $excelSheet
    )
    {
        $this->excelSheet = $excelSheet;
        $this->project_budget = ProjectBudget::getCategories($budget_id, $period_id);
        $this->source = (new ConsolidateSource($this->project_budget))->get();
    }

    public function write(): ContentConsolidate
    {
        $source = $this->source;

        foreach ($source as $key => $item) {
            unset($source[$key]['color']);
            unset($source[$key]['bold']);
            unset($source[$key]['italic']);
            unset($source[$key]['alignment_horizontal']);
        }

        $this->setContentTable(
            $this->excelSheet,
            "A8",
            $source
        );
        return $this;
    }

    public function setStyles(): ContentConsolidate
    {
        $row = 8;

        foreach ($this->source as $item) {

            $config = [
                "bold" => $item['bold'] ?? false,
                "color" => $item['color'] ?? false,
                "italic" => $item['italic'] ?? false,
                "alignment_horizontal" => $item['alignment_horizontal'] ?? 'center'
            ];

            $this->setStyleByCell($this->excelSheet, "B{$row}", $config);
            $this->setStyleByCell($this->excelSheet, "C{$row}", $config);
            $this->setStyleByCell($this->excelSheet, "D{$row}", $config);
            $this->setStyleByCell($this->excelSheet, "E{$row}", $config);

            $row++;
        }

        return $this;
    }
}