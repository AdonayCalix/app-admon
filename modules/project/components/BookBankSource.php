<?php

namespace app\modules\project\components;

class BookBankSource
{
    public static function get(int $project_id, string $start_date, string $end_date): array
    {

        return \Yii::$app->db->createCommand(
            "select excel_date, number, beneficiary, concept, income, egress
                from book_bank
                where date between '{$start_date}' and '{$end_date}' and project_id = {$project_id};
"
        )->queryAll();
    }
}