<?php

namespace app\modules\qb\components;

use app\modules\qb\models\ChartAccount;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Yii;

class LoadAccounts
{
    const FIRST_ROW = 2;
    const DEFAULT_COUNTER = 0;
    private $fileName;
    private $excelSheet;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function loadExcelFile(): LoadAccounts
    {
        $excelFile = IOFactory::load(Yii::$app->basePath . '/web/uploads/' . $this->fileName);
        $this->excelSheet = $excelFile->getActiveSheet();
        return $this;
    }

    public function store(): array
    {
        $row = self::FIRST_ROW;
        $status = true;
        $counter = self::DEFAULT_COUNTER;

        while ($status) {
            if ($this->excelSheet->getCell('A' . $row)->getValue() == null)
                $status = false;

            try {
                $values = [
                    'name' => $this->excelSheet->getCell('A' . $row)->getValue(),
                    'account_number' => $this->excelSheet->getCell('B' . $row)->getValue(),
                    'description' => $this->excelSheet->getCell('C' . $row)->getValue(),
                    'type' => $this->excelSheet->getCell('D' . $row)->getValue(),
                    'currency' => $this->excelSheet->getCell('E' . $row)->getValue(),
                ];

                $chartAccount = new ChartAccount;
                $chartAccount->load($values, '');

                if ($chartAccount->validate() && $chartAccount->save(false)) {
                    $status = true;
                    $counter++;
                }

            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            }

            $row++;
        }

        return [
            'total_registros' => $row,
            'total_registros_guardados' => $counter
        ];
    }
}