<?php

namespace app\modules\movement\models;

/**
 * This is the ActiveQuery class for [[QbMovementLog]].
 *
 * @see QbMovementLog
 */
class QbMovementLogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return QbMovementLog[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return QbMovementLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
