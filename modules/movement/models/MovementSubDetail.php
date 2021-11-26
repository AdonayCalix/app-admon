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

    public function store(array $sub_detail, int $detail_id)
    {
        $movementSubDetail = self::findOne($sub_detail['id']) ?? new self;
        $movementSubDetail->load($sub_detail, '');
        $movementSubDetail->detail_id = $detail_id;

        if ($movementSubDetail->validate())
            $movementSubDetail->save(false);
    }

    public function beforeSave($insert): bool
    {

        $this->sub_category_id = explode('.', $this->sub_category_id)[0] ?? null;
        $this->category_id = self::findOne($this->sub_category_id)->category_id ?? null;

        return parent::beforeSave($insert);
    }


}
