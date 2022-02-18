<?php

namespace app\modules\movement\components;

use app\modules\movement\models\Movement;
use app\modules\movement\models\MovementDetailV2;
use app\modules\movement\models\MovementSubDetailV2;

class LoadValuesV2
{
    private $post;
    private $movement;
    private $movementDetails;
    private $errors;

    public function __construct(array $post)
    {
        $this->post = $post;
    }

    public function initializeMovement(): LoadValuesV2
    {
        $movement = Movement::findOne($this->post['Movement']['id']) ?? new Movement;
        $movement->load($this->post['Movement'], '');
        $movement->has_v2 = 'yes';
        $movement->validate();
        $this->movement = $movement;
        $this->setErrors($this->movement->errors);
        return $this;
    }

    public function initializeDetails(): LoadValuesV2
    {

        foreach ($this->post['Movement']['MovementDetails'] as $key => $value) {

            $movementDetail = MovementDetailV2::findOne($value['id'] ?? null) ?? new MovementDetailV2;
            $movementDetail->loadAll([
                'MovementDetailV2' => [
                    'kind' => $value['kind'] ?? null,
                    'date' => $value['date'] ?? null,
                    'amount' => $value['amount'] ?? null,
                    'beneficiary_id' => $value['beneficiary_id'] ?? null,
                    'concept' => $value['concept'] ?? null,
                ],
                'MovementSubDetailV2s' => $value['MovementSubDetails']
            ]);

            $movementDetail->validate();
            $this->setErrors($movementDetail->errors, 'Movimiento', $key);

            foreach ($movementDetail->movementSubDetailV2s as $subKey => $movementSubDetail) {
                $movementSubDetail->validate();
                $this->setErrors($movementSubDetail->errors, "Movimiento #" . ($key + 1) . ", Detalle ", $subKey);
            }

            $this->movementDetails[] = [
                'MovementDetailV2' => $movementDetail
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
            'movementDetailsV2' => $this->movementDetails
        ];
    }
}