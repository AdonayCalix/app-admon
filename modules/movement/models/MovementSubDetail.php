<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\MovementSubDetail as BaseMovementSubDetail;

/**
 * This is the model class for table "movement_sub_detail".
 */
class MovementSubDetail extends BaseMovementSubDetail
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['category_id', 'sub_category_id', 'amount', 'chart_account_id', 'detail_id'], 'required'],
            [['category_id', 'sub_category_id', 'detail_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
            [['amount'], 'number'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['chart_account_id', 'class_id'], 'string', 'max' => 100]
        ]);
    }
	
}
