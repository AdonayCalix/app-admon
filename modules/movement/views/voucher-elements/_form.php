<?php

use kartik\base\BootstrapInterface;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\VoucherElements */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="voucher-elements-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterface::SIZE_SMALL],
        'errorSummaryCssClass' => 'text-danger',
    ]); ?>

    <?= $form->field($model, 'project_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Project::find()->orderBy('id')->asArray()->all(), 'id', 'alias'),
        'options' => ['placeholder' => '[SELECCIONE]'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($voucherFormatLogo, 'logoFile')->fileInput()->label('Logo') ?>

    <?= $form->field($model, 'number')->textInput(['maxlength' => true, 'placeholder' => 'Numero TB/Cheque']) ?>

    <?= $form->field($model, 'emission_date')->textInput(['maxlength' => true, 'placeholder' => 'Fecha de Emision']) ?>

    <?= $form->field($model, 'header_body')->textInput(['maxlength' => true, 'placeholder' => 'Cabecera (FM)']) ?>

    <?= $form->field($model, 'beneficiary')->textInput(['maxlength' => true, 'placeholder' => 'Nombre Beneficiario']) ?>

    <?= $form->field($model, 'concept')->textInput(['maxlength' => true, 'placeholder' => 'Concepto']) ?>

    <?= $form->field($model, 'amount')->textInput(['maxlength' => true, 'placeholder' => 'Monto En Palabras']) ?>

    <?= $form->field($model, 'detail_body')->textInput(['maxlength' => true, 'placeholder' => 'Detalles']) ?>

    <?= $form->field($model, 'kind_detail')->textInput(['maxlength' => true, 'placeholder' => 'Estilo de Detalle']) ?>

    <?= $form->field($model, 'amount_total')->textInput(['maxlength' => true, 'placeholder' => 'Monto Total']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancelar'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
