<?php

namespace app\modules\movement\components\receipt;

use app\components\ExcelExport;
use app\modules\movement\components\MoneyToWords;
use app\modules\movement\models\base\TransferAssignment;
use app\modules\movement\models\MovementDetail;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Symfony\Component\String\Slugger\AsciiSlugger;

class ReceiptFile extends ExcelExport
{
    private $assign_id;
    /**
     * @var Spreadsheet
     */
    private $excelObject;
    private $excelSheet;

    public function __construct(int $assign_id)
    {
        $this->assign_id = $assign_id;
    }

    public function initializeExcel(): ReceiptFile
    {
        $this->excelObject = $this->initExcel('/web/excel/receipt/' . 'Receipt Format.xlsx');
        $this->excelSheet = $this->excelObject->getSheetByName('RECIBO');
        return $this;
    }

    public function writeContent(): ReceiptFile
    {
        $assign = TransferAssignment::findOne($this->assign_id);

        $this->setValueInCell($this->excelSheet, 'B9', $assign->number_transfer);
        $this->setValueInCell($this->excelSheet, 'B10', $assign->date);
        $this->setValueInCell($this->excelSheet, 'B11', $assign->beneficiary->name ?? '');
        $this->setValueInCell($this->excelSheet, 'B12', $assign->reason);
        $this->setValueInCell($this->excelSheet, 'B13', MoneyToWords::get($assign->amount));
        $this->setValueInCell($this->excelSheet, 'B14', $assign->amount);

        return $this;
    }

    public function downloadFile(string $name): ReceiptFile
    {
        $this->downloadExcel($this->excelObject, $name);
        return $this;
    }
}