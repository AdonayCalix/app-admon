<?php

namespace app\modules\movement\components;

use app\modules\movement\models\Movement;
use app\modules\movement\models\MovementDetail;
use app\modules\movement\models\MovementSubDetail;

class LoadValues
{
    private $post;
    private $movement;
    private $movementDetails;
    private $errors;

    public function __construct(array $post)
    {
        $this->post = $post;
    }

    public function initializeMovement(): LoadValues
    {
        $movement = Movement::findOne($this->post['Movement']['id']) ?? new Movement;
        $movement->load($this->post['Movement'], '');
        $movement->validate();
        $this->movement = $movement;
        $this->setErrors($this->movement->errors);
        return $this;
    }

    public function initializeDetails(): LoadValues
    {
        foreach ($this->post['Movement']['MovementDetails'] as $key => $value) {

            $movementDetail = MovementDetail::findOne($value['id'] ?? null) ?? new MovementDetail;
            $movementDetail->loadAll([
                'MovementDetail' => [
                    'kind' => $value['kind'] ?? null,
                    'date' => $value['date'] ?? null,
                    'amount' => $value['amount'] ?? null,
                    'beneficiary_id' => $value['beneficiary_id'] ?? null,
                    'concept' => $value['concept'] ?? null,
                ],
                'MovementSubDetails' => $value['MovementSubDetails']
            ]);

            $movementDetail->validate();
            $this->setErrors($movementDetail->errors, 'Movimiento', $key);

            foreach ($movementDetail->movementSubDetails as $subKey => $movementSubDetail) {
                $movementSubDetail->validate();
                $this->setErrors($movementSubDetail->errors, "Movimiento #" . ($key + 1) . ", Detalle ", $subKey);
            }

            $this->movementDetails[] = [
                'MovementDetail' => $movementDetail
            ];
        }

        return $this;
    }

    public function setErrors(array $errors, string $title = '', int $index = null)
    {
        foreach ($errors as $error) {
            $message = $title !== '' && $index !== null ? $title . ' #' . ($index + 1) . ': ' . $error[0] : $error[0];
            $this->errors[] = $message;
        }
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getModels(): array
    {
        return [
            'movement' => $this->movement,
            'movementDetails' => $this->movementDetails
        ];
    }
}