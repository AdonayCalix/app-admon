<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\TransferSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use webvimark\modules\UserManagement\components\GhostHtml;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

$this->title = 'Vouchers';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transfer-index">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    ['attribute' => 'number', 'width' => '20%'],
                    ['attribute' => 'amount', 'width' => '20%'],
                    [
                        'attribute' => 'project_id',
                        'label' => 'Proyecto',
                        'value' => function ($model) {
                            return $model->project->alias;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\app\modules\project\models\Project::find()->asArray()->all(), 'id', 'alias'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-transfer-search-project_id']
                    ],
                    [
                        'value' => function($model) {
                                return GhostHtml::a('Generar Voucher', ['get-file', 'movement_id' => $model->id, 'project_id' => $model->project_id], ['target' => '_blank']);
                        },
                        'format' => 'raw'
                    ]
                ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumn,
                    'pjax' => false,
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-transfer']]
                ]); ?>
            </div>
        </div>
    </div>
</div>
