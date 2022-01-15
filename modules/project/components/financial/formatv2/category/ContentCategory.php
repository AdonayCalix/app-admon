<?php

namespace app\modules\project\components\financial\formatv2\category;

use app\components\ExcelExport;
use app\modules\movement\models\MovementSubDetail;
use app\modules\project\models\MovementsByCategoryQuery;
use phpDocumentor\Reflection\Types\This;
use PhpOffice\PhpSpreadsheet\Calculation\Engineering\ErfC;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContentCategory extends ExcelExport
{
    const CONTENT_ROW = 7;

    /**
     * @var Worksheet
     */
    private $excelSheet;

    /**
     * @var MovementsByCategoryQuery
     */
    private $query;

    private $subCategories;
    private $total_columns;

    public function __construct(Worksheet $excelSheet, MovementsByCategoryQuery $query, array $subCategories)
    {
        $this->excelSheet = $excelSheet;
        $this->query = $query;
        $this->subCategories = $subCategories;
        $this->total_columns = 6 + count($subCategories);
    }

    /**
     * @throws \yii\db\Exception
     */
    public function write(): ContentCategory
    {
        $source = $this->query
            ->select(['order_number', 'excel_date', 'number', 'name', 'concept'])
            ->asArray()
            ->all();

        $this->setContentTable($this->excelSheet, 'A7', $source);

        $row = self::CONTENT_ROW;
        $last_column = $this->getLetterColum($this->total_columns - 2, "ZZ");

        foreach ($this->query->select(['movement_detail_id', 'number'])->asArraY()->all() as $item) {
            foreach ($this->subCategories as $index => $subCategory) {
                $amount = MovementSubDetail::findOne(
                        [
                            'detail_id' => $item['movement_detail_id'],
                            'sub_category_id' => $subCategory->id
                        ]
                    )->amount ?? 0;

                $refund = GetRefunds::make($item['number'], $subCategory->id);

                $coordinate = $this->getLetterColum((5 + $index), "ZZ") . $row;
                $this->setValueInCell($this->excelSheet, $coordinate, ($amount - $refund));
            }
            $coordinate = $this->getLetterColum($this->total_columns - 1, "ZZ") . $row;
            $formula = "=SUM(F{$row}:{$last_column}{$row})";
            $this->setValueInCell($this->excelSheet, $coordinate, $formula);

            $row++;
        }

        return $this;
    }

    public function setStyles(): ContentCategory
    {
        $row = self::CONTENT_ROW;
        foreach ($this->query->all() as $item) {
            for ($i = 0; $i < $this->total_columns; $i++) {
                $coordinate = $this->getLetterColum(($i), "ZZ") . $row;
                $this->setStyleByCell($this->excelSheet, $coordinate);
            }
            $row++;
        }
        return $this;
    }
}