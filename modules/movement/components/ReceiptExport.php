<?php

namespace app\modules\movement\components;

use app\modules\movement\models\Movement;

class ReceiptExport
{

    protected $movement;

    public function __construct(int $transfer_id)
    {
         $this->movement = Movement::get($transfer_id);
    }



}