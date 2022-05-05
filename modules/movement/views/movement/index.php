<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\TransferSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use webvimark\modules\UserManagement\components\GhostHtml;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

$this->title = 'Movimientos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="transfer-index">

    <div class="card">
        <div class="card-body">

            <p>
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Registrar Movimiento', ['create'], ['class' => 'btn btn-sm btn-success']) ?>
            </p>
            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    ['attribute' => 'number', 'width' => '12%'],
                    [
                        'attribute' => 'amount',
                        'width' => '13%',
                        'value' => function ($model) {
                            return 'Lps ' . number_format($model->amount, 2);
                        }
                    ],
                    [
                        'attribute' => 'date',
                        'label' => 'Fecha',
                        'filterType' => GridView::FILTER_DATE,
                        'filterWidgetOptions' => [
                            'id' => 'fecha',
                            'removeButton' => false,
                            'language' => 'es',
                            'options' => [
                                'autocomplete' => 'new-text'
                            ],
                            'pluginOptions' => [
                                'format' => 'dd/mm/yyyy',
                                'autoclose' => true,
                                'todayBtn' => false,
                                'orientation' => 'bottom left'
                            ],
                        ],
                        'value' => function ($model) {
                            return date('d/m/Y', strtotime($model->date));
                        },
                        'width' => '17%'
                    ],
                    [
                        'attribute' => 'project_id',
                        'label' => 'Proyecto',
                        'value' => function ($model) {
                            return $model->project->alias ?? null;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => ArrayHelper::map(\app\modules\project\models\Project::find()->asArray()->all(), 'id', 'alias'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-transfer-search-project_id'],
                        'width' => '17%'
                    ],
                    [
                        'value' => function ($model) {
                            return \yii\bootstrap4\Html::a('Voucher', ['voucher/get-file', 'movement_id' => $model->id, 'project_id' => $model->project_id], ['target' => '_blank', 'class' => 'badge badge-info']);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'value' => function ($model) {
                            return \yii\bootstrap4\Html::a('Solicitud Cheque', ['check/get-request-check', 'movement_id' => $model->id, 'project_id' => $model->project_id], ['target' => '_blank', 'class' => 'badge badge-info']);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'value' => function ($model) {
                            return \yii\bootstrap4\Html::a('Re Asignacion', ['movement-v2/re-assign', 'id' => $model->id, 'has_v2' => trim($model->has_v2) === 'yes' ? 'si' : 'no'], ['target' => '_blank', 'class' => 'badge badge-info']);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                    ],
                ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumn,
                    'pjax' => false,
                    'condensed' => true,
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-transfer']],
                    'headerContainer' => ['class' => '']
                ]); ?>
            </div>
        </div>
    </div>
</div>
