<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\TransferAssignment */

$this->title = 'Actualizando Asignacion de Transferencia' . ' ' . $model->transfer_id;
$this->params['breadcrumbs'][] = ['label' => 'Asignamiento de TB', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->transfer_id, 'url' => ['view', 'id' => $model->transfer_id]];
$this->params['breadcrumbs'][] = 'Editando';

$isNewRecord = 'No ok';
?>
<div class="transfer-assignment-update">

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= $this->render('_form', compact('model', 'isNewRecord')) ?>
                </div>
            </div>
        </div>
    </div>

</div>
