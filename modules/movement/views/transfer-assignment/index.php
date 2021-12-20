<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\movement\models\TransferAssignmentSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Url;

$this->title = 'Asinacion de TB/Cheque';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="transfer-assignment-index">

    <div class="card">
        <div class="card-body">
            <p>
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Asignamiento de TB', ['create'], ['class' => 'btn btn-success']) ?>
            </p>
            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    [
                        'class' => \kartik\grid\ExpandRowColumn::class,
                        'label' => 'Fila Expandible',
                        'format' => 'raw',
                        'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                        },
                        'detail' => function ($model, $key, $index) {
                            return Yii::$app->controller->renderPartial('_detail', ['transfer_id' => $model->transfer_id]);
                        },
                        'expandOneOnly' => false,
                        'width' => '5%'
                    ],
                    [
                        'attribute' => 'transfer_id',
                        'label' => 'No TB',
                        'value' => function ($model) {
                            return $model->transfer->number;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map(\app\modules\movement\models\Movement::find()->asArray()->all(), 'id', 'id'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-transfer-assignment-search-transfer_id'],
                        'width' => '80%'
                    ],
//                    [
//                        'attribute' => 'beneficiary_id',
//                        'label' => 'Beneficiario',
//                        'value' => function ($model) {
//                            return $model->beneficiary->name;
//                        },
//                        'filterType' => GridView::FILTER_SELECT2,
//                        'filter' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Beneficiary::find()->asArray()->all(), 'id', 'name'),
//                        'filterWidgetOptions' => [
//                            'pluginOptions' => ['allowClear' => true],
//                        ],
//                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-transfer-assignment-search-beneficiary_id']
//                    ],
//                    'amount',
//                    'reason',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{update}{delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return GhostHtml::a('<span class="fas fa-eye"></span>',
                                    Url::to(['view', 'id' => $model->transfer_id])
                                );
                            },
                            'update' => function ($url, $model) {
                                return GhostHtml::a('<span class="fas fa-edit"></span>',
                                    Url::to(['update', 'id' => $model->transfer_id])
                                );
                            },
                            'delete' => function ($url, $model) {
                                return GhostHtml::a('<span class="fas fa-trash"></span>',
                                    Url::to(['delete', 'id' => $model->transfer_id])
                                );
                            }
                        ],
                    ],
                ];
                ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumn,
                    'pjax' => true,
                    'bsVersion' => '4.x',
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-transfer-assignment']],
                ]); ?>
            </div>
        </div>
    </div>
