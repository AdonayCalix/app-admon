<?php

namespace app\modules\movement\models;

use app\modules\project\models\SubCategory;
use app\modules\qb\models\ChartAccount;
use app\modules\qb\models\ListClass;
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
                [['amount', 'sub_category_id', 'chart_account_id', 'class_id'], 'required'],
                [['category_id', 'detail_id', 'created_by', 'deleted_by', 'updated_by'], 'integer'],
                [['amount'], 'number'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['chart_account_id', 'class_id'], 'string', 'max' => 500],
                [['chart_account_list_id', 'class_list_id'], 'string', 'max' => 100],
                ['sub_category_id', 'validateSubCategory']
            ]);
    }

    public function beforeValidate(): bool
    {
        $this->amount = str_replace(',', '', $this->amount);
        return parent::beforeValidate();
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
        $subCategory = explode('-', $this->sub_category_id)[1] ?? null;
        $this->sub_category_id = $subCategory;
        $this->category_id = SubCategory::findOne($subCategory)->category_id ?? null;
        $this->chart_account_list_id = ChartAccount::findOne(['account_number' => $this->chart_account_id])->list_id ?? "";
        $this->class_list_id = ListClass::findOne(['identifier' => $this->class_id])->list_id ?? "";
        return parent::beforeSave($insert);
    }
}
