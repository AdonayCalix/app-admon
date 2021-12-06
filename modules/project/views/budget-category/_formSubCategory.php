<div class="form-group" id="add-sub-category">
    <?php

    use kartik\builder\BaseForm;
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
        'formName' => 'SubCategory',
        'checkboxColumn' => false,
        'actionColumn' => false,
        'attributeDefaults' => [
            'type' => TabularForm::INPUT_TEXT,
        ],
        'attributes' => [
            "id" => ['type' => BaseForm::INPUT_HIDDEN, 'columnOptions' => ['hidden' => true]],
            'account_number' => ['type' => BaseForm::INPUT_TEXT, 'label' => 'Partida', 'columnOptions' => ['width' => '10%']],
            'name' => ['type' => BaseForm::INPUT_TEXT, 'label' => 'Nombre'],
            'module' => ['type' => BaseForm::INPUT_TEXT, 'label' => 'Modulo'],
            'intervention' => ['type' => BaseForm::INPUT_TEXT, 'label' => 'Intervencion'],
            'del' => [
                'type' => 'raw',
                'label' => '',
                'value' => function ($model, $key) {
                    return
                        Html::hiddenInput('Children[' . $key . '][id]', (!empty($model['id'])) ? $model['id'] : "") .
                        Html::a('<i class="fa fa-trash"></i>', '#', ['title' => 'Delete', 'onClick' => 'delRowSubCategory(' . $key . '); return false;', 'id' => 'sub-category-del-btn']);
                },
            ],
        ],
        'gridSettings' => [
            'panel' => [
                'heading' => false,
                'type' => GridView::TYPE_DEFAULT,
                'before' => false,
                'footer' => false,
                'after' => Html::button('<i class="fa fa-plus"></i> ' . 'Agregar', ['type' => 'button', 'class' => 'btn btn-success kv-batch-create', 'onClick' => 'addRowSubCategory()']),
            ]
        ]
    ]);
    echo "    </div>\n\n";
    ?>

