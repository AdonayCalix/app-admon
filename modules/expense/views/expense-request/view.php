<?php

use app\modules\project\components\FormatDate;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\expense\models\ExpenseRequest */

$this->title = 'Anticipo de Gasto: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Solicitudes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="expense-request-view">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <p>
                <?= Html::a('Crear', ['create'], ['class' => 'btn btn-success btn-sm']) ?>
                <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Seguro que quieres borrar este registro',
                        'method' => 'post',
                    ],
                ])
                ?>
            </p>

            <div class="row">
                <div class="col-md-12">
                    <?php
                    $gridColumn = [
                        ['attribute' => 'id', 'visible' => false],
                        [
                            'attribute' => 'project',
                            'label' => 'Proyecto',
                            'value' => $model->project->alias ?? null
                        ],
                        'elaborated_at',
                        [
                            'attribute' => 'beneficiary',
                            'label' => 'Benficiario',
                            'value' => $model->beneficiary->name ?? null
                        ],
                        'position',
                        'place',
                        'goal',
                        'number_transfer',
                        [
                            'attribute' => 'start_date',
                            'value' => \Carbon\Carbon::parse($model->start_date)->format('d/m/Y h:s a')
                        ],
                        [
                            'attribute' => 'start_date',
                            'value' => \Carbon\Carbon::parse($model->end_date)->format('d/m/Y h:s a')
                        ],
                        'requested_day'
                    ];
                    echo DetailView::widget([
                        'model' => $model,
                        'template' => '<tr><th>{label}</th><td style="width:72%;">{value}</td></tr>',
                        'attributes' => $gridColumn,
                        'condensed' => true,
                        'hAlign' => 'left'
                    ]);
                    ?>
                </div>
            </div>

            <br>

            <p class="form-control bg-light" style="margin-bottom: 0px">
                <i><strong>Detalles de Alimentación</strong></i>
            </p>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ($providerFoodExpenseRequest) {
                        $gridColumnFoodExpenseRequest = [
                            ['attribute' => 'id', 'visible' => false],
                            [
                                'attribute' => 'date',
                                'label' => 'Fecha',
                                'value' => function ($model) {
                                    return (new FormatDate($model->date, 'Y-m-d', 'd/m/Y'))
                                        ->change()
                                        ->asString();
                                }
                            ],
                            [
                                'attribute' => 'breakfast',
                                'value' => function ($model) {
                                    return 'Lps ' . number_format($model->breakfast, 2);
                                }
                            ],
                            [
                                'attribute' => 'lunch',
                                'value' => function ($model) {
                                    return 'Lps ' . number_format($model->lunch, 2);
                                }
                            ],
                            [
                                'attribute' => 'dinner',
                                'value' => function ($model) {
                                    return 'Lps ' . number_format($model->dinner, 2);
                                }
                            ],
                        ];
                        echo Gridview::widget([
                            'dataProvider' => $providerFoodExpenseRequest,
                            'pjax' => true,
                            'columns' => $gridColumnFoodExpenseRequest,
                            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-food-expense-request']],
                            'headerContainer' => ['class' => ''],
                            'summary' => false,
                            'condensed' => true,
                            'striped' => true
                        ]);
                    }
                    ?>
                </div>
            </div>

            <p class="form-control bg-light" style="margin-bottom: 0px">
                <i><strong>Detalles de Gastos</strong></i>
            </p>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    if ($providerExpenseRequestDetail->totalCount) {
                        $gridColumnExpenseRequestDetail = [
                            ['attribute' => 'id', 'visible' => false],
                            [
                                'attribute' => 'advanceDetail.name',
                                'label' => 'Gasto',
                                'width' => '28%',
                            ],
                            'amount'
                        ];
                        echo Gridview::widget([
                            'dataProvider' => $providerExpenseRequestDetail,
                            'pjax' => true,
                            'columns' => $gridColumnExpenseRequestDetail,
                            'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-expense-request-detail']],
                            'summary' => false,
                            'headerContainer' => ['class' => ''],
                            'condensed' => true,
                            'striped' => true
                        ]);
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
