<?php

use kartik\base\BootstrapInterface;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\qb\models\ChartAccount */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="chart-account-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterface::SIZE_SMALL],
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <?= $form->field($model, 'account_number')->textInput(['maxlength' => true, 'placeholder' => 'Numero de Cuenta']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nombre']) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'placeholder' => 'Descripcion']) ?>

    <?= $form->field($model, 'type')->widget(Select2::class, [
        'data' => ArrayHelper::map($accountTypes, 'id', 'value'),
        'options' => ['placeholder' => '[SELECCIONE]'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'currency')->widget(Select2::class, [
        'data' => ArrayHelper::map($currencies, 'id', 'value'),
        'options' => ['placeholder' => '[SELECCIONE]'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancelar'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
