<?php

namespace app\modules\project\components;

use app\components\ExcelExport;
use app\modules\project\models\BookBank;
use app\modules\project\Project;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use SebastianBergmann\Comparator\Book;

class BookBankFile extends ExcelExport
{
    const FIRST_ROW = 7;
    private $project_id;
    private $date;
    private $first_date;
    private $last_date;

    /**
     * @var Spreadsheet
     */
    private $excelObject;
    private $excelSheet;

    /**
     * @var \app\modules\project\models\Project
     */
    private $project;
    /**
     * @var string
     */
    private $name_file;

    public function __construct(int $project_id, string $date)
    {
        $this->project = \app\modules\project\models\Project::findOne($project_id);
        $this->date = $date;
    }

    public function initializeExcel(): BookBankFile
    {
        $this->excelObject = $this->initExcel('/web/excel/book_bank/' . 'book_bank_format.xlsx');
        $this->excelSheet = $this->excelObject->getSheetByName('LIBRO DE BANCO');
        return $this;
    }

    public function getDates(): BookBankFile
    {
        $this->first_date = Carbon::parse($this->project->date_initial_balance)->firstOfMonth();
        $this->last_date = Carbon::parse($this->date);

        return $this;
    }

    public function writeHeaders(): BookBankFile
    {
        Carbon::setLocale('es');
        $date = Carbon::parse($this->date);
        $before_month = $date->subMonthsNoOverflow()->endOfMonth();
        $this->name_file = "LIBRO DE BANCOS MES DE: " . strtoupper($date->monthName) . " DE " . $date->year;

        $this->setValueInCell($this->excelSheet, 'C6', "CEPROSAF");
        $this->setValueInCell($this->excelSheet, 'D6', "Saldo al " . $before_month->day . " de " . $before_month->monthName . " " . $before_month->year);

        $balance = $this->project->initial_balance;

        if ($this->first_date->ne($this->last_date->firstOfMonth()))
            $balance = CalculateBalance::get($this->project->id, $this->first_date->format('Y-m-d'), $this->last_date->endOfMonth()->format('Y-m-d'), $balance);

        $this->setValueInCell($this->excelSheet, 'G6', $balance);

        $this->setValueInCell($this->excelSheet, 'A2', "CUENTA No. " . $this->project->account_number ?? "");
        $this->setValueInCell($this->excelSheet, 'A3', $this->name_file);

        return $this;
    }

    public function writeContent(): BookBankFile
    {
        $source = BookBank::find()
            ->select(['excel_date', 'number', 'beneficiary', 'concept', 'income', 'egress'])
            ->where(['project_id' => $this->project->id])
            ->andwhere(['between', 'date', $this->first_date->format('Y-m-d'), $this->last_date->endOfMonth()->format('Y-m-d')])
            ->orderBy(['date' => SORT_DESC])
            ->asArray()
            ->all();

        $this->setContentTable($this->excelSheet, 'A7', $source);

        $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G'];
        $row = self::FIRST_ROW;

        foreach ($source as $value) {
            foreach ($columns as $column) {
                $this->setStyleByCell($this->excelSheet,
                    "{$column}{$row}", [
                        'alignment_horizontal' => 'left'
                    ]
                );
            }

            $before_row = $row - 1;
            $this->excelSheet->setCellValue("G{$row}", "=G{$before_row}+E{$row}-F{$row}");

            $row++;
        }

        $initial_row = self::FIRST_ROW;
        $last_row = $row - 1;

        $this->setStyleByCell($this->excelSheet,
            "A{$row}", [
                'alignment_horizontal' => 'left',
                'bold' => true
            ]
        );
        $this->setStyleByCell($this->excelSheet,
            "B{$row}", [
                'alignment_horizontal' => 'left',
                'bold' => true
            ]
        );
        $this->setStyleByCell($this->excelSheet,
            "C{$row}", [
                'alignment_horizontal' => 'left',
                'bold' => true
            ]
        );
        $this->excelSheet->setCellValue("D{$row}", "Total");
        $this->setStyleByCell($this->excelSheet,
            "D{$row}", [
                'alignment_horizontal' => 'left',
                'bold' => true
            ]
        );

        $this->excelSheet->setCellValue("E{$row}", "=SUM(E{$initial_row}:E{$last_row})");
        $this->setStyleByCell($this->excelSheet,
            "E{$row}", [
                'alignment_horizontal' => 'left',
                'bold' => true
            ]
        );

        $this->excelSheet->setCellValue("F{$row}","=SUM(F{$initial_row}:F{$last_row})");
        $this->setStyleByCell($this->excelSheet,
            "F{$row}", [
                'alignment_horizontal' => 'left',
                'bold' => true
            ]
        );

        $this->excelSheet->setCellValue("G{$row}", "=G6+E{$row}-F{$row}");
        $this->setStyleByCell($this->excelSheet,
            "G{$row}", [
                'alignment_horizontal' => 'left',
                'bold' => true
            ]
        );

        return $this;
    }

    public function downloadFile(): BookBankFile
    {
        $this->downloadExcel($this->excelObject, $this->name_file . '.xlsx');
        return $this;
    }

}