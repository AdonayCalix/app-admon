<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\VoluntaryContribution */

$this->title = 'Actualizar Lote de Aporte Voluntario: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Aporte Voluntario', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editando';
?>
<div class="voluntary-contribution-update">

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
