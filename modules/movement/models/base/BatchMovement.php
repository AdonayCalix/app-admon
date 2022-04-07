<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\BatchMovementQuery;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "batch_movement".
 *
 * @property integer $id
 * @property integer $movement_id
 * @property string $list_id
 * @property string $batch_number
 * @property string $status
 * @property integer $code
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property \app\modules\movement\models\Batch $batchNumber
 * @property \app\modules\movement\models\MovementDetail $movement
 */
class BatchMovement extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'batchNumber',
            'movement'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['movement_id'], 'required'],
            [['movement_id', 'code', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['list_id', 'batch_number'], 'string', 'max' => 100],
            [['status'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'batch_movement';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'movement_id' => 'Movement ID',
            'list_id' => 'List ID',
            'batch_number' => 'Batch Number',
            'status' => 'Status',
            'code' => 'Code',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getBatchNumber(): ActiveQuery
    {
        return $this->hasOne(\app\modules\movement\models\Batch::class, ['number' => 'batch_number']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMovement(): ActiveQuery
    {
        return $this->hasOne(\app\modules\movement\models\MovementDetail::class, ['id' => 'movement_id']);
    }

    /**
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new \yii\db\Expression('GETDATE()'),
            ],
            'blameable' => [
                'class' => BlameableBehavior::class,
                'createdByAttribute' => 'created_by',
                'updatedByAttribute' => 'updated_by',
            ],
        ];
    }

    /**
     * @inheritdoc
     * @return BatchMovementQuery the active query used by this AR class.
     */
    public static function find(): BatchMovementQuery
    {
        return new BatchMovementQuery(get_called_class());
    }

    public function store(): bool
    {
        if (!isset($_POST['Movements'])) return false;

        foreach ($_POST['Movements'] as $item) {

            if (!isset($item['isChecked'])) continue;

            $batch_movement = new self;
            $batch_movement->movement_id = $item['id'];
            $batch_movement->batch_number = $_POST['batch_number'] ?? '0';
            $batch_movement->status = 'Process';
            $batch_movement->save(false);
        }

        return true;
    }
}
