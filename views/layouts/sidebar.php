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
                <a v-on:click="showContent" class="sidebar-link" href="<?= Yii::$app->homeUrl ?>">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Menu de Inicio</span>
                </a>
            </li>

            <li class="sidebar-header">
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
            </li>

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
                <a class="sidebar-link" href="<?= Url::to(['/project/beneficiary/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Beneficarios</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/project/position/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Posiciones</span>
                </a>
            </li>

            <li class="sidebar-header">
                QuickBook
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/qb/list-class/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Clases</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/qb/chart-account/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Cuentas</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/qb/chart-account/import']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Importar Cuentas</span>
                </a>
            </li>

            <li class="sidebar-header">
                Movimientos
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/movement/movement/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Movimientos Contables</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/movement/transfer-assignment/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Asignacion TB</span>
                </a>
            </li>

            <li class="sidebar-header">
                Comprobantes
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/movement/voucher/upload-voucher-format']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Formato Voucher</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/movement/transfer-assignment/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Voucher</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Url::to(['/movement/transfer-assignment/index']) ?>">
                    <i class="align-middle" data-feather="arrow-right"></i> <span class="align-middle">Recibos</span>
                </a>
            </li>

            <li class="sidebar-header">
                Libros de Banco
            </li>
        </ul>
    </div>
</nav>