<?php

use kartik\date\DatePicker;
use kartik\number\NumberControl;
use kartik\select2\Select2;

echo $form->field($model, 'initial_balance')->widget(NumberControl::class, [
    'maskedInputOptions' => [
        'prefix' => 'Lps ',
        'allowMinus' => false,
        'rightAlign' => false
    ]
]);

echo $form->field($model, 'date_initial_balance',
    [
        'inputOptions' =>
            [
                'autocomplete' => 'off',
                'placeholder' => 'Fecha Inicio Balance',
            ]
    ]
)->widget(DatePicker::class,
    [
        'language' => 'es',
        'pluginOptions' => ['autoclose' => true]
    ]
); ?>