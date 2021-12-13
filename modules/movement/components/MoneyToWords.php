<?php

namespace app\modules\movement\components;

use Luecano\NumeroALetras\NumeroALetras;

class MoneyToWords
{
    public static function get(float $number): string
    {
        $formatter = new NumeroALetras();
        return $formatter->toMoney($number, 2, 'Lempiras', 'Centavos') ?? '';
    }
}