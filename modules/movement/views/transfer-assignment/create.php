<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\TransferAssignment */

$this->title = 'Creando';
$this->params['breadcrumbs'][] = ['label' => 'Asignamiento TB/Cheque', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$isNewRecord = 'ok';
?>
<div class="transfer-assignment-create">
    <?= $this->render('_form', compact('model', 'isNewRecord')) ?>
</div>
