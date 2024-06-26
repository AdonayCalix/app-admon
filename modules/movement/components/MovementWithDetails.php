<?php

namespace app\modules\movement\components;

use app\modules\movement\models\MovementDetail;
use app\modules\movement\models\MovementSubDetail;

class MovementWithDetails
{
    private $transfer_id;
    private $result;

    public function __construct(int $transfer_id)
    {
        $this->transfer_id = $transfer_id;
    }

    public function make(): MovementWithDetails
    {
        $movements = MovementDetail::find()
            ->select(['id', 'kind', 'amount', 'date', 'beneficiary_id', 'concept'])
            ->where(['transfer_id' => $this->transfer_id])
            ->orderBy(['created_at' => SORT_ASC])
            ->asArray()
            ->all();

        foreach ($movements as $movement) {
            $movementSubDetail = MovementSubDetail::find()
                ->select(['id', "concat('A-',sub_category_id) as sub_category_id", 'class_id', 'chart_account_id', 'amount'])
                ->where(['detail_id' => $movement['id']])
                ->asArray()
                ->all();

            $movement[] = [
                'id' => $movement['id'],
                'kind' => $movement['kind'],
                'date' => date('D M d Y', strtotime($movement['date'])),
                'beneficiary_id' => $movement['beneficiary_id'],
                'concept' => $movement['concept'],
            ];
            $movement['sub_details'] = $movementSubDetail;
            $this->result[] = $movement;
        }

        return $this;
    }

    public function get(): array
    {
        return $this->result;
    }
}