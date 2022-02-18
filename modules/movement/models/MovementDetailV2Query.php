<?php

namespace app\modules\movement\models;

/**
 * This is the ActiveQuery class for [[MovementDetailV2]].
 *
 * @see MovementDetailV2
 */
class MovementDetailV2Query extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MovementDetailV2[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MovementDetailV2|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
