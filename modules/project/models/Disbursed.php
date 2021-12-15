<?php

namespace app\modules\project\models;

use Yii;
use \app\modules\project\models\base\Disbursed as BaseDisbursed;

/**
 * This is the model class for table "disbursed".
 */
class Disbursed extends BaseDisbursed
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['period_id', 'project_id', 'amount', 'date', 'description'], 'required'],
                [['period_id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['amount'], 'number'],
                [['description'], 'string', 'max' => '250'],
                [['date', 'created_at', 'updated_at', 'deleted_at'], 'safe']
            ]);
    }

}
