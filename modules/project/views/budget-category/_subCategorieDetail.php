<?php

use yii\data\ArrayDataProvider;

$providerSubCategorieDetail = new ArrayDataProvider([
    'allModels' => $model->subCategories,
]);

?>


<div class="bg-white">

<?php if ($providerSubCategorieDetail->totalCount) {
    $gridSubCategorieDetail = [
        ['class' => 'yii\grid\SerialColumn'],
        [
            'attribute' => 'account_number',
            'label' => 'Numero de Partida',
        ],
        [
            'attribute' => 'name',
            'label' => 'Nombre',
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
