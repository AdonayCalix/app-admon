<?php

namespace app\modules\qb\repository;

class Currency
{
    public static function get(): array
    {
        return [
            ['id' => 'HNL', 'value' => 'Lempiras'],
            ['id' => 'USD', 'value' => 'Dolares Americanos']
        ];
    }
}