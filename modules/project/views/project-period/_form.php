<?php

use app\modules\project\models\Project;
use kartik\base\BootstrapInterface as BootstrapInterfaceAlias;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\ProjectPeriod */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="project-period-form">

    <?php $form = ActiveForm::begin([
        'type' => ActiveForm::TYPE_HORIZONTAL,
        'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterfaceAlias::SIZE_SMALL]
    ]); ?>

    <?= $form->field($model, 'project_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Project::find()->orderBy('id')->asArray()->all(), 'id', 'name'),
        'options' => ['placeholder' => '[SELECCIONE]'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nombre']) ?>

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

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Cancelar'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
