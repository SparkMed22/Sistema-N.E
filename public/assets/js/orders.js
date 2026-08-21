let recetas = [];
let stockD = [];

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
                    <p class="mt-1 text-xs font-semibold text-on-surface truncate" title="${receta.diagnostico_medico}">
                        ${receta.diagnostico_medico || 'Sin diagnostico'}
                    </p>
                </div>

                <!-- INDICACIÓN NUTRICIONAL -->
                <div class="mt-3 p-2.5 rounded-xl bg-surface-container-lowest border border-outline-variant/20">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-on-surface-variant">
                        Indicación Nutricional
                    </p>
                    <p class="mt-0.5 text-xs text-on-surface-variant line-clamp-2 leading-relaxed" title="${receta.indicacion_nutricional || ''}">
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
        id_receta: Number(idReceta),
        id_consulta: Number(idConsulta),
        productos: productos
    };

    // TODO: CONECTAR CON EL BACK
    console.log('Payload a enviar:', payload);

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
});