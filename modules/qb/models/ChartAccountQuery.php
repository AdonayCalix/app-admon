<?php

namespace app\modules\qb\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ChartAccount]].
 *
 * @see ChartAccount
 */
class ChartAccountQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ChartAccount[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ChartAccount|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
