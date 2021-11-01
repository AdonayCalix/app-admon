<?php

/* @var $this View */
/* @var $content string */

use app\assets\AppAsset;
use yii\bootstrap5\Html;
use yii\web\View;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <?php $this->registerCsrfMetaTags() ?>
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/website/ceprosaf.ico"/>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<div class="wrapper">

    <?= $this->render('sidebar', ['title' => $this->title]) ?>

    <div class="main">

        <?= $this->render('navbar') ?>

        <div id="moose"></div>

        <main class="content">
            <div class="container-fluid p-0">
                <?= $content ?>
            </div>
        </main>

        <?= $this->render('footer') ?>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js" crossorigin="anonymous"></script>

<script>
    var loadContent = new Vue({
        el: '#sidebar',
        data: {
            name: ''
        },

        methods: {
            showContent: function (event) {
                event.preventDefault();
                
                axios.get('project/project/index')
                    .then(function (response) {
                        document.getElementById('moose').innerHTML = response.data;

                    });
            }
        }
    })

</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
