<?php

namespace app\modules\qb\models\base;

use app\modules\qb\models\ChartAccountQuery;
use mootensai\relation\RelationTrait;
use Yii;
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
 * @property string $type
 * @property string $currency
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $update_at
 * @property string $deleted_at
 */
class ChartAccount extends ActiveRecord
{
    use RelationTrait;

    private $_rt_softdelete;
    private $_rt_softrestore;

    public function __construct(){
        parent::__construct();
        $this->_rt_softdelete = [
            'deleted_by' => \Yii::$app->user->id,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
        $this->_rt_softrestore = [
            'deleted_by' => 0,
            'deleted_at' => date('Y-m-d H:i:s'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['account_number', 'name', 'description', 'type', 'currency'], 'required'],
            [['created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'update_at', 'deleted_at'], 'safe'],
            [['account_number'], 'string', 'max' => 20],
            [['name', 'description'], 'string', 'max' => 500],
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
