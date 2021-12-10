<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\TransferAssignment */

$this->title = 'Actualizando Asignacion de Transferencia' . ' ' . $model->transfer_id;
$this->params['breadcrumbs'][] = ['label' => 'Transfer Assignment', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->transfer_id, 'url' => ['view', 'id' => $model->transfer_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="transfer-assignment-update">

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
