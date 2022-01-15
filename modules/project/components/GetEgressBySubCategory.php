<?php

namespace app\modules\project\components;

use app\modules\project\models\ProjectPeriod;
use yii\db\Exception;

class GetEgressBySubCategory
{
    /**
     * @throws Exception
     */
    public static function make(int $period_id, int $sub_category_id): float
    {
        $period = ProjectPeriod::findOne($period_id);
        $start_date = (new FormatDate($period->start_date, 'd/m/Y', 'Y-m-d'))->change()->asString();
        $end_date = (new FormatDate($period->end_date, 'd/m/Y', 'Y-m-d'))->change()->asString();

        $result = \Yii::$app->db->createCommand(
            "select dbo.getEgressBySubCategory('{$start_date}', '{$end_date}', {$sub_category_id}) as egress;"
        )->queryOne();
        return $result['egress'];
    }
}