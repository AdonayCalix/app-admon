<?php

use yii\bootstrap5\Html;

?>
<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <li class="">
                <a class="nav-link d-none d-sm-inline-block" data-bs-toggle="">
                    <i class="align-middle avatar img-fluid rounded me-1" data-feather="user"></i> <span class="text-dark"><?= Yii::$app->user->username ?></span>
                </a>
                <?= Html::a(
                    Yii::$app->user->isGuest ? "Iniciar Sesion" : "Cerrar Sesion",
                    Yii::$app->user->isGuest ? ['/user-management/auth/login'] : ['/user-management/auth/logout'],
                    [
                        'data-method' => 'post',
                        'class' => ''
                    ]
                ) ?>
            </li>
        </ul>
    </div>
</nav>