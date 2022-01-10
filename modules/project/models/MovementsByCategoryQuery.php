<?php

namespace app\modules\project\models;

/**
 * This is the ActiveQuery class for [[MovementsByCategory]].
 *
 * @see MovementsByCategory
 */
class MovementsByCategoryQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return MovementsByCategory[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MovementsByCategory|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
