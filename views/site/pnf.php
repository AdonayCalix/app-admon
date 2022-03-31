<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">
    <br><br>
    <h1 class="text-bold text-center"><?= Html::encode('404: Parece que la pagina que buscas no existe') ?></h1>

    <p class="text-center">
        No estoy seguro sobre que estabas buscando por aqui.
        <a href="mailto: support@ceprosaf.org">Contacta con IT si piensas que es un error del sistema. Gracias.</a>
    </p>

    <?php $this->registerJsFile(Yii::$app->request->baseUrl . '/js/lottie.js'); ?>

    <div class="text-center">
        <lottie-player
            class src="<?= Yii::$app->request->baseUrl . '/json/not-found.json' ?>"  background="transparent"  speed="1"  style="width: 300px; height: 300px;"  loop  autoplay >
        </lottie-player>
    </div>

    <div class="text-center">
        <a class="btn btn-flat btn-success" href="<?= Yii::$app->homeUrl?>">Volver al inicio</a>
    </div>

</div>