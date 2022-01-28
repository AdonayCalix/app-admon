<?php

namespace app\modules\movement\models;

use Yii;
use \app\modules\movement\models\base\VoucherElements as BaseVoucherElements;

/**
 * This is the model class for table "voucher_elements".
 */
class VoucherElements extends BaseVoucherElements
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['number', 'emission_date', 'beneficiary', 'concept', 'amount', 'amount_total', 'detail_body', 'header_body', 'project_id', 'kind_detail'], 'required'],
                [['project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['createt_at', 'updated_at', 'deleted_at'], 'safe'],
                [['number', 'emission_date', 'beneficiary', 'concept', 'amount'], 'string', 'max' => 5],
                [['detail_body', 'header_body'], 'string', 'max' => 250]
            ]);
    }
}
