<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\CheckFormat */

$this->title = 'Actualizar Formato de Solicitud de Cheques' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Solicitud de Cheques', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editando';
?>
<div class="check-format-update">


    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?= $this->render('_form', compact('model', 'checkLogo')) ?>
                </div>
            </div>
        </div>
    </div>


</div>
