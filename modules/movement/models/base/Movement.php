<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\MovementQuery;
use app\modules\project\components\CompareDates;
use app\modules\project\models\Project;
use mootensai\relation\RelationTrait;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the base model class for table "movement".
 *
 * @property integer $id
 * @property string $number
 * @property string $amount
 * @property integer $bank_id
 * @property string $bank_account
 * @property integer $project_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property string $has_v2
 *
 * @property Project $project
 * @property \app\modules\movement\models\MovementDetail[] $movementDetails
 */
class Movement extends ActiveRecord
{
    use RelationTrait;

    public $date;

    /**
     * This function helps \mootensai\relation\RelationTrait runs faster
     * @return array relation names of this model
     */
    public function relationNames(): array
    {
        return [
            'project',
            'movementDetails'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['number', 'amount', 'project_id'], 'required'],
            [['amount'], 'number'],
            ['number', 'unique'],
            [['bank_id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['number', 'bank_account'], 'string', 'max' => 100],
            ['number', 'validateIfExitsMovements'],
            ['number', 'validateKindMovement'],
            ['amount', 'validateAmount']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'movement';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'number' => 'TB/Cheque',
            'amount' => 'Monto',
            'bank_id' => 'Banco ID',
            'bank_account' => 'Cuenta de Banco',
            'project_id' => 'Proyecto ID',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getProject(): ActiveQuery
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getMovementDetails(): ActiveQuery
    {
        return $this->hasMany(\app\modules\movement\models\MovementDetail::class, ['transfer_id' => 'id']);
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
                'value' => new Expression('GETDATE()'),
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
     * @return MovementQuery the active query used by this AR class.
     */
    public static function find(): MovementQuery
    {
        return new MovementQuery(get_called_class());
    }

    public function validateIfExitsMovements($attribute, $params, $validator, $current)
    {
        $movementDetails = $_POST['Movement']['MovementDetails'] ?? [];

        if (empty($movementDetails)) {
            $this->addError('', 'Debes de agregar moviemientos');
        }
    }

    public function validateKindMovement($attribute, $params, $validator, $current)
    {
        $movementDetails = $_POST['Movement']['MovementDetails'] ?? [];
        $details_kind = array_column($movementDetails, 'kind');
        $counts = array_count_values($details_kind);
        $quantity_egresos = $counts['Egreso'] ?? 0;

        if ($quantity_egresos === 0) {
            $this->addError('', 'Debes de incluir un movimiento de tipo egreso');
        }

        if ($quantity_egresos > 1) {
            $this->addError('', 'Solo se puede agregar un movimiento de tipo de egreso');
        }
    }

    public function validateAmount($attribute, $params, $validator, $current)
    {
        $movementDetailAmount = 0;

        $movementDetails = $_POST['Movement']['MovementDetails'] ?? [];

        foreach ($movementDetails as $movementDetail) {
            if ($movementDetail['kind'] === 'Egreso') {
                $movementDetailAmount = $movementDetail['amount'];
                break;
            }
        }

        $previusFormat = str_replace(',', '', $movementDetailAmount);

        if ($this->amount !== $previusFormat) {
            $this->addError('amount', 'El monto de la TB/Cheque no coincide con el movimiento de tipo de egreso');
        }
    }

    public function loadPreviosMovement()
    {
        $values = self::find()
            ->select(['movement.project_id', 'movement.number'])
            ->where(['movement.created_by' => \Yii::$app->user->id])
            ->orderBy(['movement.created_at' => SORT_DESC])
            ->asArray()
            ->one();

        if (empty($values)) return;

        $tb_number = explode(" ", $values['number']);

        $values['number'] = count($tb_number) == 2 ?
            $tb_number[0] . ' ' . ((int)$tb_number[1] + 1) :
            ((int)$values['number'] + 1);


        $this->load($values, '');
    }
}
