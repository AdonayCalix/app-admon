<?php

namespace app\modules\expense\components;

use app\components\ExcelExport;
use app\modules\expense\models\AdvanceDetail;
use app\modules\expense\models\ExpenseRequest;
use app\modules\expense\models\ExpenseRequestDetail;
use app\modules\expense\models\FoodExpenseRequest;
use phpDocumentor\Reflection\Types\This;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use yii\helpers\ArrayHelper;

class ExpenseRequestFile extends ExcelExport
{

    /**
     * @var ExpenseRequest
     */
    private $expense_request;

    /**
     * @var Spreadsheet
     */
    private $excelObject;
    private $excelSheet;

    public function __construct(int $expense_request_id)
    {
        $this->expense_request = ExpenseRequest::findOne($expense_request_id);
    }

    public function initializeExcel(): ExpenseRequestFile
    {
        $this->excelObject = $this->initExcel('/web/excel/expense_request/ExpenseRequest.xlsx');
        $this->excelSheet = $this->excelObject->getSheetByName('Anticipo');
        return $this;
    }

    public function setHeader(): ExpenseRequestFile
    {

        $this->setValueInCell($this->excelSheet, 'F5', $this->expense_request->number_transfer ?? '');
        $this->setValueInCell($this->excelSheet, 'B7', $this->expense_request->elaborated_at ?? '');
        $this->setValueInCell($this->excelSheet, 'B8', $this->expense_request->beneficiary->name ?? '');
        $this->setValueInCell($this->excelSheet, 'B9', $this->expense_request->position ?? '');
        $this->setValueInCell($this->excelSheet, 'B10', $this->expense_request->project->name ?? '');
        $this->setValueInCell($this->excelSheet, 'B11', $this->expense_request->place ?? '');
        $this->setValueInCell($this->excelSheet, 'B12', $this->expense_request->goal ?? '');
        $this->setValueInCell($this->excelSheet, 'B13', \Carbon\Carbon::parse($this->expense_request->start_date)->format('d/m/Y h:s a') ?? '');
        $this->setValueInCell($this->excelSheet, 'B14', \Carbon\Carbon::parse($this->expense_request->end_date)->format('d/m/Y h:s a') ?? '');
        $this->setValueInCell($this->excelSheet, 'B15', $this->expense_request->requested_day ?? '');

        return $this;
    }

    /**
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function setDetails(): ExpenseRequestFile
    {

        $foodExpense = FoodExpenseRequest::find()
            ->where(['expense_request_id' => $this->expense_request->id])
            ->asArray()
            ->all();

        $total_breakfast = array_sum(array_column($foodExpense, 'breakfast'));
        $total_lunch = array_sum(array_column($foodExpense, 'lunch'));
        $total_dinner = array_sum(array_column($foodExpense, 'dinner'));
        $total_food = $total_breakfast + $total_lunch + $total_dinner;

        $totalFoodExpense = array_reduce($foodExpense, function ($breakfast, $sum) {
            return $breakfast;
        });

        $advance_details = ArrayHelper::toArray($this->expense_request->expenseRequestDetails, [
            ExpenseRequestDetail::class => [
                'name' => 'advanceDetail.name',
                'amount'
            ]
        ]);

        $row_total = 19 + count($advance_details);
        $number_of_row_detete = 15 - (1 + count($advance_details)) - 1;

        for ($i = 0; $i < $number_of_row_detete; $i++)
            $this->excelObject->getActiveSheet()->removeRow($row_total + 1, 1);

        $this->setValueInCell($this->excelSheet, 'A18', 'Alimentacion');
        $this->setValueInCell($this->excelSheet, 'B18', $total_food ?? 0);
        $this->setContentTable($this->excelSheet, 'A19', $advance_details);
        $this->setValueInCell($this->excelSheet, "A{$row_total}", 'Total');
        $this->setValueInCell($this->excelSheet, "B{$row_total}", $total_food + (array_sum(array_column($advance_details, 'amount'))));

        return $this;
    }

    public function downloadFile(): ExpenseRequestFile
    {
        $name = explode(' ', $this->expense_request->beneficiary->name)[0] . ' ' . $this->expense_request->number_transfer ?? '';
        $this->excelObject->getActiveSheet()->setTitle($name);
        $this->downloadExcel($this->excelObject, $name . '.xlsx');
        return $this;
    }
}