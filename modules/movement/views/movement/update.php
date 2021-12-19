<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Transfer */

$this->title = 'Actualizando Movimiento: ' . ' ' . $model->number;
$this->params['breadcrumbs'][] = ['label' => 'Movimiento', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Editando';
?>
<div class="transfer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
