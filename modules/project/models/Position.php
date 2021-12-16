<?php

namespace app\modules\project\models;

use \app\modules\project\models\base\Position as BasePosition;

/**
 * This is the model class for table "position".
 */
class Position extends BasePosition
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['name'], 'required'],
                [['created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['name'], 'string', 'max' => 250]
            ]);
    }

    public static function get(): array
    {
        return self::find()
            ->select(["id", "name as label"])
            ->asArray()
            ->all();
    }

}
