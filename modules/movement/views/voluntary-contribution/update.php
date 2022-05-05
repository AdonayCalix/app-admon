<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\VoluntaryContribution */

$this->title = 'Update Voluntary Contribution: ' . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Voluntary Contribution', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="voluntary-contribution-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
