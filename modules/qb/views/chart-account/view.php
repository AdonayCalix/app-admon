<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\qb\models\ChartAccount */

$this->title = 'Visualizando Registro: ' . $model->account_number;
$this->params['breadcrumbs'][] = ['label' => 'Chart Account', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="chart-account-view">

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
                        'account_number',
                        'name',
                        'description',
                        'type',
                        'currency',
                    ];
                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => $gridColumn
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
