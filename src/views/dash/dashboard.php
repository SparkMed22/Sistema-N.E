<?php
$title = "HGI - Principal";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$rol = $_SESSION['user_rol'] ?? null;

if (!$rol) {
    header("Location: /login");
    exit;
}

$roles = [
    'admin' => [
        'gestionar_usuarios',
        'gestionar_pacientes',
        'gestionar_stock',
        'gestionar_ordenes'
    ],

    'internacion' => [
        'gestionar_pacientes'
    ],

    'nutricionista' => [
        'gestionar_pacientes',
        'gestionar_stock',
        'gestionar_ordenes'
    ]
];

$accesosGlobales = [
    'gestionar_usuarios' => [
        'icono'   => 'group',
        'titulo'  => 'Usuarios',
        'desc'    => 'Gestión de usuarios, roles y permisos del sistema.',
        'url'     => '/start/dashboard/users',
        'permiso' => 'gestionar_usuarios'
    ],

    'gestionar_pacientes' => [
        'icono'   => 'personal_injury',
        'titulo'  => 'Pacientes',
        'desc'    => 'Admisión, altas e historial clínico de pacientes.',
        'url'     => '/start/dashboard/patients',
        'permiso' => 'gestionar_pacientes'
    ],

    'gestionar_stock' => [
        'icono'   => 'inventory_2',
        'titulo'  => 'Stock',
        'desc'    => 'Inventario, control de medicamentos y suministros.',
        'url'     => '/start/dashboard/stock',
        'permiso' => 'gestionar_stock'
    ],
    'gestionar_ordenes' => [
        'icono'   => 'prescriptions',
        'titulo'  => 'Órdenes de Fórmulas',
        'desc'    => 'Gestión de prescripciones y órdenes de fórmulas enterales.',
        'url'     => '/start/dashboard/orders',
        'permiso' => 'gestionar_ordenes'
    ],
];

$permisos = $roles[$rol] ?? [];

require __DIR__ . '/../../utils/head.php';
?>


<body class="bg-background text-on-background font-body-md min-h-screen flex flex-col">

    <?php require __DIR__ . '/../../utils/header.php'; ?>
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-2">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12 lg:py-20">
            <section class="grid lg:grid-cols-[1.4fr_0.6fr] gap-10 lg:gap-16 items-center mb-16">
                <div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight lea|ding-[1.05] text-text">
                        Nutrición Enteral
                        <span class="block text-primary">
                            más inteligente.
                        </span>
                    </h1>

                    <p class="mt-6 max-w-2xl text-base lg:text-lg leading-8 text-text-muted">
                        Plataforma centralizada para el seguimiento
                        de pacientes y gestión de fórmulas enterales
                        del Hospital General de Itapúa.
                    </p>
                </div>
            </section>

            <section id="modulos">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-7">
                    <div>
                        <p class="text-xs uppercase tracking-wider font-bold text-secondary mb-2">
                            Módulos principales
                        </p>
                        <h2 class="text-2xl lg:text-3xl font-extrabold text-text"> Accesos del sistema</h2>
                    </div>
                    <p class="text-sm text-text-muted max-w-md md:text-right">
                        Selecciona un módulo para comenzar a trabajar.
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <?php foreach ($accesosGlobales as $acceso): ?>
                        <?php if (!in_array($acceso['permiso'], $permisos, true)) continue; ?>
                        <a href="<?= htmlspecialchars($acceso['url']) ?>"
                            class="group card-hover bg-surface-container-lowest border border-outline-variant rounded-2xl p-6 transition-colors">
                            <div class="icon-box w-12 h-12 rounded-xl bg-primary-fixed text-primary flex items-center justify-center mb-5">
                                <span class="material-symbols-outlined text-2xl">
                                    <?= htmlspecialchars($acceso['icono']) ?>
                                </span>
                            </div>
                            <div class="flex items-start justify-between gap-3">
                                <h3 class="font-bold text-base text-on-surface">
                                    <?= htmlspecialchars($acceso['titulo']) ?>
                                </h3>
                                <span class="material-symbols-outlined text-on-surface-variant group-hover:text-primary transition-colors">
                                    arrow_forward
                                </span>
                            </div>
                            <p class="mt-2 text-sm leading-6 text-on-surface-variant">
                                <?= htmlspecialchars($acceso['desc']) ?>
                            </p>
                        </a>

                    <?php endforeach; ?>

                </div>

            </section>

        </div>
    </main>
    <?php require __DIR__ . '/../../utils/footer.php'; ?>
    <script src="/assets/js/script.js" defer></script>
</body>

</html>