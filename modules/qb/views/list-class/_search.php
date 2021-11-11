<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\qb\models\ListClassSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-list-class-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'identifier')->textInput(['maxlength' => true, 'placeholder' => 'Identifier']) ?>

    <?= $form->field($model, 'is_parent')->textInput(['maxlength' => true, 'placeholder' => 'Is Parent']) ?>

    <?= $form->field($model, 'sub_class')->textInput(['maxlength' => true, 'placeholder' => 'Sub Class']) ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
