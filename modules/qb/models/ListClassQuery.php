<?php

namespace app\modules\qb\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ListClass]].
 *
 * @see ListClass
 */
class ListClassQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ListClass[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ListClass|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
