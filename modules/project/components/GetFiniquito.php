<?php /** @noinspection ALL */

/** @noinspection SqlDialectInspection */

namespace app\modules\project\components;

use app\components\ExcelExport;
use phpDocumentor\Reflection\Types\This;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class GetFiniquito extends ExcelExport
{
    /**
     * @var Spreadsheet
     */
    private $excelObject;
    private $excelSheet;

    /** @var array */
    private $treceavo = [];
    private $catorceavo = [];
    private $cesantia = [];

    private $nombre;

    /**
     * @throws \yii\db\Exception
     */
    public function __construct(string $identidad)
    {
        $this->treceavo = \Yii::$app->db->createCommand(
            "select round(sum(treceavo), 2) as treaceavo
                from veamos
                where identidad = '{$identidad}'
                group by anio;"
        )->queryAll();

        $this->catorceavo = \Yii::$app->db->createCommand(
            "select round(sum(catorceavo), 2) as catorceavo
                from veamos
                where identidad = '{$identidad}'
                group by anio;"
        )->queryAll();

        $this->cesantia = \Yii::$app->db->createCommand(
            "select round(sum(cesantia), 2) as cesantia
                from veamos
                where identidad = '{$identidad}'
                group by anio;"
        )->queryAll();


        $this->nombre = \Yii::$app->db->createCommand(
                "select colaborador
                from veamos
                where identidad = '{$identidad}'
                group by colaborador;"
            )->queryOne()['colaborador'] ?? 'NA';
    }

    public function initializeExcel(): GetFiniquito
    {
        $this->excelObject = $this->initExcel('/web/excel/finiquito/Finiquito.xlsx');
        $this->excelSheet = $this->excelObject->getActiveSheet();
        return $this;
    }

    public function writeTreceavo(): GetFiniquito
    {

        $coordinate = '';

        if (count($this->treceavo) == 4) $coordinate = 'B10';
        if (count($this->treceavo) == 3) $coordinate = 'C10';
        if (count($this->treceavo) == 2) $coordinate = 'D10';
        if (count($this->treceavo) == 1) $coordinate = 'E10';

        $this->setContentTable($this->excelSheet, $coordinate, array_column($this->treceavo, 'treaceavo'));

        $this->setValueInCell($this->excelSheet, 'A9', $this->nombre);
        return $this;
    }

    public function writeCatorceavo(): GetFiniquito
    {

        $coordinate = '';

        if (count($this->catorceavo) == 4) $coordinate = 'B11';
        if (count($this->catorceavo) == 3) $coordinate = 'C11';
        if (count($this->catorceavo) == 2) $coordinate = 'D11';
        if (count($this->catorceavo) == 1) $coordinate = 'E11';

        $this->setContentTable($this->excelSheet, $coordinate, array_column($this->catorceavo, 'catorceavo'));
        return $this;
    }

    public function writeCesantia(): GetFiniquito
    {

        $coordinate = '';

        if (count($this->cesantia) == 4) $coordinate = 'B12';
        if (count($this->cesantia) == 3) $coordinate = 'C12';
        if (count($this->cesantia) == 2) $coordinate = 'D12';
        if (count($this->cesantia) == 1) $coordinate = 'E12';

        $this->setContentTable($this->excelSheet, $coordinate, array_column($this->cesantia, 'cesantia'));
        return $this;
    }

    public function downloadFile(): GetFiniquito
    {
        $name = 'Finiquito ' . explode(' ', $this->nombre)[0] ?? 'NA';
        $this->excelObject->getActiveSheet()->setTitle($name);
        $this->downloadExcel($this->excelObject, $name . '.xlsx');
        return $this;
    }
}