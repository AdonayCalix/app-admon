<?php

namespace app\modules\movement\models;

/**
 * This is the ActiveQuery class for [[TransferAssignment]].
 *
 * @see TransferAssignment
 */
class TransferAssignmentQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return TransferAssignment[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return TransferAssignment|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
