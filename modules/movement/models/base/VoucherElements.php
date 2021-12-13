<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\VoucherElementsQuery;
use app\modules\project\models\Project;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use mootensai\behaviors\UUIDBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "voucher_elements".
 *
 * @property integer $id
 * @property string $number
 * @property string $emission_date
 * @property string $beneficiary
 * @property string $concept
 * @property string $amount
 * @property string $detail_body
 * @property string $header_body
 * @property integer $project_id
 * @property integer $created_by
 * @property integer $updated_by
 * @property integer $deleted_by
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 *
 * @property Project $project
 */
class VoucherElements extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;

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
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'project'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['number', 'emission_date', 'beneficiary', 'concept', 'amount', 'detail_body', 'header_body', 'project_id'], 'required'],
            [['project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['createt_at', 'updated_at', 'deleted_at'], 'safe'],
            [['number', 'emission_date', 'beneficiary', 'concept', 'amount', 'detail_body', 'header_body'], 'string', 'max' => 3]
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'voucher_elements';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'number' => 'Numero TB/Cheque',
            'emission_date' => 'Fecha de Emision',
            'beneficiary' => 'Nombre Beneficiario',
            'concept' => 'Concepto',
            'amount' => 'Monto En Palabras',
            'detail_body' => 'Detalles',
            'header_body' => 'Cabecera',
            'project_id' => 'Proyecto'
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
     * @inheritdoc
     * @return array mixed
     */
    public function behaviors()
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
            ]
        ];
    }

    /**
     * @inheritdoc
     * @return VoucherElementsQuery the active query used by this AR class.
     */
    public static function find(): VoucherElementsQuery
    {
        return new VoucherElementsQuery(get_called_class());
    }
}
