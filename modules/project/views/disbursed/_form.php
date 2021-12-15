<?php

use kartik\base\BootstrapInterface;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\number\NumberControl;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\Disbursed */
/* @var $form yii\widgets\ActiveForm */

?>

    <div class="disbursed-form">

        <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterface::SIZE_SMALL],
            'errorSummaryCssClass' => 'text-danger'
        ]); ?>

        <?= $form->field($model, 'project_id')->widget(\kartik\widgets\Select2::class, [
            'data' => \yii\helpers\ArrayHelper::map(\app\modules\project\models\Project::find()->orderBy('id')->asArray()->all(), 'id', 'alias'),
            'options' => ['placeholder' => '[SELECCIONE]'],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>

        <?= $form->field($model, 'period_id')->widget(DepDrop::class, [
            'options' => ['placeholder' => '[SELECCIONE]'],
            'type' => DepDrop::TYPE_SELECT2,
            'data' => $model->isNewRecord ? [] : [$model->period_id => $model->period->name ?? ''],
            'select2Options' => ['pluginOptions' => ['allowClear' => true]],
            'pluginOptions' => [
                'depends' => ['disbursed-project_id'],
                'url' => Url::to(['get-periods']),
                'loadingText' => 'Cargando...',
                'allowClear' => true
            ]
        ]) ?>

        <?= $form->field($model, 'date',
            [
                'inputOptions' =>
                    [
                        'autocomplete' => 'off',
                        'placeholder' => 'Fecha',
                    ]
            ]
        )->widget(DatePicker::class,
            [
                'language' => 'es',
                'pluginOptions' => ['autoclose' => true]
            ]
        ); ?>

        <?= $form->field($model, 'amount')->widget(NumberControl::class, [
            'maskedInputOptions' => [
                'prefix' => 'Lps ',
                'allowMinus' => false,
                'rightAlign' => false
            ]
        ]); ?>

        <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'placeholder' => 'Descripcion']) ?>

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