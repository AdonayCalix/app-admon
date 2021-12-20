<?php

namespace app\modules\movement\components;

use app\modules\movement\models\TransferAssignment;
use app\modules\movement\models\VoucherFormatForm;

class LoadTransferAssignment
{
    private $post;
    private $errors;
    private $assigns;

    public function __construct(array $post)
    {
        $this->post = $post;
    }

    public function initialize(): LoadTransferAssignment
    {
        $transferValue = $this->post['DynamicModel']['transfer_id'] ?? null;

        if ($transferValue === null) {
            $this->setErrors([
                ['Debes de seleccionar un numero de TB/Cheque']
            ], '');
        } else {
            $transferAssignment = TransferAssignment::find()
                ->where(['transfer_id' => $transferValue]);

            if ($this->post['isNewRecord'] === 'ok') {

                $this->setErrors([
                    ['Solo se puede asignar un numero de TB/Cheque una vez']
                ], '');
            }

            if ($this->post['isNewRecord'] === 'No ok') {
                if ($transferAssignment->count() > 0) {
                    if ((int)$transferAssignment->one()->transfer_id !== (int)$this->post['transferId']) {
                        $this->setErrors([
                            ['Solo se puede asignar un numero de TB/Cheque una vez UPD']
                        ], '');
                    }
                }
            }
        }
        return $this;
    }

    public function initializeAssign(): LoadTransferAssignment
    {
        foreach ($this->post['TransferAssignment'] as $key => $value) {

            $assign = TransferAssignment::findOne($value['id'] ?? null) ?? new TransferAssignment;
            unset($value['id']);
            $assign->load($value, '');
            $assign->validate();

            $this->setErrors($assign->errors, 'Movimiento', $key);
            $this->assigns[] = $assign;
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
        return $this->assigns;
    }
}