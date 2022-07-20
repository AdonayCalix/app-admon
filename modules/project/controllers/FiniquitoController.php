<?php /** @noinspection SqlDialectInspection */

namespace app\modules\project\controllers;

use app\controllers\base\BaseController;
use app\modules\project\components\GetFiniquito;
use kartik\mpdf\Pdf;
use Yii;
use yii\web\Response;

class FiniquitoController extends BaseController
{
    /** @noinspection SqlNoDataSourceInspection */
    /**
     * @throws \Mpdf\MpdfException
     * @throws \setasign\Fpdi\PdfParser\CrossReference\CrossReferenceException
     * @throws \yii\db\Exception
     * @throws \yii\base\InvalidConfigException
     * @throws \setasign\Fpdi\PdfParser\PdfParserException
     * @throws \setasign\Fpdi\PdfParser\Type\PdfTypeException
     */
    public function actionGetFiniquito(string $identidad): string
    {
        $resumen = Yii::$app->db->createCommand(
            "select 
                   round(sum(catorceavo), 2) as catorceavo,
                   round(sum(treceavo), 2)   as treaceavo,
                   round(sum(cesantia), 2) as cesantia,
                   round(sum(total), 2)      as total
                from veamos
                where identidad = '{$identidad}'
                "
        )->queryOne();

        $nombre = Yii::$app->db->createCommand("select colaborador
from veamos
where identidad = '$identidad'
group by colaborador;")->queryOne();

        Yii::$app->response->format = Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('finiquito', [
                'resumen' => $resumen,
                'identidad' => $identidad,
                'nombre' => $nombre
            ],
            ),
            'methods' => [
                'SetHeader' => ['<img src="https://simeinstitucional.blob.core.windows.net/dsds/Screenshot%202022-07-19%20203840.png" alt="" width="100%">'],
            ]
        ]);

        return $pdf->render();
    }

    /**
     * @throws \yii\db\Exception
     */
    public function actionGetFiniquitoExcel(string $identidad)
    {
        (new GetFiniquito($identidad))
            ->initializeExcel()
            ->writeTreceavo()
            ->writeCatorceavo()
            ->writeCesantia()
            ->downloadFile();
    }
}