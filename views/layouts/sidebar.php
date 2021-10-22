<?php

use yii\helpers\Url;

?>
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <img src="<?= Yii::getAlias('@web') . '/website/logo_mini.png' ?>" height="30" alt="">
            &nbsp;
            <span class="align-middle"><?= 'App Admon' ?></span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Paginas
            </li>

            <li class="sidebar-item active">
                <a class="sidebar-link" href="<?= Yii::$app->homeUrl ?>">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Menu de Inicio</span>
                </a>
            </li>

           <!-- <li class="sidebar-header">
                Administrador
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?/*= Url::to(['/user-management/user/index']) */?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Usuarios</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?/*= Yii::$app->homeUrl */?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Perfil</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?/*= Url::to(['/user-management/user-visit-log/index']) */?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Registro de Visitas</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?/*= Url::to(['/user-management/auth-item-group/index']) */?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Grupo de Permisos</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?/*= Url::to(['/user-management/permission/index']) */?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Permisos</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?/*= Url::to(['/user-management/role/index']) */?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Roles</span>
                </a>
            </li>-->

            <li class="sidebar-header">
                Proyecto
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/project/project/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Proyectos</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/project/project-period/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Periodos de Ejecucion</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/project/project-budget/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Presupuestos/POAS</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/project/budget-category/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Categorias</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/project/project/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Sub Categorias</span>
                </a>
            </li>

            <li class="sidebar-header">
                Libros de Banco
            </li>
        </ul>
    </div>
</nav>