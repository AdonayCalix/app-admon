<?php

use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use app\modules\movement\models\base\TransferAssignment;

/** @var int $transfer_id */
$dataProvider = new ActiveDataProvider([
    'query' => TransferAssignment::find()
        ->where(['transfer_id' => $transfer_id]),
]);

$gridColumn = [
    ['class' => 'yii\grid\SerialColumn'],
    [
        'attribute' => 'beneficiary_id',
        'label' => 'Beneficiario',
        'value' => function ($model) {
            return $model->beneficiary->name;
        }
    ],
    [
        'attribute' => 'position',
        'label' => 'Posición',
    ],
    [
        'attribute' => 'reason',
        'label' => 'Motivo',
    ],
    [
        'attribute' => 'amount',
        'label' => 'Monto',
    ],

];

echo \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $gridColumn,
    'summary' => false,
    'showFooter' => false,
]);
