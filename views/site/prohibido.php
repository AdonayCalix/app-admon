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
    <h1 class="text-bold text-center"><?= Html::encode('403: No tienes permiso para ejecutar la acción') ?></h1>

    <p class="text-center">
        Que extraño, estas intentanto acceder a un sitio para el cual no estas autorizado, muy sospechoso. <br>
        <a href="mailto: soporte@ceprosaf.org">Si piensas que tienes permiso para realizar la accion contacta con IT
            para otorgarte acceso. Gracias.</a>
    </p>

    <?php $this->registerJsFile(Yii::$app->request->baseUrl . '/js/lottie.js'); ?>

    <div class="text-center">
        <lottie-player
            class src="<?= Yii::$app->request->baseUrl . '/json/forbidden.json' ?>" background="transparent"
            speed="1" style="width: 300px; height: 300px;" loop autoplay>
        </lottie-player>
    </div>

    <div class="text-center">
        <a class="btn btn-flat btn-success" href="<?= Yii::$app->homeUrl?>">Volver al inicio</a>
    </div>

</div>