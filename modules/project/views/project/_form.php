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
JsBlock::widget(['viewFile' => '_script',     'pos' => View::POS_END,
    'viewParams' => [
        'class' => 'ProjectPeriod',
        'relID' => 'project-period',
        'value' => Json::encode($model->projectPeriods),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
JsBlock::widget(['viewFile' => '_script', 'pos' => View::POS_END,
    'viewParams' => [
        'class' => 'UserProject',
        'relID' => 'user-project',
        'value' => Json::encode($model->userProject),
        'isNewRecord' => ($model->isNewRecord) ? 1 : 0
    ]
]);
?>

    <div class="project-form">

        <?php $form = ActiveForm::begin([
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'formConfig' => ['labelSpan' => 2, 'deviceSize' => BootstrapInterface::SIZE_SMALL],
            'errorSummaryCssClass' => 'text-danger'
        ]); ?>

        <?= $form->errorSummary($model); ?>

        <?= $form->field($model, 'id', ['template' => '{input}'])->textInput(['style' => 'display:none']); ?>

        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nombre']) ?>

        <?= $form->field($model, 'alias')->textInput(['maxlength' => true, 'placeholder' => 'Alias']) ?>

        <?= $form->field($model, 'frecuency')->textInput(['maxlength' => true, 'placeholder' => 'Frecuencia']) ?>

        <?= $form->field($model, 'start_date',
            [
                'inputOptions' =>
                    [
                        'autocomplete' => 'off',
                        'placeholder' => 'Fecha Inicio',
                    ]
            ]
        )->widget(DatePicker::class,
            [
                'language' => 'es',
                'pluginOptions' => ['autoclose' => true]
            ]
        ); ?>

        <?= $form->field($model, 'end_date',
            [
                'inputOptions' =>
                    [
                        'autocomplete' => 'off',
                        'placeholder' => 'Fecha final',
                    ]
            ]
        )->widget(DatePicker::class,
            [
                'language' => 'es',
                'pluginOptions' => ['autoclose' => true]
            ]
        ); ?>

        <?= $form->field($model, 'budget')->widget(NumberControl::class, [
            'maskedInputOptions' => [
                'prefix' => 'Lps ',
                'allowMinus' => false,
                'rightAlign' => false
            ]
        ]); ?>

        <?= $form->field($model, 'bank')->textInput(['maxlength' => true, 'placeholder' => 'Banco']) ?>

        <?= $form->field($model, 'account_number')->textInput(['maxlength' => true, 'placeholder' => 'Número de Cuenta']) ?>

        <?php
        $forms = [
            [
                'label' => '<i class="fa fa-clock"></i> ' . Html::encode('Periodo de Ejecucion'),
                'content' => $this->render('_formProjectPeriod', [
                    'row' => ArrayHelper::toArray($model->projectPeriods),
                ]),
            ],
            [
                'label' => '<i class="fa fa-book"></i> ' . Html::encode('Presupuestos/POAS'),
                'content' => $this->render('_formProjectBudget', [
                    'row' => ArrayHelper::toArray($model->projectBudgets),
                ]),
            ],
            [
                'label' => '<i class="fa fa-coins"></i> ' . Html::encode('Balance Inicial'),
                'content' => $this->render('_formInitialBalance', [
                    'model' => $model,
                    'form' => $form,
                ]),
            ],
            [
                'label' => '<i class="fa fa-user"></i> ' . Html::encode('Usuarios'),
                'content' => $this->render('_formUserProject', [
                    'row' => ArrayHelper::toArray($model->userProject),
                ]),
            ],
        ];
        echo kartik\tabs\TabsX::widget([
            'items' => $forms,
            'position' => kartik\tabs\TabsX::POS_ABOVE,
            'encodeLabels' => false,
            'pluginOptions' => [
                'bordered' => true,
                'sideways' => true,
                'enableCache' => false,
            ],
        ]);
        ?>

        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Crear' : 'Actualizar', ['class' => $model->isNewRecord ? 'btn btn-success btn-sm' : 'btn btn-primary btn-sm']) ?>
            <?= Html::a(Yii::t('app', 'Cancelar'), Yii::$app->request->referrer, ['class' => 'btn btn-danger btn-sm']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>

<?php
$script = <<< JS
$(':input').attr("autocomplete", "off");
JS;
$this->registerJs($script);
?>