<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\VoluntaryContribution */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Lote de Aporte de Voluntario', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="voluntary-contribution-view">

    <div class="card">
        <div class="card-body">
            <p>
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
                        'name',
                        'date',
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
            <br>
            <div class="row">
                <div class="col-md-12">
                    <?php
                    $gridColumnVoluntaryContributionDetail = [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'beneficiary.name',
                            'label' => 'Recibido Por',
                            'width' => '35%'
                        ],
                        [
                            'attribute' => 'memo',
                            'width' => '30%'
                        ],
                        [
                            'attribute' => 'amount',
                            'width' => '30%'
                        ],
                    ];
                    echo Gridview::widget([
                        'dataProvider' => $providerVoluntaryContributionDetail,
                        'columns' => $gridColumnVoluntaryContributionDetail,
                        'pjax' => true,
                        'condensed' => true,
                        'striped' => true,
                        'headerContainer' => ['class' => ''],
                        'summary' => false
                    ]); ?>
                </div>
            </div>
        </div>
    </div>

</div>
