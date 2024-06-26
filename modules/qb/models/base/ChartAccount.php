<?php

namespace app\modules\qb\models\base;

use app\modules\qb\models\ChartAccountQuery;
use mootensai\relation\RelationTrait;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the base model class for table "chart_account".
 *
 * @property integer $id
 * @property string $account_number
 * @property string $name
 * @property string $description
 * @property string $sub_account
 * @property string $is_parent
 * @property string $identifier
 * @property string $type
 * @property string $currency
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $update_at
 * @property string $deleted_at
 * @property string $list_id
 */
class ChartAccount extends ActiveRecord
{
    use RelationTrait;

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['account_number', 'name', 'description', 'type', 'currency'], 'required'],
            [['account_number'], 'unique'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'update_at', 'deleted_at'], 'safe'],
            [['account_number'], 'string', 'max' => 20],
            [['name', 'description', 'sub_account'], 'string', 'max' => 500],
            [['type'], 'string', 'max' => 100],
            [['currency'], 'string', 'max' => 10]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'chart_account';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'account_number' => 'Numero de Cuenta',
            'name' => 'Nombre',
            'description' => 'Descripcion',
            'type' => 'Tipo',
            'currency' => 'Moneda'
        ];
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
     * @return ChartAccountQuery the active query used by this AR class.
     */
    public static function find(): ChartAccountQuery
    {
        return (new ChartAccountQuery(get_called_class()));
    }
}
