<?php

namespace app\modules\project\models;

/**
 * This is the ActiveQuery class for [[UserProject]].
 *
 * @see UserProject
 */
class UserProjectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return UserProject[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return UserProject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
