<div class="form-group" id="add-budget-category">
    <?php

    use kartik\grid\GridView;
    use kartik\builder\TabularForm;
    use yii\data\ArrayDataProvider;
    use yii\helpers\Html;

    $dataProvider = new ArrayDataProvider([
        'allModels' => $row,
        'pagination' => [
            'pageSize' => -1
        ]
    ]);
    echo TabularForm::widget([
        'dataProvider' => $dataProvider,
        'formName' => 'BudgetCategory',
        'checkboxColumn' => false,
        'actionColumn' => false,
        'attributeDefaults' => [
            'type' => TabularForm::INPUT_TEXT,
        ],
        'attributes' => [
            "id" => ['type' => TabularForm::INPUT_HIDDEN, 'columnOptions' => ['hidden' => true]],
            'name' => ['type' => TabularForm::INPUT_TEXT, 'label' => 'Nombre'],
            'identifier' => ['type' => TabularForm::INPUT_TEXT, 'label' => 'Identificador'],
            'del' => [
                'type' => 'raw',
                'label' => '',
                'value' => function ($model, $key) {
                    return
                        Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                        Html::a('<i class="fa fa-trash"></i>', '#', ['title' => 'Delete', 'onClick' => 'delRowBudgetCategory(' . $key . '); return false;', 'id' => 'budget-category-del-btn']);
                },
            ],
        ],
        'gridSettings' => [
            'panel' => [
                'condesed' => true,
                'striped' => true,
                'heading' => false,
                'type' => GridView::TYPE_DEFAULT,
                'before' => false,
                'footer' => false,
                'after' => Html::button('<i class="fa fa-plus"></i> ' . 'Agregar', ['type' => 'button', 'class' => 'btn btn-success btn-sm kv-batch-create', 'onClick' => 'addRowBudgetCategory()']),
            ],
            'headerContainer' => ['class' => '']
        ]
    ]);
    echo "    </div>\n\n";
    ?>

