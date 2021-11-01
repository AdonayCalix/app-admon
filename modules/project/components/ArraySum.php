<?php

namespace app\modules\project\components;

class ArraySum
{
    public static function make(array $values): float
    {
        return round(array_sum($values), 2);
    }
}