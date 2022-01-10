<?php

namespace app\modules\project\repository;

class Years
{
    public static function get(): array
    {
        return [
            ['id' => '2022', 'label' => '2022'],
            ['id' => '2023', 'label' => '2023'],
            ['id' => '2024', 'label' => '2024'],
        ];
    }
}