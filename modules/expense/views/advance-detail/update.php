<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\expense\models\AdvanceDetail */

$this->title = 'Actualizando Detalle de Gasto' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Detalle de Gasto', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editando';
?>
<div class="advance-detail-update">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= $this->render('_form', compact('model')) ?>
                </div>
            </div>
        </div>
    </div>

</div>
