<?php

namespace app\modules\movement\components;

use app\modules\movement\models\base\Movement;
use app\modules\movement\models\MovementDetail;
use yii\db\Exception;

class StoreValues
{
    private $models;

    public function __construct(array $models)
    {
        $this->models = $models;
    }

    public function saveMovement(): StoreValues
    {
        $this->models['movement']->save();
        return $this;
    }

    /**
     * @throws Exception
     */
    public function saveDetails(): StoreValues
    {
        $movementDetails = $this->models['movementDetails'];

        foreach ($movementDetails as $movementDetail) {
            $movementDetail['MovementDetail']->transfer_id = $this->models['movement']->id;
            $movementDetail['MovementDetail']->saveAll();
        }
        return $this;
    }

    public function getStatus(): bool
    {
        return true;
    }
}