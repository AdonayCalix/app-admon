<?php

namespace app\modules\project\components\financial\formatv2\category;

use app\components\ExcelExport;
use Mpdf\Tag\P;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class HeaderCategory extends ExcelExport
{
    private $subCategories;
    private $excelSheet;

    const ROW_IDENTIFIERS = 5;
    const ROW_CATEGORY_NAMES = 6;

    public function __construct(Worksheet $excelSheet, array $subCategories)
    {
        $this->subCategories = $subCategories;
        $this->excelSheet = $excelSheet;
    }

    public function wirte(): HeaderCategory
    {
        $this->setContentTable($this->excelSheet, 'F5', array_column($this->subCategories, 'account_number'));
        $this->setContentTable($this->excelSheet, 'F6', array_column($this->subCategories, 'name'));
        $coordinate_total = $this->getLetterColum(count($this->subCategories) + 5, "ZZ") . 6;
        $this->setValueInCell($this->excelSheet, $coordinate_total, "Totales");
        return $this;
    }

    public function setStyles(): HeaderCategory
    {
        for ($i = 0; $i < count($this->subCategories) + 1; $i++) {
            $column = $this->getLetterColum(($i + 5), 'ZZ');

            $coordinate_identifier = $column . self::ROW_IDENTIFIERS;
            $coordinate_names_category = $column . self::ROW_CATEGORY_NAMES;

            $this->setStyleByCell($this->excelSheet, $coordinate_identifier, ['bold' => true]);
            $this->setStyleByCell($this->excelSheet, $coordinate_names_category, ['bold' => true]);
        }

        return $this;
    }
}