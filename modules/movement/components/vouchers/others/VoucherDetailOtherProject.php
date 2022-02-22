<?php

namespace app\modules\movement\components\vouchers\others;

use app\modules\movement\models\MovementDetail;
use app\modules\qb\models\ChartAccount;
use app\modules\qb\models\ListClass;

class VoucherDetailOtherProject
{
    public static function get(MovementDetail $movement): array
    {
        $out = [];

        foreach ($movement->movementSubDetails as $subDetail) {

            $list_class = ListClass::findOne(['identifier' => $subDetail->class_id]);

            $list_class = explode(' ', $list_class->name, 2);
            $class_statement = [
                $list_class[0] ?? '',
                $list_class[1] ?? ''
            ];

            $char_account = ChartAccount::findOne(['account_number' => $subDetail->chart_account_id]);
            $detail = [
                '',
                preg_replace('/\s+/', ' ', str_replace('·', '', $char_account->name ?? '')),
                $subDetail->amount ?? 0.00
            ];

            $out[] = $class_statement;
            $out[] = $detail;
        }

        return $out;
    }
}