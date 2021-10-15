<?php

use kartik\base\BootstrapInterface;
use kartik\number\NumberControl;
use kartik\widgets\DatePicker;
use mootensai\components\JsBlock;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Project */
/* @var $form yii\widgets\ActiveForm */

JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_END,
    'viewParams' => [
        'class' => 'ProjectBudget',
        'relID' => 'project-budget',
        'value' => Json::encode($model->projectBudgets),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_END,
    'viewParams' => [
        'class' => 'ProjectPeriod',
        'relID' => 'project-period',
        'value' => Json::encode($model->projectPeriods),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

<div class="project-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterface::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Name']) ?>

    <?= $form->field($model, 'alias')->textInput(['maxlength' => true, 'placeholder' => 'Alias']) ?>

    <?= $form->field($model, 'frecuency')->textInput(['maxlength' => true, 'placeholder' => 'Frecuency']) ?>

    <?= $form->field($model, 'start_date',
        [
            'inputOptions' =>
                [
                    'autocomplete' => 'off',
                    'placeholder' => 'Indique la fecha de inicio',
                ]
        ]
    )->widget(DatePicker::class,
        [
            'language' => 'es',
            'pluginOptions' =>
                [
                    'format' => 'yyyy-mm-dd',
                    'autoclose' => true,
                ]
        ]
    ); ?>

    <?= $form->field($model, 'end_date',
        [
            'inputOptions' =>
                [
                    'autocomplete' => 'off',
                    'placeholder' => 'Indique la fecha final',
                ]
        ]
    )->widget(DatePicker::class,
        [
            'language' => 'es',
            'pluginOptions' =>
                [
                    'format' => 'yyyy-mm-dd',
                    'autoclose' => true,
                ]
        ]
    ); ?>

    <?= $form->field($model, 'budget')->widget(NumberControl::class, [
        'maskedInputOptions' => [
            'prefix' => 'Lps ',
            'allowMinus' => false,
            'rightAlign' => false
        ]
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancelar'), Yii::$app->request->referrer, ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>