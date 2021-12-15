<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\VoucherElementsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="form-voucher-elements-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true, 'placeholder' => 'Number']) ?>

    <?= $form->field($model, 'emission_date')->textInput(['maxlength' => true, 'placeholder' => 'Emission Date']) ?>

    <?= $form->field($model, 'beneficiary')->textInput(['maxlength' => true, 'placeholder' => 'Beneficiary']) ?>

    <?= $form->field($model, 'concept')->textInput(['maxlength' => true, 'placeholder' => 'Concept']) ?>

    <?php /* echo $form->field($model, 'amount')->textInput(['maxlength' => true, 'placeholder' => 'Amount']) */ ?>

    <?php /* echo $form->field($model, ' amount_total')->textInput(['maxlength' => true, 'placeholder' => ' Amount Total']) */ ?>

    <?php /* echo $form->field($model, 'detail_body')->textInput(['maxlength' => true, 'placeholder' => 'Detail Body']) */ ?>

    <?php /* echo $form->field($model, 'header_body')->textInput(['maxlength' => true, 'placeholder' => 'Header Body']) */ ?>

    <?php /* echo $form->field($model, 'project_id')->widget(\kartik\widgets\Select2::classname(), [
        'data' => \yii\helpers\ArrayHelper::map(\app\modules\movement\models\Project::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Choose Project'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); */ ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
