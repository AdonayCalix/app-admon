<?php

namespace app\modules\movement\components;

use app\modules\movement\models\base\Movement;
use app\modules\movement\models\MovementDetailV2;
use yii\db\Exception;

class StoreValuesV2
{
    private $models;

    public function __construct(array $models)
    {
        $this->models = $models;
    }

    public function saveMovement(): StoreValuesV2
    {
        $this->models['movement']->save();
        return $this;
    }

    /**
     * @throws Exception
     */
    public function saveDetails(): StoreValuesV2
    {
        $movementDetails = $this->models['movementDetailsV2'];

        foreach ($movementDetails as $movementDetail) {
            $movementDetail['MovementDetailV2']->transfer_id = $this->models['movement']->id;
            $movementDetail['MovementDetailV2']->saveAll();
        }

        return $this;
    }

    public function getStatus(): bool
    {
        return true;
    }
}