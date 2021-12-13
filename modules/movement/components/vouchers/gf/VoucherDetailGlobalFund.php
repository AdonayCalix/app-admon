<?php

namespace app\modules\movement\components\vouchers\gf;

use app\modules\movement\models\MovementDetail;

class VoucherDetailGlobalFund
{
    public static function get(int $movement_id): array
    {
        $movement = MovementDetail::findOne($movement_id);

        if (!$movement) return [];

        $out = [];

        foreach ($movement->movementSubDetails as $subDetail) {
            $expense_category = $subDetail->subCategory->expense_category ?? '';

            $budget_statement = [
                'identifier' => $subDetail->subCategory->category->identifier ?? '',
                'name' => $subDetail->subCategory->category->name ?? '',
            ];

            $detail = [
                'expense_category_id' => explode(' ', $expense_category)[0] ?? '',
                'expense_category' => $expense_category,
                'amount' => $subDetail->amount ?? 0
            ];

            $out[] = $budget_statement;
            $out[] = $detail;
        }

        return $out;
    }

}