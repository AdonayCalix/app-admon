<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\CheckFormat */

$this->title = 'Formato de Solicitud de Cheques ' . $model->project->alias ?? '';
$this->params['breadcrumbs'][] = ['label' => 'Solicitud de Cheques', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="check-format-view">

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
                        [
                            'attribute' => 'project',
                            'label' => 'Proyecto',
                            'value' => $model->project->alias ?? null
                        ],
                        'elaborated_by',
                        'checked_by',
                        'authorized_by',
                        'aproved_main_director_by',
                        [
                            'attribute' => 'logo_path',
                            'value' => Html::img('@web/' . $model->logo_path ?? '', ['class' => 'pull-left img-responsive']),
                            'format' => 'raw'
                        ]
                    ];
                    echo DetailView::widget([
                        'model' => $model,
                        'attributes' => $gridColumn,
                        'condensed' => true,
                        'hAlign' => 'left'
                    ]);
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>
