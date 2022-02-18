<?php

namespace app\modules\movement\components;

use app\modules\movement\models\Movement;
use app\modules\movement\models\MovementDetail;
use app\modules\movement\models\MovementDetailV2;
use app\modules\movement\models\MovementSubDetail;
use app\modules\movement\models\MovementSubDetailV2;

class MovementWithDetailsV2
{
    private $transfer_id;
    private $result;
    private $has_v2;

    public function __construct(int $transfer_id, string $has_v2)
    {
        $this->transfer_id = $transfer_id;
        $this->has_v2 = $has_v2;
    }

    public function make(): MovementWithDetailsV2
    {
        $movementClass = $this->has_v2 === 'no' ? MovementDetail::class : MovementDetailV2::class;
        $movementSubDetailClass = $this->has_v2 === 'no' ? MovementSubDetail::class : MovementSubDetailV2::class;

        $movements = $movementClass::find()
            ->select(['id', 'kind', 'amount', 'date', 'beneficiary_id', 'concept'])
            ->where(['transfer_id' => $this->transfer_id])
            ->asArray()
            ->all();

        foreach ($movements as $movement) {
            $movementSubDetail = $movementSubDetailClass::find()
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