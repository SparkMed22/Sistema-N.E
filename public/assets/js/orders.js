let recetas = [];
let stockD = [];

// ? INFORMES

async function obtenerYExportar(fecha_desde, fecha_hasta) {
    try {

        const response = await fetch('/api/informes/recetas', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                fecha_desde: fecha_desde,
                fecha_hasta: fecha_hasta
            })
        });
        const responseData = await response.json();
        const jsonDatos = responseData.data;


        exportarJsonAExcel(jsonDatos);

    } catch (error) {
        console.error("Error al procesar la exportación:", error);
        alert("Ocurrió un error al generar el archivo Excel.");
    }
}


async function exportarJsonAExcel(apiResponse) {
    if (!apiResponse || !apiResponse.pedidos || apiResponse.pedidos.length === 0) {
        alert('No se encontraron registros de pedidos para exportar.');
        return;
    }

    // 1. Crear nuevo libro de trabajo y hoja
    const workbook = new ExcelJS.Workbook();
    const sheet = workbook.addWorksheet('Informe de Pedidos');

    // Habilitar líneas de cuadrícula
    sheet.views = [{ showGridLines: true }];

    // 2. Encabezado principal del reporte (Banner)
    sheet.mergeCells('A1:U2');
    const titleCell = sheet.getCell('A1');
    titleCell.value = 'INFORME DE MOVIMIENTOS Y GESTIÓN NUTRICIONAL';
    titleCell.font = { name: 'Arial', size: 16, bold: true, color: { argb: 'FFFFFF' } };
    titleCell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '1A365D' } }; // Azul Institucional
    titleCell.alignment = { horizontal: 'center', vertical: 'middle' };

    // Subtítulo con rango de fechas
    const desde = apiResponse.rango_fechas?.desde || 'Inicio';
    const hasta = apiResponse.rango_fechas?.hasta || 'Fin';
    sheet.mergeCells('A3:U3');
    const subCell = sheet.getCell('A3');
    subCell.value = `Rango del reporte: ${desde} al ${hasta} | Total Registros: ${apiResponse.total_registros}`;
    subCell.font = { name: 'Arial', size: 10, italic: true, color: { argb: 'FFFFFF' } };
    subCell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '2B6CB0' } };
    subCell.alignment = { horizontal: 'center', vertical: 'middle' };

    // 3. Encabezados de la Tabla (Fila 5)
    const headers = [
        "ID Pedido", "Estado Pedido", "ID Paciente", "Paciente", "Cédula", 
        "Bloque", "Sala", "Cama", "Servicio", "ID Receta", 
        "Indicación Nutricional", "Medida Porción", "Aporte Líquido (ml)", "Volumen Total (ml)", 
        "Estado Aprobación", "Cant. Comp.", "Componentes / Productos Nutricionales", 
        "Gestionado Por", "Fecha Pedido", "Fecha Revisión", "Fecha Cierre"
    ];

    const headerRow = sheet.getRow(5);
    headerRow.values = headers;
    headerRow.height = 28;

    headerRow.eachCell((cell) => {
        cell.font = { name: 'Arial', size: 10, bold: true, color: { argb: 'FFFFFF' } };
        cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: '2B6CB0' } };
        cell.alignment = { horizontal: 'center', vertical: 'middle', wrapText: true };
        cell.border = {
            top: { style: 'thin', color: { argb: 'CBD5E0' } },
            bottom: { style: 'medium', color: { argb: '1A365D' } }
        };
    });

    // 4. Mapeo e Inserción de Datos
    apiResponse.pedidos.forEach((p, index) => {
        // Formatear componentes en lista limpia con viñetas
        let componentesFormateados = '-';
        if (p.componentes) {
            componentesFormateados = p.componentes
                .split('|')
                .map(c => `• ${c.trim()}`)
                .join('\n');
        }

        const row = sheet.addRow([
            p.pedido_id,
            p.estado_pedido,
            p.paciente_id,
            p.paciente,
            p.cedula,
            p.bloque,
            p.sala,
            p.cama,
            p.servicio,
            p.receta_id,
            p.indicacion_nutricional || '-',
            Number(p.medida_porcion) || 0,
            Number(p.aporte_liquido) || 0,
            Number(p.volumen_total) || 0,
            p.estado_aprobacion,
            Number(p.total_componentes) || 0,
            componentesFormateados,
            p.gestionado_por,
            p.fecha_pedido,
            p.fecha_revision,
            p.fecha_cierre
        ]);

        // Alternancia de colores en filas (Zebra Striping)
        const isZebra = index % 2 === 1;
        const rowBg = isZebra ? 'F7FAFC' : 'FFFFFF';

        row.height = Math.max(30, (componentesFormateados.split('\n').length * 16));

        row.eachCell((cell, colNumber) => {
            cell.font = { name: 'Arial', size: 9 };
            cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: rowBg } };
            cell.border = {
                top: { style: 'thin', color: { argb: 'E2E8F0' } },
                bottom: { style: 'thin', color: { argb: 'E2E8F0' } }
            };

            // Alineación e indicador según la columna
            if ([1, 2, 3, 5, 6, 7, 8, 10, 15, 16, 19, 20, 21].includes(colNumber)) {
                cell.alignment = { horizontal: 'center', vertical: 'middle' };
            } else if ([12, 13, 14].includes(colNumber)) {
                cell.alignment = { horizontal: 'right', vertical: 'middle' };
                cell.numFmt = '#,##0';
            } else if (colNumber === 17) {
                cell.alignment = { horizontal: 'left', vertical: 'middle', wrapText: true };
            } else {
                cell.alignment = { horizontal: 'left', vertical: 'middle' };
            }

            // Resaltar estado de aprobación (Verde suave)
            if (colNumber === 15 && cell.value === 'APROBADA') {
                cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'C6F6D5' } };
                cell.font = { name: 'Arial', size: 9, bold: true, color: { argb: '22543D' } };
            }
        });
    });

    // 5. Fila de Totales
    const totalRowIndex = sheet.rowCount + 1;
    const totalRow = sheet.getRow(totalRowIndex);
    totalRow.height = 24;

    sheet.mergeCells(`A${totalRowIndex}:K${totalRowIndex}`);
    sheet.getCell(`A${totalRowIndex}`).value = 'TOTALES / RESUMEN';

    sheet.getCell(`M${totalRowIndex}`).value = { formula: `SUM(M6:M${totalRowIndex - 1})` };
    sheet.getCell(`N${totalRowIndex}`).value = { formula: `SUM(N6:N${totalRowIndex - 1})` };
    sheet.getCell(`P${totalRowIndex}`).value = { formula: `SUM(P6:P${totalRowIndex - 1})` };

    totalRow.eachCell((cell, colNumber) => {
        cell.font = { name: 'Arial', size: 10, bold: true };
        cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'E2E8F0' } };
        cell.border = { top: { style: 'thin' }, bottom: { style: 'double' } };
        if ([13, 14, 16].includes(colNumber)) {
            cell.alignment = { horizontal: 'right', vertical: 'middle' };
            cell.numFmt = '#,##0';
        }
    });

    // 6. Anchos de columna automáticos
    sheet.columns.forEach((column) => {
        let maxLen = 12;
        column.eachCell({ includeEmpty: false }, (cell) => {
            if (cell.row >= 5) {
                const valStr = cell.value ? cell.value.toString() : '';
                const lines = valStr.split('\n');
                lines.forEach(line => {
                    if (line.length > maxLen) maxLen = line.length;
                });
            }
        });
        column.width = Math.min(Math.max(maxLen + 4, 12), 48);
    });

    // 7. Descargar el archivo generado
    const buffer = await workbook.xlsx.writeBuffer();
    const fileName = `Informe_Nutricional_${desde}_al_${hasta}.xlsx`;
    saveAs(new Blob([buffer]), fileName);
}

async function generarInforme(event) {
    event.preventDefault();

    const form = event.currentTarget;
    const formData = new FormData(form);

    const fechaDesde = formData.get('fechaDesde');
    const fechaHasta = formData.get('fechaHasta');

    if (fechaDesde > fechaHasta) {
        alert('La fecha desde no puede ser posterior a la fecha hasta.');
        return;
    }

    try {
        console.log('Generando informe:', { fechaDesde, fechaHasta });

        obtenerYExportar(fechaDesde, fechaHasta);

        alert(`Informe solicitado desde ${fechaDesde} hasta ${fechaHasta}`);
        form.reset();
    } catch (error) {
        console.error('Error al generar el informe:', error);
        alert('Ocurrió un error al generar el informe.');
    }
}

// =========================================================================0000


function crearTarjetaReceta(receta) {
    const fecha = receta.fecha_creacion
        ? new Date(receta.fecha_creacion.replace(' ', 'T'))
            .toLocaleDateString('es-PY', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            })
        : 'Sin fecha';

    return `
        <article class="group relative flex flex-col justify-between rounded-2xl border border-outline-variant/30 bg-surface p-5" data-id-receta="${receta.id_receta}">
            
            <div>
                <!-- HEADER: Paciente y Servicio -->
                <div class="flex items-start justify-between gap-3 pb-3 border-b border-outline-variant/20">
                    <div class="min-w-0">
                        <span class="inline-block px-2 py-0.5 rounded-md bg-secondary-container/60 text-on-secondary-container text-[10px] font-bold uppercase tracking-wider mb-1">
                            ${receta.servicio || 'General'}
                        </span>
                        <h2 class="truncate text-base font-bold text-on-surface" title="${receta.paciente_nombre}">
                            ${receta.paciente_nombre}
                        </h2>
                    </div>
                    
                    <div class="flex items-center gap-1 text-[11px] font-medium text-on-surface-variant/80 shrink-0 bg-surface-container-low px-2 py-1 rounded-lg">
                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                        ${fecha}
                    </div>
                </div>

                <!-- DIAGNÓSTICO -->
                <div class="mt-3.5">
                    <div class="flex items-center gap-1.5 text-on-surface-variant text-[10px] font-bold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[14px] text-primary">clinical_notes</span>
                        Diagnóstico
                    </div>
                    <p cclass="mt-0.5 text-xs text-on-surface-variant leading-relaxed whitespace-pre-wrap break-words" title="${receta.diagnostico_medico}">
                        ${receta.diagnostico_medico || 'Sin diagnostico'}
                    </p>
                </div>

                <!-- INDICACIÓN NUTRICIONAL -->
                <div class="mt-3 p-2.5 rounded-xl bg-surface-container-lowest border border-outline-variant/20">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">
                        Indicación Nutricional
                    </p>
                    <p class="mt-0.5 text-xs text-on-surface-variant leading-relaxed whitespace-pre-wrap break-words" title="${receta.indicacion_nutricional || ''}">
                        ${receta.indicacion_nutricional || 'Sin indicación registrada'}
                    </p>
                </div>

                <!-- METRICAS / APORTES -->
                <div class="mt-4 flex items-center justify-between gap-2 p-2 rounded-xl bg-surface-container-low">
                    <div class="flex-1 text-center border-r border-outline-variant/30 pr-1">
                        <p class="text-[9px] font-medium text-on-surface-variant">Porción</p>
                        <p class="text-xs font-bold text-on-surface truncate">${receta.medida_porcion || '-'}</p>
                    </div>
                    <div class="flex-1 text-center border-r border-outline-variant/30 px-1">
                        <p class="text-[9px] font-medium text-on-surface-variant">Líquido</p>
                        <p class="text-xs font-bold text-on-surface truncate">${receta.aporte_liquido || '-'}</p>
                    </div>
                    <div class="flex-1 text-center pl-1">
                        <p class="text-[9px] font-medium text-primary">Vol. Total</p>
                        <p class="text-xs font-black text-primary truncate">${receta.volumen_total || '-'}</p>
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-t border-outline-variant/20 grid grid-cols-2 gap-2">
                <button
                    type="button"
                    onclick="cancelarRecetaModal(${receta.id_receta})"
                    class="inline-flex h-10 items-center justify-center gap-1.5 rounded-xl border border-outline/30 bg-surface px-3 text-xs font-bold text-error transition-all duration-200 hover:bg-error-container/30 active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[16px]">close</span>
                    <span>Cancelar</span>
                </button>

                <!-- BOTÓN PROCESAR -->
                <button
                    type="button"
                    onclick="procesarReceta(${receta.id_receta})"
                    class="inline-flex h-10 items-center justify-center gap-1.5 rounded-xl bg-primary px-3 text-xs font-bold text-on-primary transition-all duration-200 hover:bg-primary/90 active:scale-[0.98]">
                    <span>Procesar</span>
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </button>
            </div>
        </article>
    `;
}

function renderizarListaRecetas(listaRecetas) {
    const contenedor = document.getElementById('contenedor-tarjetas-recetas');

    if (!contenedor) return;

    if (!listaRecetas || listaRecetas.length === 0) {
        contenedor.innerHTML = '<p class="text-center text-sm text-on-surface-variant py-8">No hay recetas pendientes.</p>';
        return;
    }
    contenedor.innerHTML = listaRecetas.map(receta => crearTarjetaReceta(receta)).join('');
}


async function loadRecetas() {
    try {
        recetas = await getFetch('/api/recetas', 'Error al obtener las recetas..');
        renderizarListaRecetas(recetas);
    } catch (error) {
        console.error(error);
    }
}

// ? Cargar El stock Disponible
async function loadStock() {
    try {
        const prodcutosFormulasEnterales = await getFetch('/api/stock/productos', 'Error al obtener los prductos.') ?? [];
        stockD = prodcutosFormulasEnterales.filter(p => p.cantidad > 0);
    } catch (error) {
        console.error('loadProductos:', error);
        showError('Error del servidor', error ?? 'No se pudieron cargar los productos.');
    }
}


// ? Bucar Libro
function buscarReceta(event) {
    const texto = event.target.value.trim().toLowerCase();
    if (!texto) {
        renderizarListaRecetas(recetas);
        return;
    }
    const resultados = recetas.filter((receta) => {
        return receta.paciente_nombre
            .toLowerCase()
            .includes(texto);
    });
    renderizarListaRecetas(resultados);
}

//? FILTRAR RECETAS 
function recetasFilterChange(status) {
    let list = [];
    switch (status) {
        case '0':
            renderizarListaRecetas(recetas);
            break;
        default:
            list = recetas.filter(p => p.servicio_id == status);
            renderizarListaRecetas(list);
    }
}


// ? Rechazar Pedido/Receta
function cancelarRecetaModal(id_receta) {
    const receta = recetas.find(receta => receta.id_receta == id_receta)
    if (!receta) {
        console.error('No se encontró la receta:', id_receta);
        return;
    }
    document.getElementById('cancelar-receta-id').value = receta.id_receta;
    document.getElementById('cancelar-paciente').textContent = receta.paciente_nombre;
    document.getElementById('cancelar-usuario').textContent = receta.usuario_nombre;
    document.getElementById('cancelar-servicio').textContent = receta.servicio;
    document.getElementById('cancelar-diagnostico').textContent = receta.diagnostico_medico;
    document.getElementById('cancelar-indicacion').textContent = receta.indicacion_nutricional;
    openModal('popover-cancelar-receta');
}

async function cancelarReceta(event) {

    event.preventDefault();
    const form = event.target;

    const payload = {
        'receta_id': parseInt(document.getElementById('cancelar-receta-id').value),
        'usuario_id': parseInt(getLocalStorangeData('usuario').id),
        'motivo_rechazo': document.getElementById('cancelar-motivo-select').value
    }

    try {
        const data = await postFetch('/api/recetas/cancelar', payload, 'No se pudo cancelar la receta');
        closeModal('popover-cancelar-receta');
        showSuccess('Exito', data.message ?? 'Receta cancelada con Exito.');
        loadRecetas();
    } catch (error) {
        closeModal('popover-cancelar-receta');
        showError('Error', error.message ?? 'Ocurrió un error inesperado.');
    } finally {
        form.reset();
    }
}

//? Procesar una Receta/Peddio
function procesarReceta(id_receta) {
    const receta = recetas.find(receta => receta.id_receta == id_receta);
    if (!receta) {
        console.error('No se encontró la receta:', id_receta);
        return;
    }

    document.getElementById('procesar-receta-id').value = receta.id_receta;
    document.getElementById('procesar-consulta-id').value = receta.id_consulta;
    document.getElementById('procesar-usuario-nombre').textContent = receta.usuario_nombre || '-';
    document.getElementById('procesar-bloque').textContent = receta.bloque || '-';
    document.getElementById('procesar-sala').textContent = receta.sala || '-';
    document.getElementById('procesar-cama').textContent = receta.cama || '-';
    document.getElementById('procesar-diagnostico').textContent = receta.diagnostico_medico || '-';

    const contenedor = document.getElementById('contenedor-productos');
    contenedor.innerHTML = '';
    agregarFilaProducto(stockD);
    document.getElementById('popover-procesar-receta').showPopover();
}

function agregarFilaProducto(stock = stockD) {
    const contenedor = document.getElementById('contenedor-productos');

    const filaDiv = document.createElement('div');
    filaDiv.className = 'flex items-center gap-3 animate-fade-in';

    const opcionesStock = stock.map(item => `
        <option value="${item.id}" data-stock="${item.cantidad}">
            ${item.nombre} (Stock: ${item.cantidad})
        </option>
    `).join('');

    filaDiv.innerHTML = `
        <div class="flex-1">
            <select 
                name="id_producto[]" 
                required 
                class="select-producto w-full rounded-xl border border-outline-variant/60 bg-surface-container-lowest px-4 py-2.5 text-sm text-on-surface outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
            >
                <option value="" disabled selected>Seleccione un producto...</option>
                ${opcionesStock}
            </select>
        </div>
        <div class="w-32">
            <input 
                type="number" 
                name="cantidad[]" 
                placeholder="Cantidad" 
                min="1" 
                required
                class="input-cantidad w-full rounded-xl border border-outline-variant/60 bg-surface-container-lowest px-4 py-2.5 text-sm text-on-surface outline-none focus:border-primary focus:ring-2 focus:ring-primary/20"
            >
        </div>
        <button
            type="button"
            class="btn-eliminar-fila flex h-10 w-10 items-center justify-center rounded-xl text-error transition hover:bg-error-container/40"
            title="Eliminar fila">
            <span class="material-symbols-outlined text-[20px]">delete</span>
        </button>
    `;

    const selectProducto = filaDiv.querySelector('.select-producto');
    const inputCantidad = filaDiv.querySelector('.input-cantidad');

    selectProducto.addEventListener('change', function () {
        const optionSeleccionada = this.options[this.selectedIndex];
        const stockDisponible = optionSeleccionada.getAttribute('data-stock');

        if (stockDisponible) {
            inputCantidad.max = stockDisponible;
            inputCantidad.placeholder = `Máx: ${stockDisponible}`;

            if (Number(inputCantidad.value) > Number(stockDisponible)) {
                inputCantidad.value = stockDisponible;
            }
        }
    });

    filaDiv.querySelector('.btn-eliminar-fila').addEventListener('click', function () {
        if (contenedor.children.length > 1) {
            filaDiv.remove();
        } else {
            alert('Debe incluir al menos un producto en el pedido.');
        }
    });

    contenedor.appendChild(filaDiv);
}

document.getElementById('btn-agregar-producto').addEventListener('click', () => {
    agregarFilaProducto(stockD);
});

document.getElementById('form-procesar-receta').addEventListener('submit', async function (event) {
    event.preventDefault();

    const submitButton = this.querySelector('button[type="submit"]');
    const idReceta = document.getElementById('procesar-receta-id').value;
    const idConsulta = document.getElementById('procesar-consulta-id').value;

    const selectsProducto = document.querySelectorAll('select[name="id_producto[]"]');
    const inputsCantidad = document.querySelectorAll('input[name="cantidad[]"]');

    const productos = [];

    selectsProducto.forEach((select, index) => {
        const id_producto = Number(select.value);
        const cantidad = Number(inputsCantidad[index].value);

        if (id_producto && cantidad > 0) {
            productos.push({
                id_producto: id_producto,
                cantidad: cantidad
            });
        }
    });

    if (productos.length === 0) {
        alert('Por favor, agregue al menos un producto válido.');
        return;
    }

    const payload = {
        receta_id: Number(idReceta),
        gestionado_usuario_id: Number(getLocalStorangeData('usuario').id),
        productos: productos
    };

    try {
        if (submitButton) submitButton.disabled = true;

        const data = await postFetch('/api/orden/gestionar', payload, 'No se pudo crear la orden');

        closeModal('popover-procesar-receta');
        showSuccess('Éxito', data.message ?? 'Receta procesada con éxito.');

        loadRecetas();
        loadStock();
        this.reset();
    } catch (error) {
        console.error('Error al procesar la orden:', error);
        showError('Error al procesar la orden:', error)
    } finally {
        if (submitButton) submitButton.disabled = false;
    }
});



document.addEventListener('DOMContentLoaded', () => {
    loadRecetas();
    loadStock();
    servicios = getLocalStorangeData('servicios');
    loadOptions(servicios, 'opciones-servicio');
    const inputBuscar = document.getElementById('bucar-receta');
    inputBuscar.addEventListener('input', buscarReceta);

    const formCancelarRecetaModal = document.getElementById('form-cancelar-receta');
    formCancelarRecetaModal.addEventListener('submit', cancelarReceta);

    const formInformeModal = document.getElementById('form-informe-pacientes');
    formInformeModal.addEventListener('submit', generarInforme);
});