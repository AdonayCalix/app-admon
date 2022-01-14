<?php

namespace app\modules\project\components\financial\formatv2\category;

use app\components\ExcelExport;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FooterCategory extends ExcelExport
{
    const CONTENT_ROW = 7;

    /**
     * @var Worksheet
     */
    private $excelSheet;

    private $subCategories;
    private $total_rows;
    private $total_columns;

    public function __construct(Worksheet $excelSheet, int $total_rows, array $subCategories)
    {
        $this->excelSheet = $excelSheet;
        $this->subCategories = $subCategories;
        $this->total_rows = $total_rows;
        $this->total_columns = 5 + count($subCategories);
    }

    public function write(): FooterCategory
    {
        $initial_row = self::CONTENT_ROW;
        $last_row = self::CONTENT_ROW + $this->total_rows - 1;
        $sum_row = self::CONTENT_ROW + $this->total_rows;

        if ($this->total_rows == 0) return $this;

        $this->setValueInCell($this->excelSheet, "E{$sum_row}", "Total");

        foreach ($this->subCategories as $key => $value) {
            $column = $this->getLetterColum((5 + $key), "ZZ");
            $coordinate = $column . $sum_row;
            $formula = "=SUM({$column}{$initial_row}:{$column}{$last_row})";
            $this->setValueInCell($this->excelSheet, $coordinate, $formula);
        }

        $column = $this->getLetterColum($this->total_columns, "ZZ");
        $coordinate = $column . (self::CONTENT_ROW + $this->total_rows);
        $formula = "=SUM({$column}{$initial_row}:{$column}{$last_row})";

        $this->setValueInCell($this->excelSheet, $coordinate, $formula);

        return $this;
    }

    public function setStyles(): FooterCategory
    {
        $row = self::CONTENT_ROW + $this->total_rows;

        if ($this->total_rows == 0) return $this;

        for ($i = 0; $i < $this->total_columns + 1; $i++) {
            $coordinate = $this->getLetterColum(($i), "ZZ") . $row;
            $this->setStyleByCell($this->excelSheet, $coordinate);
        }
        $row++;
        return $this;
    }

}