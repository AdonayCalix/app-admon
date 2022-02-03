<?php

namespace app\modules\movement\models;

use \app\modules\movement\models\base\Movement as BaseMovement;
use app\modules\project\models\Project;
use setasign\Fpdi\PdfParser\CrossReference\AbstractReader;

/**
 * This is the model class for table "movement".
 */
class Movement extends BaseMovement
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['number', 'amount', 'project_id'], 'required'],
                [['amount'], 'number'],
                ['number', 'unique'],
                [['bank_id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['created_at', 'updated_at', 'deleted_at'], 'safe'],
                [['number', 'bank_account'], 'string', 'max' => 100],
                ['number', 'validateIfExitsMovements'],
                ['number', 'validateKindMovement'],
                ['amount', 'validateAmount']
            ]);
    }

    public function beforeSave($insert): bool
    {
        $project = Project::findOne($this->project_id);
        $this->bank_id = $project->bank;
        $this->bank_account = $project->account_number;
        return parent::beforeSave($insert);
    }

    public static function get(int $id): Movement
    {
        return self::findOne($id);
    }

    public static function getAll(): array
    {
        return self::find()
            ->select(["movement.id", "movement.number as label"])
            ->asArray()
            ->all();
    }
}
