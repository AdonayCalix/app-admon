<?php


/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Transfer */

$this->title = 'Movimientos';
$this->params['breadcrumbs'][] = ['label' => 'Transfer', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transfer-create">

    <div class="mb-3">
        <h1 class="h3 d-inline align-middle"><?= $this->title ?></h1>
    </div>

    <?= $this->render('_form', compact('model')) ?>
</div>

