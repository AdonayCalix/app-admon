<?php

namespace app\modules\movement\models;

/**
 * This is the ActiveQuery class for [[MovementSubDetailV2]].
 *
 * @see MovementSubDetailV2
 */
class MovementSubDetailV2Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MovementSubDetailV2[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MovementSubDetailV2|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
