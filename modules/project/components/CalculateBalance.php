<?php

namespace app\modules\project\components;

use app\modules\movement\models\base\Movement;
use app\modules\movement\models\MovementDetail;
use app\modules\project\models\BookBank;
use SebastianBergmann\Comparator\Book;

class CalculateBalance
{
    public static function get(int $project_id, string $start_date, string $end_date, float $balance): float
    {

        $total_ingresos = BookBank::find()
            ->where(['project_id' => $project_id])
            ->andwhere(['between', 'date', $start_date, $end_date])
            ->sum('income');

        $total_egresos = BookBank::find()
            ->where(['project_id' => $project_id])
            ->andwhere(['between', 'date', $start_date, $end_date])
            ->sum('egress');

        return $balance + $total_ingresos - $total_egresos;
    }
}