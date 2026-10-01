<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportar Informe a Excel</title>
    <!-- Tailwind CSS (para un diseño rápido y limpio) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- SheetJS (Librería para generar Excel en el cliente) -->
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-6 rounded-xl shadow-md w-full max-w-md text-center">
        <h1 class="text-xl font-bold text-gray-800 mb-2">Informe de Pedidos Cerrados</h1>
        <p class="text-sm text-gray-500 mb-6">Genera y descarga el reporte en formato Excel (.xlsx) a partir de los datos del servidor.</p>

        <!-- Botón para ejecutar la descarga -->
        <button id="btnExportar" onclick="obtenerYExportar()" 
            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2 shadow">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d=" "></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            Descargar Excel
        </button>
    </div>

    <script>
        /**
         * Función principal: obtiene los datos (API o Demo) y dispara la conversión a Excel
         */
        async function obtenerYExportar() {
            const btn = document.getElementById('btnExportar');
            btn.disabled = true;
            btn.classList.add('opacity-50', 'cursor-not-allowed');

            try {
                
                const response = await fetch('/api/informes/recetas', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        fecha_desde: '2026-09-01',
                        fecha_hasta: '2026-10-01'
                    })
                });
                const responseData = await response.json();
                const jsonDatos = responseData.data; // O responseData directo según la estructura de tu respuesta
                

                

                exportarJsonAExcel(jsonDatos);

            } catch (error) {
                console.error("Error al procesar la exportación:", error);
                alert("Ocurrió un error al generar el archivo Excel.");
            } finally {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        /**
         * Convierte la estructura de datos recibida en un libro de Excel y fuerza la descarga
         */
        function exportarJsonAExcel(apiResponse) {
            if (!apiResponse || !apiResponse.pedidos || apiResponse.pedidos.length === 0) {
                alert('No se encontraron registros de pedidos para exportar.');
                return;
            }

            // 1. Mapeo y reordenamiento con nombres de encabezados claros
            const pedidosFormateados = apiResponse.pedidos.map(item => ({
                'ID Paciente': item.paciente_id,
                'Paciente': item.paciente,
                'Cédula': item.cedula,
                'Bloque': item.bloque,
                'Sala': item.sala,
                'Cama': item.cama,
                'Servicio': item.servicio,
                'ID Receta': item.receta_id,
                'Indicación Nutricional': item.indicacion_nutricional || '-',
                'Medida Porción': item.medida_porcion || '-',
                'Aporte Líquido': item.aporte_liquido || '-',
                'Volumen Total': item.volumen_total || '-',
                'Estado Aprobación': item.estado_aprobacion,
                'Fecha Revisión': item.fecha_revision,
                'ID Pedido': item.pedido_id,
                'Estado Pedido': item.estado_pedido,
                'Fecha Pedido': item.fecha_pedido,
                'Fecha Cierre': item.fecha_cierre,
                'Gestionado Por': item.gestionado_por,
                'Cant. Componentes': item.total_componentes,
                'Componentes / Productos': item.componentes || '-'
            }));

            // 2. Crear la hoja de cálculo
            const worksheet = XLSX.utils.json_to_sheet(pedidosFormateados);

            // 3. Autoajuste de ancho de columnas dinámico
            const colWidths = Object.keys(pedidosFormateados[0]).map(key => {
                const maxLen = Math.max(
                    key.length,
                    ...pedidosFormateados.map(row => (row[key] ? row[key].toString().length : 0))
                );
                // Ancho mínimo 12, máximo 65 para no saturar horizontalmente
                return { wch: Math.min(Math.max(maxLen + 3, 12), 65) };
            });
            worksheet['!cols'] = colWidths;

            // 4. Crear el libro y adjuntar la hoja
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, "Pedidos Cerrados");

            // 5. Nombre de archivo dinámico usando las fechas del reporte
            const desde = apiResponse.rango_fechas?.desde || 'inicio';
            const hasta = apiResponse.rango_fechas?.hasta || 'fin';
            const nombreArchivo = `Informe_Pedidos_${desde}_al_${hasta}.xlsx`;

            // 6. Descarga directa del archivo .xlsx
            XLSX.writeFile(workbook, nombreArchivo);
        }
    </script>
</body>
</html>