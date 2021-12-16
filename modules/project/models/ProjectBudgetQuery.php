<?php

namespace app\modules\project\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[ProjectBudget]].
 *
 * @see ProjectBudget
 */
class ProjectBudgetQuery extends ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return ProjectBudget[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return ProjectBudget|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function init()
    {
        $this->joinWith(
            [
                "project p" => function ($q) {
                    $q->joinWith("userProject up");
                }
            ]
        )->where(["up.user_id" => \Yii::$app->user->id]);

        parent::init();
    }
}
