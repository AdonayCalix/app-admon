<?php

namespace app\modules\movement\components\vouchers\gf;

use app\modules\movement\models\MovementDetail;

class VoucherDetailGlobalFund
{
    public static function get(MovementDetail $movement): array
    {
        $out = [];

        foreach ($movement->movementSubDetails as $subDetail) {
            $expense_category = $subDetail->subCategory->expense_category ?? '';

            $budget_statement = [
                $subDetail->subCategory->category->identifier ?? '',
                $subDetail->subCategory->category->name ?? '',
            ];

            $detail = [
                explode(' ', $expense_category)[0] ?? '',
                $expense_category,
                $subDetail->amount ?? 0
            ];

            $out[] = $budget_statement;
            $out[] = $detail;
        }

        return $out;
    }

}