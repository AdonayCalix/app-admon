<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\QbMovementLog as BaseQbMovementLog;

/**
 * This is the model class for table "qb_movement_log".
 */
class QbMovementLog extends BaseQbMovementLog
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['project_id', 'movement_detail_id', 'movement_id', 'kind', 'amount', 'number', 'date'], 'required'],
            [['project_id', 'movement_detail_id', 'movement_id', 'Code'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'date'], 'safe'],
            [['kind', 'number'], 'string', 'max' => 100]
        ]);
    }
	
}
