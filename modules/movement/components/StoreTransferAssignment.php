<?php

namespace app\modules\movement\components;

use yii\db\Exception;

class StoreTransferAssignment
{
    private $models;

    public function __construct(array $models)
    {
        $this->models = $models;
    }


    public function saveAssignments(): StoreTransferAssignment
    {
        foreach ($this->models as $assignment)
            $assignment->save(false);

        return $this;
    }

    public function getStatus(): bool
    {
        return true;
    }
}