<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\TransferAssignment */

$this->title = 'Crear Asignacion de Transferencia';
$this->params['breadcrumbs'][] = ['label' => 'Transfer Assignment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-assignment-create">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <?= $this->render('_form', compact('model')) ?>
</div>
