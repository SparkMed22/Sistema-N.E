<!DOCTYPE html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Gestión de Usuarios - Hospital General de Itapúa</title>
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
    <!-- Google Fonts: Manrope -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700&amp;display=swap" rel="stylesheet" />
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Tailwind Config defined by the Design System -->
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-error": "#ffffff",
                        "surface-container": "#f0ecf4",
                        "on-secondary": "#ffffff",
                        "on-tertiary-container": "#9c99ff",
                        "tertiary-fixed": "#e2dfff",
                        "on-surface": "#1b1b21",
                        "inverse-surface": "#303036",
                        "surface-container-low": "#f6f2fa",
                        "tertiary-fixed-dim": "#c3c0ff",
                        "primary-fixed": "#e2dfff",
                        "on-tertiary-fixed": "#0f0069",
                        "error-container": "#ffdad6",
                        "tertiary": "#3730a3",
                        "on-tertiary-fixed-variant": "#3b35a7",
                        "on-primary-fixed-variant": "#3e3c8f",
                        "tertiary-container": "#2e259a",
                        "secondary-container": "#645efb",
                        "surface-bright": "#fcf8ff",
                        "surface-container-highest": "#e5e1e9",
                        "error": "#e11d48",
                        "inverse-primary": "#c3c0ff",
                        "surface-tint": "#5654a8",
                        "on-primary-container": "#9c9af4",
                        "secondary": "#4b41e1",
                        "secondary-fixed": "#e2dfff",
                        "surface-variant": "#e2e8f0",
                        "on-secondary-container": "#fffbff",
                        "on-secondary-fixed-variant": "#3323cc",
                        "primary": "#1a146b",
                        "background": "#f8fafc",
                        "inverse-on-surface": "#f3eff7",
                        "on-surface-variant": "#474651",
                        "on-error-container": "#93000a",
                        "surface": "#fcf8ff",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed-dim": "#c3c0ff",
                        "outline": "#6366f1",
                        "outline-variant": "#c8c5d3",
                        "primary-fixed-dim": "#c3c0ff",
                        "on-primary-fixed": "#100563",
                        "on-secondary-fixed": "#0f0069",
                        "surface-container-lowest": "#ffffff",
                        "on-primary": "#ffffff",
                        "on-background": "#1b1b21",
                        "surface-dim": "#dcd9e0",
                        "primary-container": "#312e81",
                        "surface-container-high": "#eae7ef"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "stack-lg": "2rem",
                        "stack-md": "1.5rem",
                        "stack-xs": "0.5rem",
                        "stack-sm": "1rem",
                        "container-padding": "2.5rem",
                        "gutter": "1.5rem"
                    },
                    "fontFamily": {
                        "headline-lg": ["Manrope"],
                        "label-lg": ["Manrope"],
                        "label-md": ["Manrope"],
                        "headline-sm": ["Manrope"],
                        "body-sm": ["Manrope"],
                        "headline-md": ["Manrope"],
                        "body-lg": ["Manrope"],
                        "body-md": ["Manrope"],
                        "headline-xl-mobile": ["Manrope"],
                        "headline-xl": ["Manrope"]
                    },
                    "fontSize": {
                        "headline-lg": ["32px", {
                            "lineHeight": "40px",
                            "letterSpacing": "-0.01em",
                            "fontWeight": "600"
                        }],
                        "label-lg": ["14px", {
                            "lineHeight": "20px",
                            "letterSpacing": "0.01em",
                            "fontWeight": "600"
                        }],
                        "label-md": ["12px", {
                            "lineHeight": "16px",
                            "letterSpacing": "0.02em",
                            "fontWeight": "600"
                        }],
                        "headline-sm": ["20px", {
                            "lineHeight": "28px",
                            "fontWeight": "600"
                        }],
                        "body-sm": ["14px", {
                            "lineHeight": "20px",
                            "fontWeight": "400"
                        }],
                        "headline-md": ["24px", {
                            "lineHeight": "32px",
                            "fontWeight": "600"
                        }],
                        "body-lg": ["18px", {
                            "lineHeight": "28px",
                            "fontWeight": "400"
                        }],
                        "body-md": ["16px", {
                            "lineHeight": "24px",
                            "fontWeight": "400"
                        }],
                        "headline-xl-mobile": ["30px", {
                            "lineHeight": "36px",
                            "fontWeight": "700"
                        }],
                        "headline-xl": ["40px", {
                            "lineHeight": "48px",
                            "letterSpacing": "-0.02em",
                            "fontWeight": "700"
                        }]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .material-symbols-outlined.filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body class="bg-background text-on-background font-body-md min-h-screen flex flex-col">
    <!-- Top Header -->
    <header class="w-full bg-surface-container-lowest border-b border-outline-variant py-4 px-6 md:px-8 shadow-sm">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <img class="w-10 h-10 rounded-full object-cover border border-outline-variant" data-alt="A clean, minimalist abstract logo design suitable for a modern hospital or healthcare institution, using a precise geometry of overlapping crosses or shields in deep indigo and bright white. High contrast, clean vector style." src="https://lh3.googleusercontent.com/aida-public/AB6AXuDwSweb3Bsay6UAzifQXFlJrhBy8MPUhIQ7xUdl5gmQgaZF7uYWM0b2LfD64stocZrOZcYyb9P59bFyT0T4puhOldnAhJblWNrbUda-8k_ooWTlkKGa344A07CeG4zY2q_gIeAHLctGBcY9NxFSHrIaKEFss1eFgWZrTe9Xdy7jgmtJemyp96kF63YqMTFDOEJ3ZYwbXiIGAoJOlkHkF2oiS3SxtVNSVOl6SyaOC4VT1g6G0GUW4huObg" />
                <div>
                    <h1 class="font-headline-sm text-headline-sm font-bold text-primary">Portal de Gestión Hospitalaria</h1>
                    <p class="font-body-sm text-body-sm text-on-surface-variant hidden md:block">Sistema de Nutrición Enteral</p>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <button class="relative text-on-surface-variant hover:text-primary transition-colors">
                    <span class="material-symbols-outlined">notifications</span>
                    <span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full"></span>
                </button>
                <div class="flex items-center gap-3 border-l border-outline-variant pl-6 cursor-pointer">
                    <div class="hidden md:flex flex-col items-end">
                        <span class="font-label-lg text-label-lg text-on-surface">Dr. Roberto Sánchez</span>
                        <span class="font-label-md text-label-md text-on-surface-variant">Administrador</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-primary text-on-primary flex items-center justify-center font-bold">
                        RS
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="flex-1 p-container-padding flex flex-col gap-stack-md w-full max-w-7xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-stack-sm pt-stack-sm">
            <div>
                <h2 class="font-headline-lg text-headline-lg text-on-surface">Gestión de Usuarios</h2>
                <p class="font-body-md text-body-md text-on-surface-variant mt-1">Administre los accesos y roles del personal institucional.</p>
            </div>
            <button class="bg-primary text-on-primary font-label-lg text-label-lg px-6 py-3 rounded-lg flex items-center justify-center gap-2 hover:bg-primary-container transition-colors shadow-sm w-full md:w-auto">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Nuevo Usuario
            </button>
        </div>
        <!-- Filters & Search Bar -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl p-stack-sm flex flex-col lg:flex-row gap-4 items-stretch lg:items-center">
            <!-- Search -->
            <div class="relative flex-1">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input class="w-full bg-surface-container-low border border-outline-variant rounded-lg pl-10 pr-4 py-2 font-body-md text-on-surface focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-all" placeholder="Buscar por nombre, apellido o ID..." type="text" />
            </div>
        </div>
        <!-- Users Data Table (Bento Style Card) -->
        <div class="bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden flex-1 flex flex-col shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[800px]">
                    <thead class="bg-surface-container-low border-b border-surface-variant">
                        <tr>
                            <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Nombre</th>
                            <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Apellido</th>
                            <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Rol</th>
                            <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Estado</th>
                            <th class="py-4 px-6 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-surface-variant font-body-sm text-on-surface">
                        <!-- Row 1 -->
                        <tr class="hover:bg-surface-container-high transition-colors group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-fixed text-on-primary-fixed flex items-center justify-center font-bold text-xs">CM</div>
                                    <span class="font-bold">Carlos</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">Martínez</td>
                            <td class="py-4 px-6">
                                <span class="bg-tertiary-fixed text-on-tertiary-fixed px-2 py-1 rounded-md text-xs font-bold">Médico</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-max">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    Activo
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button class="text-on-surface-variant hover:text-primary transition-colors p-1 rounded hover:bg-surface-container-low">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <button class="text-on-surface-variant hover:text-error transition-colors p-1 rounded hover:bg-surface-container-low">
                                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                </button>
                            </td>
                        </tr>
                        <!-- Row 2 -->
                        <tr class="hover:bg-surface-container-high transition-colors group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-bold text-xs">LA</div>
                                    <span class="font-bold">Laura</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">Ayala</td>
                            <td class="py-4 px-6">
                                <span class="bg-surface-tint text-on-primary px-2 py-1 rounded-md text-xs font-bold">Enfermería</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-max">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    Activo
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button class="text-on-surface-variant hover:text-primary transition-colors p-1 rounded hover:bg-surface-container-low">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <button class="text-on-surface-variant hover:text-error transition-colors p-1 rounded hover:bg-surface-container-low">
                                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                </button>
                            </td>
                        </tr>
                        <!-- Row 3 -->
                        <tr class="hover:bg-surface-container-high transition-colors group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-surface-variant text-on-surface-variant flex items-center justify-center font-bold text-xs">JG</div>
                                    <span class="font-bold text-on-surface-variant">Juan</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-on-surface-variant">Gómez</td>
                            <td class="py-4 px-6">
                                <span class="bg-surface-variant text-on-surface-variant px-2 py-1 rounded-md text-xs font-bold">Administrativo</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-surface-variant text-on-surface-variant px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-max">
                                    <span class="w-2 h-2 rounded-full bg-gray-400"></span>
                                    Inactivo
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button class="text-on-surface-variant hover:text-primary transition-colors p-1 rounded hover:bg-surface-container-low">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <button class="text-on-surface-variant hover:text-error transition-colors p-1 rounded hover:bg-surface-container-low">
                                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                </button>
                            </td>
                        </tr>
                        <!-- Row 4 -->
                        <tr class="hover:bg-surface-container-high transition-colors group">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs">MR</div>
                                    <span class="font-bold">María</span>
                                </div>
                            </td>
                            <td class="py-4 px-6">Rodríguez</td>
                            <td class="py-4 px-6">
                                <span class="bg-primary-container text-on-primary-container px-2 py-1 rounded-md text-xs font-bold">Admin</span>
                            </td>
                            <td class="py-4 px-6">
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1 w-max">
                                    <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                    Activo
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button class="text-on-surface-variant hover:text-primary transition-colors p-1 rounded hover:bg-surface-container-low">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <button class="text-on-surface-variant hover:text-error transition-colors p-1 rounded hover:bg-surface-container-low">
                                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <div class="mt-auto border-t border-surface-variant p-4 flex items-center justify-between bg-surface-container-lowest">
                <span class="font-body-sm text-on-surface-variant">Mostrando 1 a 4 de 24 usuarios</span>
                <div class="flex gap-2">
                    <button class="px-3 py-1 border border-outline-variant rounded bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-low disabled:opacity-50" disabled="">Anterior</button>
                    <button class="px-3 py-1 border border-outline-variant rounded bg-surface-container-lowest text-on-surface-variant hover:bg-surface-container-low">Siguiente</button>
                </div>
            </div>
        </div>
    </main>
    <footer class="border-t border-slate-200 bg-white mt-auto">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-6 flex flex-col md:flex-row items-center justify-between gap-5">
            <!-- Identidad -->
            <div class="flex items-center gap-3">
                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-slate-50 border border-slate-200">
                    <img alt="Hospital General de Itapúa" class="h-7 w-auto object-contain" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCwA6eqNmeZt2ZZmMhKWHJLwtO_cKjUYm0YzznnnpvcilDNzT20MG1on5Dsv29lzkirDCh25dCetl0ejHUS1hdEfYz5BZ8r_jREYFgbTqtgW600brV7GCI_MPwd7tk844mq6Wq6geSAEKKLuQIZu1w6Nx5VBdPsJS1oRWM48soAWZLmsX4RiQNplv6_ciXkwf6jUAvuW7mCSRawlumg3qPVDeG-KdJmeIuHmtKjPjqzkp395oYGE0n1YA" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-700"> Hospital General de Itapúa </p>
                    <p class="text-xs text-slate-400"> Sistema de Nutrición Enteral </p>
                </div>
            </div>
            <div class="flex flex-col sm:flex-row items-center gap-2 sm:gap-5 text-xs">
                <span class="text-slate-400">
                    © 2026 Hospital General de Itapúa
                </span>
                <span class="hidden sm:block h-1 w-1 rounded-full bg-slate-300"></span>
                <span class="text-slate-400">
                    Desarrollado por
                    <span class="font-medium text-slate-600">
                        Francisco David Medina Lourenzo
                    </span>
                </span>
            </div>
        </div>
    </footer>
</body>

</html>