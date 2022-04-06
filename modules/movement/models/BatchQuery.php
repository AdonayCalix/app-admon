<?php

namespace app\modules\movement\models;

/**
 * This is the ActiveQuery class for [[Batch]].
 *
 * @see Batch
 */
class BatchQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Batch[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Batch|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
