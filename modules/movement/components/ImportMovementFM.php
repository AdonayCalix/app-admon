<?php

namespace app\modules\movement\components;

use app\modules\movement\models\Movement;
use app\modules\movement\models\MovementDetail;
use app\modules\movement\models\base\MovementSubDetail;
use app\modules\project\models\Beneficiary;
use app\modules\project\models\SubCategory;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Yii;

class ImportMovementFM
{
    const NUMBER_OF_VOUCHERS = 102;
    const NUMBER_CHECK_ROW = 38;
    const NUMBER_DATE_ROW = 38;
    const START_HEADER_ROW = 41;
    const DIFFERENCE_BETWEEN_HEADER_AND_BENEFICIARY_ROW = 2;
    const DIFFERENCE_BETWEEN_HEADER_AND_CONCEPT_ROW = 6;
    const DIFFERENCE_BETWEEN_HEADER_AND_DETAIL_ROW = 10;

    /**
     * @var Spreadsheet
     */
    private $excelObject;

    /**
     * @var Worksheet
     */
    private $excelSheet;
    private $last_header_row;
    /**
     * @var int
     */
    private $detail_row;

    public function initializeFile(): ImportMovementFM
    {
        $this->excelObject = IOFactory::load(Yii::$app->basePath . '/web/excel/vouchers_fm/Vaucher Q11.xlsx');
        return $this;
    }

    public function make(): ImportMovementFM
    {

        for ($i = 0; $i < self::NUMBER_OF_VOUCHERS; $i++) {
            try {

                $this->excelSheet = $this->excelObject->getSheet($i);
                $number_check = $this->excelSheet->getCell('C' . self::NUMBER_CHECK_ROW)->getValue();

                if ($number_check === null || $number_check === '') continue;

                $date = $this->getDate();
                $header = $this->getHeader();

                if (empty($header)) continue;

                $beneficiary = $this->getBeneficiary();
                $concept = $this->getConcept();
                $detail = $this->getDetail($header);
                $total = $this->getTotal($detail);

                $movement = new Movement;
                $movement->number = $number_check;
                $movement->amount = $total;
                $movement->project_id = 7;
                $movement->bank_account = '3-100075989';
                $movement->bank_id = 0;
                $movement->save(false);

                $movement_detail = new MovementDetail;
                $movement_detail->transfer_id = $movement->id;
                $movement_detail->date = $date;
                $movement_detail->amount = $total;
                $movement_detail->kind = 'Egreso';
                $movement_detail->concept = $concept;
                $movement_detail->beneficiary_id = $beneficiary;
                $movement_detail->save(false);

                foreach ($detail as $item) {
                    $sub_category = SubCategory::findOne(['account_number' => (string)$item['account_number']]);
                    $movement_sub_detail = new MovementSubDetail();
                    $movement_sub_detail->amount = $item['amount'];
                    $movement_sub_detail->sub_category_id = $sub_category->id;
                    $movement_sub_detail->category_id = $sub_category->category_id;
                    $movement_sub_detail->detail_id = $movement_detail->id;
                    $movement_sub_detail->class_id = null;
                    $movement_sub_detail->chart_account_id = null;
                    $movement_sub_detail->save(false);
                }

            } catch (Exception $e) {
                echo $e->getMessage();
                die;
            }
        }

        return $this;
    }

    private function getDate(): string
    {
        $day = $this->excelSheet->getCell('I' . self::NUMBER_DATE_ROW)->getValue();
        $month = $this->excelSheet->getCell('J' . self::NUMBER_DATE_ROW)->getValue();
        $year = $this->excelSheet->getCell('K' . self::NUMBER_DATE_ROW)->getValue();
        return Carbon::create($year, $month, $day)->format('Y-m-d');
    }

    private function getHeader(): array
    {
        $row_header = self::START_HEADER_ROW;
        $header = [];

        while (true) {
            $account_number = $this->excelSheet->getCell('J' . $row_header)->getValue();

            if ($account_number === null || $account_number === '') break;

            $this->last_header_row = $row_header;
            $header[] = $account_number;

            $row_header++;
        }

        return $header;
    }

    private function getBeneficiary(): int
    {
        $name = trim(
            $this->excelSheet
                ->getCell('D' . ($this->last_header_row + self::DIFFERENCE_BETWEEN_HEADER_AND_BENEFICIARY_ROW))
                ->getValue()
        );

        $beneficiary = Beneficiary::findOne(['name' => $name]);

        if (!$beneficiary) {
            $beneficiary = new Beneficiary;
            $beneficiary->name = $name;
            $beneficiary->save(false);
        }

        return $beneficiary->id;
    }

    private function getConcept(): string
    {
        $concept = $this->excelSheet
            ->getCell('A' . ($this->last_header_row + self::DIFFERENCE_BETWEEN_HEADER_AND_CONCEPT_ROW))
            ->getValue();

        return trim($concept);
    }

    private function getDetail(array $header): array
    {
        $this->detail_row = $this->last_header_row + self::DIFFERENCE_BETWEEN_HEADER_AND_DETAIL_ROW;
        return array_map(function ($account_number) {

            $amount = $this->excelSheet->getCell('F' . $this->detail_row)->getValue();
            $this->detail_row += 2;

            return [
                'account_number' => $account_number,
                'amount' => sprintf('%0.2f', $amount)
            ];

        }, $header);
    }

    private function getTotal(array $detail): string
    {
        return array_reduce($detail, function ($sum, $detail) {
            $sum += $detail['amount'];
            return sprintf('%0.2f', $sum);
        });
    }
}