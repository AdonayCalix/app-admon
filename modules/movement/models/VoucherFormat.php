<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\VoucherFormat as BaseVoucherFormat;

/**
 * This is the model class for table "voucher_format".
 */
class VoucherFormat extends BaseVoucherFormat
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['is_active', 'project_id'], 'required'],
                [['project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['path'], 'string', 'max' => 250],
                [['is_active'], 'string', 'max' => 1]
            ]);
    }

}
