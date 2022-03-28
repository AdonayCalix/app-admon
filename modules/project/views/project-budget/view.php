<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
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

                <?= Html::a('Editar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
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
                            'attribute' => 'project.name',
                            'label' => 'Project',
                        ],
                    ];
                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => $gridColumn
                    ]);
                    ?>
                </div>
            </div>

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
                        'columns' => $gridColumnBudgetCategory
                    ]);
                }
                ?>
            </div>
        </div>
    </div>
</div>
