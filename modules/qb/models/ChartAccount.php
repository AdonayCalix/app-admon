<?php

namespace app\modules\qb\models;

use \app\modules\qb\models\base\ChartAccount as BaseChartAccount;

class ChartAccount extends BaseChartAccount
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['account_number', 'name', 'description', 'type', 'currency'], 'required'],
                [['account_number'], 'unique'],
                [['created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['created_at', 'update_at', 'deleted_at'], 'safe'],
                [['account_number'], 'string', 'max' => 20],
                [['name', 'description', 'sub_account'], 'string', 'max' => 500],
                [['type'], 'string', 'max' => 100],
                [['currency'], 'string', 'max' => 10]
            ]);
    }

    public static function getmainAccount(): array
    {
        return self::find()
            ->where(['is_parent' => 'Y'])
            ->orderBy(['account_numBer' => SORT_ASC])
            ->all();
    }

    public static function hasSubAccount($identifier): bool
    {
        return self::find()->where(['sub_account' => $identifier])->exists();
    }

    public static function getSubAccount($parent_id): array
    {
        return self::find()
            ->select('account_number AS id, name AS label')
            ->where(['sub_account' => $parent_id])
            ->asArray()
            ->all();
    }

    public function beforeSave($insert): bool
    {
        $this->identifier = $this->sub_account === null ? $this->name : $this->sub_account . ':' . $this->name;

        if (isset($_POST['ChartAccount']))
            $this->is_parent = isset($_POST['ChartAccount']['is_parent']) ? 'N' : 'Y';

        return parent::beforeSave($insert);
    }
}
