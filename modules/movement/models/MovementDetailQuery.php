<?php

namespace app\modules\movement\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[MovementDetail]].
 *
 * @see MovementDetail
 */
class MovementDetailQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MovementDetail[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MovementDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
