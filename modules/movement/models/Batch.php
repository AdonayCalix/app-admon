<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\Batch as BaseBatch;

/**
 * This is the model class for table "batch".
 */
class Batch extends BaseBatch
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
	    [
            [['number', 'kind', 'emission_date', 'project_id'], 'required'],
            [['emission_date', 'process_date', 'created_at', 'updated_at'], 'safe'],
            [['project_id', 'created_by', 'updated_by'], 'integer'],
            [['number'], 'string', 'max' => 100],
            [['kind'], 'string', 'max' => 20],
        ]);
    }
}
