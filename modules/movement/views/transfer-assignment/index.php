<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\movement\models\TransferAssignmentSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;

$this->title = 'Transfer Assignment';

?>
<div class="transfer-assignment-index">

    <p>
        <?= Html::a('Create Transfer Assignment', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php
    $gridColumn = [
        ['class' => 'yii\grid\SerialColumn'],
        ['attribute' => 'id', 'visible' => false],
        [
            'attribute' => 'transfer_id',
            'label' => 'Transfer',
            'value' => function ($model) {
                return $model->transfer->id;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(\app\modules\movement\models\Movement::find()->asArray()->all(), 'id', 'id'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Movement', 'id' => 'grid-transfer-assignment-search-transfer_id']
        ],
        [
            'attribute' => 'beneficiary_id',
            'label' => 'Beneficiary',
            'value' => function ($model) {
                return $model->beneficiary->name;
            },
            'filterType' => GridView::FILTER_SELECT2,
            'filter' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Beneficiary::find()->asArray()->all(), 'id', 'name'),
            'filterWidgetOptions' => [
                'pluginOptions' => ['allowClear' => true],
            ],
            'filterInputOptions' => ['placeholder' => 'Beneficiary', 'id' => 'grid-transfer-assignment-search-beneficiary_id']
        ],
        'amount',
        'position',
        'reason',
        [
            'class' => 'yii\grid\ActionColumn',
        ],
    ];
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumn,
        'pjax' => true,
        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-transfer-assignment']],
    ]); ?>

</div>
