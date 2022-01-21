<?php

use kartik\base\BootstrapInterface;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\CheckFormat */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="check-format-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterface::SIZE_SMALL],
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <?= $form->field($model, 'project_id')->widget(\kartik\widgets\Select2::class, [
        'data' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Project::find()->orderBy('id')->asArray()->all(), 'id', 'alias'),
        'options' => ['placeholder' => '[SELECCIONE]'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($checkLogo, 'logoFile')->fileInput()->label('Logo') ?>

    <?= $form->field($model, 'elaborated_by')->textInput(['maxlength' => true, 'placeholder' => 'Elaborado Por']) ?>

    <?= $form->field($model, 'checked_by')->textInput(['maxlength' => true, 'placeholder' => 'Revisado Por']) ?>

    <?= $form->field($model, 'authorized_by')->textInput(['maxlength' => true, 'placeholder' => 'Autorizado Por']) ?>

    <?= $form->field($model, 'aproved_main_director_by')->textInput(['maxlength' => true, 'placeholder' => 'Vo.Bo. Directora Ejecutiva']) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
