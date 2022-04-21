<?php

namespace app\modules\movement\models;

use app\modules\project\models\Beneficiary;
use app\modules\project\models\Project;
use app\modules\qb\models\ChartAccount;
use app\modules\qb\models\ListClass;
use Yii;
use \app\modules\movement\models\base\MovementDetail as BaseMovementDetail;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "movement_detail".
 *
 * @property-read void $checks
 */
class MovementDetail extends BaseMovementDetail
{
    /**
     * @inheritdoc
     */
    public function rules(): array
    {
        return array_replace_recursive(parent::rules(),
            [
                [['date', 'concept', 'kind'], 'required'],
                [['date', 'created_at', 'updated_at', 'deleted_at', 'id'], 'safe'],
                [['beneficiary_id', 'transfer_id', 'created_by', 'updated_by', 'deleted_by'], 'integer'],
                [['amount'], 'number'],
                [['concept', '_listId'], 'string', 'max' => 500],
                [['kind', 'status'], 'string', 'max' => 20],
                ['amount', 'validateSumOfAmount']
            ]);
    }

    public function beforeValidate(): bool
    {
        $this->amount = str_replace(',', '', $this->amount);
        return parent::beforeValidate();
    }

    public static function setStatusToProcess(array $source): bool
    {
        foreach ($source as $item) {
            if (!isset($item['isChecked'])) continue;

            $movementDetail = self::findOne(['id' => $item['id']]);
            $movementDetail->status = 'Process';
            $movementDetail->save(false);
        }

        return true;
    }

    public static function getChecks()
    {
        $checks = self::find()
            ->joinWith('transfer t')
            ->where(['t.project_id' => 7])
            ->andWhere(['status' => 'Process'])
            ->andWhere(['kind' => 'Egreso'])
            //->asArray()
            ->all();

        $data = array_map(function ($check) {
            return [
                'AccountRef' => Project::findOne($check->transfer->project_id)->bank_account ?? "",
                'PayeeEntityRef' => Beneficiary::findOne($check->beneficiary_id)->name ?? "",
                'RefNumber' => $check->transfer->number ?? "",
                'TxnDate' => $check->date,
                'Memo' => $check->amount,
                'Adress' => Beneficiary::findOne($check->beneficiary_id)->name ?? "",
                'ExpenseLine' => array_map(function ($movementSubDetail) use ($check) {
                    return [
                        'AccountRef' => $movementSubDetail->chart_account_list_id,
                        'Amount' => $movementSubDetail->amount,
                        'Memo' => $check->concept,
                        'ClassRef' => $movementSubDetail->class_list_id
                    ];
                }, $check->movementSubDetails)
            ];
        }, $checks);

        echo '<pre>' . print_r(json_encode($data), true) . '</pre>';
        die;
    }
}
