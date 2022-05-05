<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\VoluntaryContributionDetail as BaseVoluntaryContributionDetail;

/**
 * This is the model class for table "voluntary_contribution_detail".
 */
class VoluntaryContributionDetail extends BaseVoluntaryContributionDetail
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['memo', 'amount', 'beneficiary_id', 'voluntary_contribution_id'], 'required'],
            [['amount'], 'number'],
            [['beneficiary_id', 'voluntary_contribution_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['memo'], 'string', 'max' => 225]
        ]);
    }
	
}
