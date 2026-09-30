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
    <main class="p-6 max-w-7xl mx-auto space-y-6">

    <!-- Encabezado y Filtros -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-surface p-6 rounded-2xl shadow-sm border border-outline-variant">
        <div>
            <h1 class="text-2xl font-bold text-on-surface">Informe de Stock</h1>
            <p class="text-sm text-on-surface-variant">Consulta de existencias y movimientos por rango de fechas</p>
        </div>

        <!-- Formulario de Rango de Fechas -->
        <form id="form-filtro-stock" class="flex flex-wrap items-end gap-3">
            <div>
                <label for="fecha_desde" class="block text-xs font-semibold text-on-surface-variant mb-1">Desde</label>
                <input type="date" id="fecha_desde" required class="px-3 py-2 bg-surface-container-low text-on-surface border border-outline rounded-lg text-sm focus:ring-2 focus:ring-primary focus:outline-none">
            </div>
            <div>
                <label for="fecha_hasta" class="block text-xs font-semibold text-on-surface-variant mb-1">Hasta</label>
                <input type="date" id="fecha_hasta" required class="px-3 py-2 bg-surface-container-low text-on-surface border border-outline rounded-lg text-sm focus:ring-2 focus:ring-primary focus:outline-none">
            </div>
            <button type="submit" id="btn-generar" class="px-4 py-2 bg-primary text-on-primary font-semibold text-sm rounded-lg hover:opacity-90 transition-opacity flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">search</span>
                Generar Informe
            </button>
        </form>
    </div>

    <!-- Tarjetas de Resumen (KPIs) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-surface p-4 rounded-xl border border-outline-variant shadow-sm flex items-center gap-4">
            <div class="p-3 bg-primary-container text-on-primary-container rounded-lg">
                <span class="material-symbols-outlined">inventory_2</span>
            </div>
            <div>
                <p class="text-xs font-medium text-on-surface-variant">Total Productos</p>
                <p id="kpi-total-productos" class="text-2xl font-bold text-on-surface">0</p>
            </div>
        </div>

        <div class="bg-surface p-4 rounded-xl border border-outline-variant shadow-sm flex items-center gap-4">
            <div class="p-3 bg-secondary-container text-on-secondary-container rounded-lg">
                <span class="material-symbols-outlined">add_box</span>
            </div>
            <div>
                <p class="text-xs font-medium text-on-surface-variant">Total Entradas</p>
                <p id="kpi-total-entradas" class="text-2xl font-bold text-on-surface">0</p>
            </div>
        </div>

        <div class="bg-surface p-4 rounded-xl border border-outline-variant shadow-sm flex items-center gap-4">
            <div class="p-3 bg-error-container text-on-error-container rounded-lg">
                <span class="material-symbols-outlined">indeterminate_check_box</span>
            </div>
            <div>
                <p class="text-xs font-medium text-on-surface-variant">Total Salidas</p>
                <p id="kpi-total-salidas" class="text-2xl font-bold text-on-surface">0</p>
            </div>
        </div>

        <div class="bg-surface p-4 rounded-xl border border-outline-variant shadow-sm flex items-center gap-4">
            <div class="p-3 bg-tertiary-container text-on-tertiary-container rounded-lg">
                <span class="material-symbols-outlined">sync_alt</span>
            </div>
            <div>
                <p class="text-xs font-medium text-on-surface-variant">Movimientos Totales</p>
                <p id="kpi-total-movimientos" class="text-2xl font-bold text-on-surface">0</p>
            </div>
        </div>
    </div>

    <!-- Buscador en Tabla -->
    <div class="bg-surface p-4 rounded-2xl border border-outline-variant shadow-sm space-y-4">
        <div class="flex items-center justify-between gap-4">
            <div class="relative w-full max-w-xs">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-sm">search</span>
                <input type="text" id="input-buscar" placeholder="Buscar producto..." class="w-full pl-9 pr-3 py-2 bg-surface-container-low text-on-surface border border-outline rounded-lg text-sm focus:ring-2 focus:ring-primary focus:outline-none">
            </div>
        </div>

        <!-- Tabla de Datos -->
        <div class="overflow-x-auto rounded-xl border border-outline-variant">
            <table class="w-full text-left border-collapse text-sm">
                <thead>
                    <tr class="bg-surface-container-high text-on-surface-variant text-xs uppercase font-bold border-b border-outline-variant">
                        <th class="p-4">ID</th>
                        <th class="p-4">Producto</th>
                        <th class="p-4 text-center">Stock Actual</th>
                        <th class="p-4 text-center">Entradas</th>
                        <th class="p-4 text-center">Salidas</th>
                        <th class="p-4 text-center">Mov. Neto</th>
                        <th class="p-4 text-center">Cant. Movimientos</th>
                    </tr>
                </thead>
                <tbody id="tabla-stock-body" class="divide-y divide-outline-variant bg-surface text-on-surface">
                    <tr>
                        <td colspan="7" class="p-6 text-center text-on-surface-variant">Selecciona un rango de fechas y presiona "Generar Informe"</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</main>
</body>

<script>
let productosCache = [];

document.getElementById('form-filtro-stock').addEventListener('submit', async function(e) {
    e.preventDefault();

    const desde = document.getElementById('fecha_desde').value;
    const hasta = document.getElementById('fecha_hasta').value;

    if (!desde || !hasta) {
        return;
    }

    try {
        const response = await fetch('/api/informes/stock', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                fecha_desde: desde,
                fecha_hasta: hasta
            })
        });

        const result = await response.json();
        

        if (result.success && Array.isArray(result.data)) {
            productosCache = result.data;
            console.log(result);
            renderizarTabla(productosCache);
            actualizarKPIs(productosCache);
        } else {
            alert('Error', result.message || 'No se pudo obtener la información.', 'error');
        }

    } catch (error) {
        console.error('Error al consultar la API:', error);
        alert('Error', 'Ocurrió un error al conectar con el servidor.', 'error');
    }
});

// Función para Renderizar la Tabla
function renderizarTabla(lista) {
    const tbody = document.getElementById('tabla-stock-body');

    if (lista.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="7" class="p-6 text-center text-on-surface-variant">No se encontraron resultados</td>
            </tr>`;
        return;
    }

    tbody.innerHTML = lista.map(item => {
        const stockClase = item.stock_actual > 0 
            ? 'bg-emerald-100 text-emerald-800 border-emerald-300 dark:bg-emerald-950 dark:text-emerald-300' 
            : 'bg-rose-100 text-rose-800 border-rose-300 dark:bg-rose-950 dark:text-rose-300';

        return `
            <tr class="hover:bg-surface-container-low transition-colors">
                <td class="p-4 font-semibold text-on-surface-variant">#${item.producto_id}</td>
                <td class="p-4 font-semibold text-on-surface">${item.producto}</td>
                <td class="p-4 text-center">
                    <span class="px-2.5 py-1 text-xs font-bold rounded-full border ${stockClase}">
                        ${item.stock_actual}
                    </span>
                </td>
                <td class="p-4 text-center font-medium text-emerald-600 dark:text-emerald-400">+${item.total_entradas}</td>
                <td class="p-4 text-center font-medium text-rose-600 dark:text-rose-400">-${item.total_salidas}</td>
                <td class="p-4 text-center font-medium text-on-surface">${item.movimiento_neto}</td>
                <td class="p-4 text-center text-on-surface-variant">${item.cantidad_movimientos}</td>
            </tr>
        `;
    }).join('');
}

// Función para actualizar métricas (KPIs)
function actualizarKPIs(lista) {
    document.getElementById('kpi-total-productos').textContent = lista.length;

    const totalEntradas = lista.reduce((sum, item) => sum + Number(item.total_entradas || 0), 0);
    const totalSalidas = lista.reduce((sum, item) => sum + Number(item.total_salidas || 0), 0);
    const totalMovimientos = lista.reduce((sum, item) => sum + Number(item.cantidad_movimientos || 0), 0);

    document.getElementById('kpi-total-entradas').textContent = totalEntradas;
    document.getElementById('kpi-total-salidas').textContent = totalSalidas;
    document.getElementById('kpi-total-movimientos').textContent = totalMovimientos;
}

// Buscador en tiempo real
document.getElementById('input-buscar').addEventListener('input', function(e) {
    const query = e.target.value.toLowerCase().trim();
    const filtrados = productosCache.filter(p => 
        p.producto.toLowerCase().includes(query) || 
        p.producto_id.toString().includes(query)
    );
    renderizarTabla(filtrados);
});
</script>
</html>