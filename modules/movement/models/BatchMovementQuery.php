<?php

namespace app\modules\movement\models;

/**
 * This is the ActiveQuery class for [[BatchMovement]].
 *
 * @see BatchMovement
 */
class BatchMovementQuery extends \yii\db\ActiveQuery
{
    /**
     * @inheritdoc
     * @return BatchMovement[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return BatchMovement|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
