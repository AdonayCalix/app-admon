<div class="form-group" id="add-project-period">
    <?php

    use kartik\builder\BaseForm;
    use kartik\grid\GridView;
    use kartik\builder\TabularForm;
    use kartik\widgets\DatePicker;
    use yii\data\ArrayDataProvider;
    use yii\helpers\Html;
    use yii\widgets\Pjax;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $row,
        'pagination' => [
            'pageSize' => -1
        ]
    ]);
    echo TabularForm::widget([
        'dataProvider' => $dataProvider,
        'formName' => 'ProjectPeriod',
        'checkboxColumn' => false,
        'actionColumn' => false,
        'attributeDefaults' => [
            'type' => BaseForm::INPUT_TEXT,
        ],
        'attributes' => [
            "id" => ['type' => BaseForm::INPUT_HIDDEN, 'columnOptions' => ['hidden' => true]],
            'name' => ['type' => BaseForm::INPUT_TEXT, 'label' => 'Nombre'],
            'start_date' => [
                'label' => 'Fecha Inicio',
                'type' => BaseForm::INPUT_WIDGET,
                'widgetClass' => DatePicker::class,
                'options' => [
                    'options' => [
                        'autocomplete' => 'off'
                    ],
                    'language' => 'es',
                    'pluginOptions' => [
                        'autoclose' => true,
                    ]
                ]
            ],
            'end_date' => [
                'label' => 'Fecha Final',
                'type' => BaseForm::INPUT_WIDGET,
                'widgetClass' => DatePicker::class,
                'options' => [
                    'options' => [
                        'autocomplete' => 'off'
                    ],
                    'language' => 'es',
                    'pluginOptions' => [
                        'autoclose' => true,
                    ]
                ],
                'option' => [
                    'autocomplete' => 'off'
                ]
            ],
        ],
        'gridSettings' => [
            'panel' => [
                'heading' => false,
                'type' => GridView::TYPE_DEFAULT,
                'before' => false,
                'footer' => false,
                'after' => Html::button('<i class="align-middle" data-feather="plus-circle"></i>&nbsp; ' . 'Agregar', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowProjectPeriod()']),
            ]
        ]
    ]);
    echo "    </div>\n\n";
    ?>

