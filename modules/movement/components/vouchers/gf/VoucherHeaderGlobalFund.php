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
            $poa = $subDetail->subCategory->category->budget->name ?? '';

            if ($poa === 'Nota de Continuidad') {
                $poa = 'NC';
            }

            if ($poa === 'Fondo Catalizado') {
                $poa = 'FC';
            }

            if ($poa === 'Plan Quinquenal') {
                $poa = 'DDHH';
            }

            $out[] = [
              $subDetail->subCategory->module ?? '',
              $subDetail->subCategory->intervention ?? '',
              explode(' ', $expense_category)[0] ?? '',
              $subDetail->subCategory->account_number ?? '',
              $poa,
            ];
        }

        return $out;
    }
}