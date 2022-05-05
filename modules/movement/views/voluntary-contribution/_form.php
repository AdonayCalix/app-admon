<?php

use app\assets\MoneyAsset;
use app\assets\VueSelectAsset;
use kartik\base\BootstrapInterface;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\movement\models\VoluntaryContribution */

\mootensai\components\JsBlock::widget(['viewFile' => '_script', 'pos'=> \yii\web\View::POS_END]);

VueSelectAsset::register($this);
MoneyAsset::register($this);
?>

<div class="voluntary-contribution-form">

    <?php $form = ActiveForm::begin([
        'errorSummaryCssClass' => 'text-danger'
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <div class="row">
        <div class="col-md-3">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nombre']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'date')->widget(\kartik\datecontrol\DateControl::class, [
                'type' => \kartik\datecontrol\DateControl::FORMAT_DATE,
                'saveFormat' => 'php:Y-m-d',
                'ajaxConversion' => true,
                'options' => [
                    'pluginOptions' => [
                        'placeholder' => '',
                        'autoclose' => true
                    ]
                ],
            ]); ?>
        </div>
    </div>

    <?= Yii::$app->controller->renderPartial('_formVoluntaryContributionDetail') ?>

    <br>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
        <?= Html::a(Yii::t('app', 'Cancelar'), Yii::$app->request->referrer , ['class'=> 'btn btn-danger btn-sm']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
