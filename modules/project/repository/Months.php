<?php

namespace app\modules\project\repository;

class Months
{
    public static function get(): array
    {
        return [
            ['id' => '01', 'label' => 'Enero'],
            ['id' => '02', 'label' => 'Febrero'],
            ['id' => '03', 'label' => 'Marzo'],
            ['id' => '04', 'label' => 'Abril'],
            ['id' => '05', 'label' => 'Mayo'],
            ['id' => '06', 'label' => 'Junio'],
            ['id' => '07', 'label' => 'Julio'],
            ['id' => '08', 'label' => 'Agosto'],
            ['id' => '09', 'label' => 'Septiembre'],
            ['id' => '10', 'label' => 'Octubre'],
            ['id' => '11', 'label' => 'Noviembre'],
            ['id' => '12', 'label' => 'Diciembre']
        ];
    }
}