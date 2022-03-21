<?php

namespace app\modules\project\models\base;

use app\modules\project\models\ChartAccountActivityQuery;
use app\modules\qb\models\base\ChartAccount;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveQuery;

/**
 * This is the base model class for table "chart_account_activity".
 *
 * @property integer $id
 * @property integer $chart_account_id
 * @property integer $activity_id
 * @property string $created_at
 * @property string $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property ChartAccount $chartAccount
 * @property \app\modules\project\models\SubCategory $activity
 */
class ChartAccountActivity extends \yii\db\ActiveRecord
{
    use \mootensai\relation\RelationTrait;


    /**
    * This function helps \mootensai\relation\RelationTrait runs faster
    * @return array relation names of this model
    */
    public function relationNames(): array
    {
        return [
            'chartAccount',
            'activity'
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return [
            [['chart_account_id', 'activity_id'], 'required'],
            [['chart_account_id', 'activity_id', 'created_by', 'updated_by'], 'integer'],
            [['created_at', 'updated_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName(): string
    {
        return 'chart_account_activity';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'chart_account_id' => 'Chart Account ID',
            'activity_id' => 'Activity ID',
        ];
    }
    
    /**
     * @return ActiveQuery
     */
    public function getChartAccount(): ActiveQuery
    {
        return $this->hasOne(ChartAccount::class, ['id' => 'chart_account_id']);
    }
        
    /**
     * @return ActiveQuery
     */
    public function getActivity(): ActiveQuery
    {
        return $this->hasOne(\app\modules\project\models\SubCategory::class, ['id' => 'activity_id']);
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
     * @return ChartAccountActivityQuery the active query used by this AR class.
     */
    public static function find(): ChartAccountActivityQuery
    {
        return new ChartAccountActivityQuery(get_called_class());
    }
}
