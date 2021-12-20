<?php

namespace app\modules\movement\components\checks;

use app\components\ExcelExport;
use app\modules\movement\components\MoneyToWords;
use app\modules\movement\models\base\Movement;
use app\modules\movement\models\MovementDetail;
use app\modules\project\models\Beneficiary;
use app\modules\project\models\Project;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class RequestCheck extends ExcelExport
{
    private $movement_id;
    private $project_id;
    private $movement;
    private $project;

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

    public function initializeExcel(): RequestCheck
    {
        $this->excelObject = $this->initExcel('/web/excel/checks/' . 'request_check.xlsx');
        $this->excelSheet = $this->excelObject->getSheetByName('CHEQUE');
        return $this;
    }

    public function setMovement(): RequestCheck
    {
        $movementDetailId = MovementDetail::findOne(['transfer_id' => $this->movement_id, 'kind' => 'Egreso'])->id ?? 0;
        $this->movement = MovementDetail::findOne($movementDetailId);
        return $this;
    }

    public function setProject(): RequestCheck
    {
        $this->project = Project::findOne($this->project_id);
        return $this;
    }

    public function writeContent(): RequestCheck
    {
        $this->setValueInCell($this->excelSheet, 'C12', Movement::findOne($this->movement_id)->number ?? '');
        $this->setValueInCell($this->excelSheet, 'C14', Beneficiary::findOne($this->movement->beneficiary_id)->name ?? '');
        $this->setValueInCell($this->excelSheet, 'C16', $this->movement->amount);
        $this->setValueInCell($this->excelSheet, 'C18', MoneyToWords::get($this->movement->amount));
        $this->setValueInCell($this->excelSheet, 'D24', $this->project->account_number);
        $this->setValueInCell($this->excelSheet, 'C21', $this->movement->concept);
        $this->setValueInCell($this->excelSheet, 'C27', date('d/m/Y', strtotime($this->movement->date)));
        $this->setValueInCell($this->excelSheet, 'C29', 'Orlando Calix');

        return $this;
    }

    public function downloadFile(string $name): RequestCheck
    {
        $this->downloadExcel($this->excelObject, $name);
        return $this;
    }
}