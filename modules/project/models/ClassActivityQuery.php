<?php

namespace app\modules\project\models;

/**
 * This is the ActiveQuery class for [[ClassActivity]].
 *
 * @see ClassActivity
 */
class ClassActivityQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ClassActivity[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ClassActivity|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
