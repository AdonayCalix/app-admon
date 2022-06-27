<?php

use yii\helpers\Url;

$menu = [
    'items' => [
        [
            'label' => 'Administrador',
            'icon' => false,
            'onlySuperAdmin' => true,
            'visible' => true,
            'items' => [
                [
                    'label' => 'Usuarios',
                    'url' => Url::to(['/user-management/user/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => true,
                    'visible' => true
                ],
                [
                    'label' => 'Registro de Visitas',
                    'url' => Url::to(['/user-management/user-visit-log/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => true,
                    'visible' => true
                ],
                [
                    'label' => 'Grupo de Permisos',
                    'url' => Url::to(['/user-management/auth-item-group/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => true,
                    'visible' => true
                ],
                [
                    'label' => 'Permisos',
                    'url' => Url::to(['/user-management/permission/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => true,
                    'visible' => true
                ],
                [
                    'label' => 'Roles',
                    'url' => Url::to(['/user-management/role/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => true,
                    'visible' => true
                ]
            ]
        ],
        [
            'label' => 'Proyecto',
            'icon' => false,
            'onlySuperAdmin' => false,
            'visible' => true,
            'items' => [
                [
                    'label' => 'Proyecto',
                    'url' => Url::to(['/project/project/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Periodos de Ejecucion',
                    'url' => Url::to(['/project/project-period/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Presupuestos/POAS',
                    'url' => Url::to(['/project/project-budget/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Desembolsos',
                    'url' => Url::to(['/project/disbursed/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Categorias',
                    'url' => Url::to(['/project/budget-category/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Beneficiarios',
                    'url' => Url::to(['/project/beneficiary/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ]
            ]
        ],
        [
            'label' => 'Anticipo de Gastos',
            'icon' => false,
            'onlySuperAdmin' => false,
            'visible' => true,
            'items' => [
                [
                    'label' => 'Solicitud de Anticipo',
                    'url' => Url::to(['/expense/expense-request/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Detalle de Gastos',
                    'url' => Url::to(['/expense/advance-detail/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Lugares de Destino',
                    'url' => Url::to(['/expense/places/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ]
            ]
        ],
        [
            'label' => 'QuickBook',
            'icon' => false,
            'onlySuperAdmin' => true,
            'visible' => true,
            'items' => [
                [
                    'label' => 'Clases',
                    'url' => Url::to(['/qb/list-class/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Catalogo de Cuentas',
                    'url' => Url::to(['/qb/chart-account/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Importar Cuentas',
                    'url' => Url::to(['/qb/chart-account/import']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ]
            ]
        ],
        [
            'label' => 'Movimientos',
            'icon' => false,
            'onlySuperAdmin' => true,
            'visible' => true,
            'items' => [
                [
                    'label' => 'Movimientos Contables',
                    'url' => Url::to(['/movement/movement/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Aporte Voluntario',
                    'url' => Url::to(['/movement/voluntary-contribution/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Importar QuickBook',
                    'url' => Url::to(['/movement/import/to-qb']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Bitacora QB',
                    'url' => Url::to(['/movement/qb-movement-log/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ]
            ]
        ],
        [
            'label' => 'Configuracion Comprobantes',
            'icon' => false,
            'onlySuperAdmin' => true,
            'visible' => true,
            'items' => [
                [
                    'label' => 'Formato Vaucher',
                    'url' => Url::to(['/movement/voucher-format/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Asignacion Formato',
                    'url' => Url::to(['/movement/voucher-elements/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Formato Sol. Cheque',
                    'url' => Url::to(['/movement/check-format/index']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ]
            ]
        ],
        [
            'label' => 'Generar Documentos',
            'icon' => false,
            'onlySuperAdmin' => true,
            'visible' => true,
            'items' => [
                [
                    'label' => 'Libro de Banco',
                    'url' => Url::to(['/project/book-bank/generate']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ],
                [
                    'label' => 'Formato Financiero',
                    'url' => Url::to(['/project/financial-format/generate']),
                    'icon' => 'arrow-right',
                    'onlySuperAdmin' => false,
                    'visible' => true
                ]
            ]
        ]
    ]
];

?>
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <img src="<?= Yii::getAlias('@web') . '/ website/ logo_mini . png' ?>" height="30" alt="">
            &nbsp;
            <span class="align-middle"><?= 'App Admon' ?></span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Paginas
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="<?= Yii::$app->homeUrl ?>">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Menu de Inicio</span>
                </a>
            </li>

            <?php foreach ($menu as $items): ?>
                <?php foreach ($items as $item): ?>

                    <?php if (!Yii::$app->user->isGuest): ?>
                        <li class="sidebar-header">
                            <?= $item['label'] ?>
                        </li>

                        <?php foreach ($item['items'] as $subItem): ?>
                            <li class="sidebar-item <?= Yii::$app->request->url === $subItem['url'] ? 'active' : '' ?>">
                                <a class="sidebar-link" href="<?= $subItem['url'] ?>">
                                    <i class="align-middle"
                                       data-feather="<?= $subItem['icon'] ?>">
                                    </i>
                                    <span class="align-middle"><?= $subItem['label'] ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>

                    <?php endif; ?>
                <?PHP endforeach; ?>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>

<script>
    document.querySelector('#siuuu').scrollIntoView({
        behavior: 'smooth'
    });
</script>