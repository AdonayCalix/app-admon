<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Transfer */

$this->title = 'Re Asignamiento' . ' ' . $model->number;
$this->params['breadcrumbs'][] = $model->number;
$this->params['breadcrumbs'][] = 'Re Asignamiento';
$this->params['breadcrumbs'][] = 'Editando';
?>
<div class="transfer-update">

    <?= $this->render('_form', [
        'model' => $model,
        'has_v2' => $has_v2
    ]) ?>

</div>
