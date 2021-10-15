<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\ProjectPeriod */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Project Period', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-period-view">

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
                        'name',
                        'start_date',
                        'end_date',
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
        </div>
    </div>
</div>
