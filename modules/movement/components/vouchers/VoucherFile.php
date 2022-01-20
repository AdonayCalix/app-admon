<?php

namespace app\modules\movement\components\vouchers;

use app\components\ExcelExport;
use app\modules\movement\components\MoneyToWords;
use app\modules\movement\components\vouchers\gf\VoucherDetailGlobalFund;
use app\modules\movement\components\vouchers\gf\VoucherHeaderGlobalFund;
use app\modules\movement\components\vouchers\others\VoucherDetailOtherProject;
use app\modules\movement\models\base\Movement;
use app\modules\movement\models\MovementDetail;
use app\modules\movement\models\VoucherElements;
use app\modules\movement\models\VoucherFormat;
use app\modules\project\models\Beneficiary;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\This;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use const PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class VoucherFile extends ExcelExport
{

    private $movement_id;
    private $project_id;
    private $voucherElements;
    private $voucherFormatFilePath;
    private $movement;

    /**
     * @var Spreadsheet
     */
    private $excelObject;
    private $excelSheet;

    public function __construct(int $movement_id, int $project_id)
    {
        $this->movement_id = $movement_id;
        $this->project_id = $project_id;
    }

    public function setMovement(): VoucherFile
    {
        $this->movement = MovementDetail::findOne($this->movement_id);
        return $this;
    }

    public function setVoucherElements(): VoucherFile
    {
        $this->voucherElements = VoucherElements::findOne(['project_id' => $this->project_id]);
        return $this;
    }

    public function setVoucherFormatFilePath(): VoucherFile
    {
        $this->voucherFormatFilePath = VoucherFormat::findOne(['project_id' => $this->project_id])->path;
        return $this;
    }

    public function initializeExcel(): VoucherFile
    {
        $this->excelObject = $this->initExcel('/web/' . $this->voucherFormatFilePath);
        $this->excelSheet = $this->excelObject->getSheetByName('TB');
        return $this;
    }

    /**
     * @throws Exception
     */
    public function setHeader(): VoucherFile
    {
        if ($this->voucherElements->kind_detail !== 'FM')
            return $this;

        $header_body = explode(';', $this->voucherElements->header_body, 2);
        $row = $header_body[0];
        $columns = explode(';', $header_body[1]);

        $headers = VoucherHeaderGlobalFund::get($this->movement);

        foreach ($headers as $header) {
            foreach ($header as $key => $value) {
                if (isset($columns[$key + 1])) {
                    $columIndex = Coordinate::columnIndexFromString($columns[$key + 1]);
                    $column = $columns[$key] . $row . ':' . $this->getLetterColum(($columIndex - 2)) . $row;
                } else {
                    $column = $columns[$key] . $row;
                }

                $this->setValueInCell($this->excelSheet, $columns[$key] . $row, $value);
                $this->setStyleByCell($this->excelSheet, $column, ['aligment_horizontal' => 'center', 'size' => 16, 'bold' => true]);
            }
            $row++;
        }

        return $this;
    }

    public function setDetail(): VoucherFile
    {
        $details = $this->voucherElements->kind_detail !== 'FM' ? VoucherDetailOtherProject::get($this->movement) : VoucherDetailGlobalFund::get($this->movement);

        $detail_body = explode(';', $this->voucherElements->detail_body, 2);
        $row = $detail_body[0];
        $columns = explode(';', $detail_body[1]);

        foreach ($details as $detail) {
            foreach ($detail as $key => $value) {
                if (isset($columns[$key]))
                    $this->setValueInCell($this->excelSheet, $columns[$key] . $row, $value);
            }

            $row++;
        }

        return $this;
    }

    public function setNumberTbCheque(string $name): VoucherFile
    {
        $this->setValueInCell($this->excelSheet, $this->voucherElements->number, $name);
        return $this;
    }

    public function setBeneficiary(): VoucherFile
    {
        $this->setValueInCell($this->excelSheet, $this->voucherElements->beneficiary, Beneficiary::findOne($this->movement->beneficiary_id)->name ?? '');
        return $this;
    }

    public function setConcept(): VoucherFile
    {
        $this->setValueInCell($this->excelSheet, $this->voucherElements->concept, $this->movement->concept);
        return $this;
    }

    public function setAmountInWords(): VoucherFile
    {
        $this->setValueInCell($this->excelSheet, $this->voucherElements->amount, MoneyToWords::get($this->movement->amount));
        return $this;
    }

    public function setEmissionDate(): VoucherFile
    {
        $date = Carbon::parse($this->movement->date);

        $this->setContentTable($this->excelSheet, $this->voucherElements->emission_date, [$date->day, $date->month, $date->year]);
        return $this;
    }

    public function downloadFile(string $name): VoucherFile
    {
        $this->downloadExcel($this->excelObject, $name);
        return $this;
    }

    public function setBanner(): VoucherFile
    {
        $this->setLogo($this->excelObject, 'A1', 150, 'logo_cdm.png');
        return $this;
    }
}