<?php

/* @var $this yii\web\View */
/* @var $searchModel app\modules\expense\models\ExpenseRequestSearch */

/* @var $dataProvider yii\data\ActiveDataProvider */

use webvimark\modules\UserManagement\components\GhostHtml;
use yii\helpers\Html;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use app\modules\movement\models\base\TransferAssignment;

$this->title = 'Anticipo de Gastos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-request-index">

    <div class="card">
        <div class="card-body">

            <p>
                <?= GhostHtml::a('<i class="align-middle" data-feather="check-circle"></i>&nbsp;Crear Anticipo', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
            </p>
            <div class="row">
                <?php
                $gridColumn = [
                    ['class' => 'yii\grid\SerialColumn'],
                    ['attribute' => 'id', 'visible' => false],
                    [
                        'attribute' => 'project_id',
                        'label' => 'Proyecto',
                        'value' => function ($model) {
                            return $model->project->alias;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Project::find()->asArray()->all(), 'id', 'alias'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-expense-request-search-project_id'],
                        'width' => '15%'
                    ],
                    [
                        'attribute' => 'beneficiary_id',
                        'value' => function ($model) {
                            return \app\modules\project\models\Beneficiary::findOne($model->beneficiary_id)->name;
                        },
                        'filterType' => GridView::FILTER_SELECT2,
                        'filter' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Beneficiary::find()->asArray()->all(), 'id', 'name'),
                        'filterWidgetOptions' => [
                            'pluginOptions' => ['allowClear' => true],
                        ],
                        'filterInputOptions' => ['placeholder' => '', 'id' => 'grid-expense-request-search-beneficiary_id']
                    ],
                    [
                        'attribute' => 'elaborated_at',
                        'label' => 'Fecha Elaboracion',
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
                        'width' => '13%'
                    ],
                    'place',
                    [
                        'attribute' => 'number_transfer',
                        'width' => '9%'
                    ],
                    [
                        'value' => function ($model) {
                            return \yii\bootstrap4\Html::a('Descargar', ['get-file', 'expense_request_id' => $model->id], ['target' => '_blank', 'class' => 'badge badge-info']);
                        },
                        'format' => 'raw'
                    ],
                    [
                        'value' => function ($model) {
                            return \yii\bootstrap4\Html::a('Recibo', array('get-receipt', 'id' => (TransferAssignment::findOne(array('expense_request_id' => $model->id))->id ?? null)), ['target' => '_blank', 'class' => 'badge badge-info']);
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
                    'condensed' => true,
                    'pjax' => false,
                    'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-expense-request']],
                    'headerContainer' => ['class' => '']
                ]); ?>
            </div>
        </div>
    </div>
</div>
