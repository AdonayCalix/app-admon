<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Project */

$this->title = 'Visualizando Registro';
$this->params['breadcrumbs'][] = ['label' => 'Proyecto', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-view">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <p>

                <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-sm']) ?>
                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-sm',
                    'data' => [
                        'confirm' => 'Estas seguro que quieres eliminar este registro',
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
                        'name',
                        'alias',
                        'frecuency',
                        'start_date',
                        'end_date',
                        'budget',
                    ];
                    echo DetailView::widget([
                        'model' => $model,
                        'condensed' => true,
                        'hAlign' => 'left',
                        'attributes' => $gridColumn,
                    ]);
                    ?>
                </div>
            </div>

            <br>
            <div class="row">
                <?php if ($providerProjectBudget->totalCount): ?>
                    <strong>Presupuestos/POAS</strong>
                    <?php $gridColumnProjectBudget = [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['attribute' => 'id', 'visible' => false],
                        'name',
                        'amount',
                    ];
                    echo Gridview::widget([
                        'dataProvider' => $providerProjectBudget,
                        'pjax' => true,
                        'condensed' => true,
                        'summary' => false,
                        'columns' => $gridColumnProjectBudget,
                        'headerContainer' => ['class' => '']
                    ]); ?>
                <?php endif; ?>
            </div>

            <br>
            <div class="row">
                <?php if ($providerProjectPeriod->totalCount): ?>
                    <strong>Periodos de Ejecucion</strong>
                    <?php
                    $gridColumnProjectPeriod = [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['attribute' => 'id', 'visible' => false],
                        'name',
                        'start_date',
                        'end_date',
                    ];
                    echo Gridview::widget([
                        'dataProvider' => $providerProjectPeriod,
                        'pjax' => true,
                        'summary' => false,
                        'condensed' => true,
                        'columns' => $gridColumnProjectPeriod,
                        'headerContainer' => ['class' => '']
                    ]); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
