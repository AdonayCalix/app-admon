<?php

namespace app\modules\project\models;

/**
 * This is the ActiveQuery class for [[ChartAccountActivity]].
 *
 * @see ChartAccountActivity
 */
class ChartAccountActivityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ChartAccountActivity[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ChartAccountActivity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
