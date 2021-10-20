<?php

use yii\data\ArrayDataProvider;

$providerSubCategorieDetail = new ArrayDataProvider([
    'allModels' => $model->budgetCategories,
]);

?>


<div class="bg-white">

    <?php if ($providerSubCategorieDetail->totalCount) {
        $gridSubCategorieDetail = [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => 'Nombre',
            ],
            [
                'attribute' => 'identifier',
                'label' => 'Identificador',
            ],
        ];

        echo \yii\grid\GridView::widget([
            'dataProvider' => $providerSubCategorieDetail,
            'columns' => $gridSubCategorieDetail,
            'summary' => false,
            'showFooter' => false,
        ]);

    }
    ?>

</div>
