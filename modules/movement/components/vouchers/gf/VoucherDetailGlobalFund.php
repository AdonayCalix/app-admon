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
            $identifier = $subDetail->subCategory->category->identifier ?? '';

            $budget_statement = [
                $identifier,
                $subDetail->subCategory->category->name ?? '',
            ];

            $out[] = $budget_statement;

            $detail = [
                explode(' ', $expense_category)[0] ?? '',
                $expense_category,
                $subDetail->amount ?? 0
            ];
            $out[] = $detail;
        }

        return $out;
    }
}