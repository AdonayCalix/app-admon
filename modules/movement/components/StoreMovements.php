<?php

namespace app\modules\movement\components;

use \app\modules\movement\models\Movement;
use app\modules\movement\models\MovementDetail;
use app\modules\movement\models\MovementSubDetail;

class StoreMovements
{
    private $posts = [];
    private $movement;
    private $movementDetails = [];
    private $movementSubDetails = [];
    private $errors = [];

    public function __construct(array $posts, Movement $movement)
    {
        $this->posts = $posts;
        $this->movement = $movement;
    }

    public function initializeModels(): StoreMovements
    {
        foreach ($this->posts['Movement']['MovementDetails'] as $detail) {
            $this->movementDetails[] = MovementDetail::findOne($detail['id']) ?? new MovementDetail;
            foreach ($detail['MovementSubDetails'] as $sub_detail) {
                $this->movementSubDetails[] = MovementSubDetail::findOne($sub_detail['id']) ?? new MovementSubDetail;
            }
        }

        return $this;
    }

    public function loadModels(): StoreMovements
    {
        foreach ($this->posts['Movement']['MovementDetails'] as $detail) {
            $this->movementDetails[] = MovementDetail::findOne($detail['id']) ?? new MovementDetail;
            foreach ($detail['MovementSubDetails'] as $sub_detail) {
                $this->movementSubDetails[] = MovementSubDetail::findOne($sub_detail['id']) ?? new MovementSubDetail;
            }
        }

        return $this;
    }

    public function validate(): StoreMovements
    {
        $this->movement->validate();

       /* foreach ($this->movementDetails as $detail)
            echo '<pre>' . print_r($detail, true) . '</pre>';*/

        //echo '<pre>' . print_r($this->movement->errors, true) . '</pre>';
        return $this;
    }

    public function saveOrUpdate(): bool
    {
        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}