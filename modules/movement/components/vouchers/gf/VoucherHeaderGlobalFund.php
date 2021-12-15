<?php

namespace app\modules\movement\components\vouchers\gf;

use app\modules\movement\models\MovementDetail;

class VoucherHeaderGlobalFund
{
    public static function get(MovementDetail $movement): array
    {
        $out = [];

        foreach ($movement->movementSubDetails as $subDetail){
            $expense_category = $subDetail->subCategory->expense_category ?? '';

            $out[] = [
              $subDetail->subCategory->module ?? '',
              $subDetail->subCategory->intervention ?? '',
              explode(' ', $expense_category)[0] ?? '',
              $subDetail->subCategory->account_number ?? '',
              $subDetail->subCategory->category->budget->name ?? '',
            ];
        }

        return $out;
    }
}