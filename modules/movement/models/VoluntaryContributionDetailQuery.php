<?php

namespace app\modules\movement\models;

/**
 * This is the ActiveQuery class for [[VoluntaryContributionDetail]].
 *
 * @see VoluntaryContributionDetail
 */
class VoluntaryContributionDetailQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return VoluntaryContributionDetail[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return VoluntaryContributionDetail|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
