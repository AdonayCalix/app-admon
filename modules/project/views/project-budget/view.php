<?php

use app\modules\project\models\Project;
use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\ProjectBudget */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Presupuesto/POA', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-budget-view">

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
                        'amount',
                        [
                            'attribute' => '',
                            'label' => 'Proyecto',
                            'value' => function ($model) {
                                return $model->name;
                            }
                        ],
                    ];
                    echo DetailView::widget([
                        'model' => $model,
                        'condensed' => true,
                        'hAlign' => 'left',
                        'attributes' => $gridColumn
                    ]);
                    ?>
                </div>
            </div>

            <br>
            <div class="row">
                <?php
                if ($providerBudgetCategory->totalCount) {
                    $gridColumnBudgetCategory = [
                        ['class' => 'yii\grid\SerialColumn'],
                        ['attribute' => 'id', 'visible' => false],
                        'name',
                        'identifier',
                    ];
                    echo Gridview::widget([
                        'dataProvider' => $providerBudgetCategory,
                        'pjax' => true,
                        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container-budget-category']],
                        'export' => false,
                        'summary' => false,
                        'headerContainer' => ['class' => ''],
                        'condensed' => true,
                        'columns' => $gridColumnBudgetCategory
                    ]);
                }
                ?>
            </div>
        </div>
    </div>
</div>
