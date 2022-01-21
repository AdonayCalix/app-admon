<?php

namespace app\modules\qb\models;

use \app\modules\qb\models\base\ListClass as BaseListClass;

/**
 * This is the model class for table "list_class".
 */
class ListClass extends BaseListClass
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
            [['name', 'identifier'], 'string', 'max' => 255],
            ['is_parent', 'validateSubClass'],
            [['sub_class'], 'string', 'max' => 225]
        ]);
    }

    public static function getMainClasses(): array
    {
        return self::findAll(['is_parent' => 'Y']);
    }

    public static function hasSubClasses(string $identifier): bool
    {
        return self::find()->where(['sub_class' => $identifier])->exists();
    }

    public static function getSubClasses($parent_id): array
    {
        return self::find()
            ->select('identifier AS id, name AS label')
            ->where(['sub_class' => $parent_id])
            ->asArray()
            ->all();
    }

    public function beforeSave($insert): bool
    {
        $this->identifier = $this->sub_class === null ? $this->name : $this->sub_class . ':' . $this->name;
        $this->is_parent = isset($_POST['ListClass']['is_parent']) ? 'N' : 'Y';

        return parent::beforeSave($insert);
    }
}
