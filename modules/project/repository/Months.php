<?php

namespace app\modules\project\repository;

class Months
{
    public static function get(): array
    {
        return [
            ['id' => '01', 'value' => 'Enero'],
            ['id' => '02', 'value' => 'Febrero'],
            ['id' => '03', 'value' => 'Marzo'],
            ['id' => '04', 'value' => 'Abril'],
            ['id' => '05', 'value' => 'Mayo'],
            ['id' => '06', 'value' => 'Junio'],
            ['id' => '07', 'value' => 'Julio'],
            ['id' => '08', 'value' => 'Agosto'],
            ['id' => '09', 'value' => 'Septiembre'],
            ['id' => '10', 'value' => 'Octubre'],
            ['id' => '11', 'value' => 'Noviembre'],
            ['id' => '12', 'value' => 'Diciembre']
        ];
    }
}