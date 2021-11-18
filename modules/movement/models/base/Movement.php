<?php

namespace app\modules\movement\models\base;

use app\modules\movement\models\MovementQuery;
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
 *
 * @property Project $project
 * @property \app\modules\movement\models\MovementDetail[] $movementDetails
 */
class Movement extends ActiveRecord
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
            [['number', 'amount', 'bank_id', 'bank_account', 'project_id'], 'required'],
            [['amount'], 'number'],
            [['bank_id', 'project_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
            [['created_at', 'updated_at', 'deleted_at'], 'safe'],
            [['number', 'bank_account'], 'string', 'max' => 100]
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
            'number' => 'Number',
            'amount' => 'Amount',
            'bank_id' => 'Bank ID',
            'bank_account' => 'Bank Account',
            'project_id' => 'Project ID',
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
}
