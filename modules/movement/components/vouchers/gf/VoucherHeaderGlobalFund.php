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
              'module' => $subDetail->subCategory->module ?? '',
              'intervention' => $subDetail->subCategory->intervention ?? '',
              'expense_category' => explode(' ', $expense_category)[0] ?? '',
              'account_number' => $subDetail->subCategory->account_number ?? '',
              'budget' => $subDetail->subCategory->category->budget->name ?? '',
            ];
        }

        return $out;
    }
}