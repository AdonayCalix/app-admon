<?php

use yii\bootstrap5\Html;

?>
<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" data-bs-toggle="dropdown">
                    <i class="align-middle avatar img-fluid rounded me-1" data-feather="user"></i> <span class="text-dark"><?= Yii::$app->user->username ?></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item"><i class="align-middle me-1" data-feather="user"></i> Perfil</a>
                    <div class="dropdown-divider"></div>

                    <?= Html::a(
                        'Cerrar Sesion',
                        ['/user-management/auth/logout'],
                        [
                            'data-method' => 'post',
                            'class' => 'dropdown-item',
                            'data-toogle' => 'modal',
                            'data-target' => '#logoutModal'
                        ]
                    ) ?>

                </div>
            </li>
        </ul>
    </div>
</nav>