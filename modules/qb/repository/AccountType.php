<?php

namespace app\modules\qb\repository;

class AccountType
{
    public static function get(): array
    {
        return [
            ['id' => 'Bank', 'value' => 'Banco'],
            ['id' => 'Expense', 'value' => 'Gastos'],
            ['id' => 'Income', 'value' => 'Ingresos'],
            ['id' => 'Others Expense', 'value' => 'Otros Gastos'],
            ['id' => 'Accounts Payable', 'value' => 'Cuentas Pagables'],
            ['id' => 'Accounts Payable', 'value' => 'Cuentas Pagables'],
            ['id' => 'Others Current Liability', 'value' => 'Otras Responsabilidades Actuales'],
            ['id' => 'Equity', 'value' => 'Renta Variable'],
            ['id' => 'Fixed Asset', 'value' => 'Activo Fijo'],
        ];
    }
}