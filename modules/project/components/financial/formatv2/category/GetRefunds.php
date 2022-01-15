<?php

namespace app\modules\project\components\financial\formatv2\category;

use yii\db\Exception;

class GetRefunds
{
    /**
     * @throws Exception
     */
    public static function make(string $number, int $sub_category_id): float
    {
        $result = \Yii::$app->db
            ->createCommand("select dbo.getRefunds('{$number}', {$sub_category_id}) as refund;")
            ->queryOne();
        return $result['refund'];
    }
}