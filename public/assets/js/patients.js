let consultas = [];
let usuariosActivos = [];

// ? Redereizar Targetas de consultas
function renderizarTarjetas(consultas) {
    const contenedor = document.getElementById('pacientes_grid');

    contenedor.innerHTML = '';
    if (!consultas || consultas.length === 0) {
        contenedor.innerHTML = '<p class="text-center text-gray-500">No hay consultas registradas.</p>';
        return;
    }
    consultas.forEach((consulta) => {
        const tarjetaHTML = `
        <div class="max-w-md rounded-2xl border border-outline-variant bg-surface-container-lowest p-5">

    <div class="mb-4 flex items-start justify-between">

        <div>
            <span class="text-xs font-medium uppercase tracking-wide text-on-surface-variant">
                Consulta #${consulta.consulta_id}
            </span>

            <h2 class="mt-1 text-lg font-semibold text-on-surface">
                ${consulta.paciente_nombre} ${consulta.paciente_apellido}
            </h2>

            <p class="text-sm text-on-surface-variant">
                C.I.: ${consulta.paciente_cedula}
            </p>
        </div>

        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
            Activa
        </span>

    </div>


    <div class="space-y-3 border-t border-outline-variant pt-4">

        <!-- Servicio -->
        <div class="flex items-center gap-3">

            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-fixed">
                🏥
            </div>

            <div>
                <p class="text-xs text-on-surface-variant">
                    Servicio
                </p>

                <p class="text-sm font-medium text-on-surface">
                    ${consulta.servicio_nombre}
                </p>
            </div>

        </div>


        <!-- Ubicación -->
        <div class="flex items-center gap-3">

            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-secondary-fixed">
                🛏️
            </div>

            <div>
                <p class="text-xs text-on-surface-variant">
                    Ubicación
                </p>

                <p class="text-sm font-medium text-on-surface">
                    ${consulta.bloque} · Sala ${consulta.sala} · Cama ${consulta.cama}
                </p>
            </div>

        </div>

        <!-- Fecha -->
        <div class="flex items-center gap-3">

            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-surface-container">
                📅
            </div>

            <div>
                <p class="text-xs text-on-surface-variant">
                    Fecha de ingreso
                </p>

                <p class="text-sm font-medium text-on-surface">
                    ${consulta.fecha_ingreso}
                </p>
            </div>

        </div>

    </div>

    <!-- Observaciones -->
    <div class="mt-4 rounded-lg bg-surface-container-low p-3">

        <p class="text-xs font-medium text-on-surface-variant">
            Observaciones
        </p>

        <p class="mt-1 text-sm text-on-surface">
            ${consulta.observaciones_ingreso || 'Sin observaciones'}
        </p>

    </div>


    <!-- Acciones -->
    <div class="mt-5 grid grid-cols-2 gap-2">

        <button
            onclick="editarConsultaModal(${consulta.consulta_id})"
            type="button"
            class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-on-primary transition hover:bg-primary-container">
            Ver consulta 
        </button>

        <button
            type="button"
            onclick="modalReceta(${consulta.consulta_id})"
            class="rounded-lg bg-secondary px-4 py-2 text-sm font-medium text-on-secondary transition hover:bg-tertiary">
            Nueva Receta
        </button>

        <button
            onclick="historialRecetas(${consulta.paciente_id},${consulta.consulta_id})"
            type="button"
            class="rounded-lg border border-outline bg-surface px-4 py-2 text-sm font-medium text-primary transition hover:bg-surface-container-high">
            Historial
        </button>

        <button
            onclick="altaMedica(${consulta.consulta_id})"
            type="button"
            class="rounded-lg bg-surface-container-highest px-4 py-2 text-sm font-medium text-primary transition hover:bg-outline-variant">
            Alta
        </button>

        <button
            onclick="editarPacienteModal(${consulta.paciente_id})"
            type="button"
            class="rounded-lg bg-tertiary-container px-4 py-2 text-sm font-medium text-on-tertiary-container transition hover:bg-tertiary">
            Editar Paciente
        </button>
        <button
            onclick="reasignar(${consulta.consulta_id})"
            type="button"
            class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2 text-sm font-medium text-on-surface-variant transition hover:bg-surface-container">
            Reasignar
        </button>
    </div>
</div>
        `;

        contenedor.insertAdjacentHTML('beforeend', tarjetaHTML);
    });
}

// ? Cargar consultas
async function loadConsultas() {
    try {
        const usuario = getLocalStorangeData('usuario');
        const url = `/api/${usuario.rol}/consultation/${usuario.id_servicio}/activas`;
        const response = await getFetch(url, 'No se pudieron obtener las consultas.');
        consultas = response;
        renderizarTarjetas(consultas);
    } catch (error) {
        console.error('Error en loadConsultas:', error.message);
        if (error.message.includes('Sesión expirada')) {
            window.location.href = '/login';
        }
        throw error;
    }
}

// ? Ingresar Pacientes
async function ingresarPacientes(event) {
    event.preventDefault();
    const cedula = document.getElementById('ingreso-cedula').value.trim();
    const sala = document.getElementById('ingreso-sala').value.trim();
    const bloque = document.getElementById('ingreso-bloque').value.trim();
    const servicio = document.getElementById('ingreso-servicio').value;
    const observaciones = document.getElementById('ingreso-observaciones-egreso').value.trim() || "Sin datos de entrada";
    const ingreso_diagnostico = document.getElementById('ingreso-diagnostico').value.trim();
    const cama = document.getElementById('ingreso-cama').value.trim();

    const usuario = JSON.parse(localStorage.getItem('usuario'));

    const dataPaciente = {
        cedula: cedula,
        servicio_id: parseInt(servicio, 10),
        usuario_ingreso_id: usuario.id,
        usuario_egreso_id: null,
        diagnostico_medico: ingreso_diagnostico,
        observaciones_ingreso: observaciones,
        bloque: bloque,
        sala: sala,
        cama: cama
    };

    try {
        const data = await postFetch('/api/consultation', dataPaciente, 'No se pudo crear la consulta.');
        const dataRespon = data.data;
        closeModal('popover-ingresar-paciente');
        let finalMessage = dataRespon?.message || 'Consulta registrada correctamente.';
        if (dataRespon?.paciente_temporal) {
            finalMessage += ' El paciente fue creado con datos temporales; se recomienda actualizar su información.';
        }
        showSuccess('Consulta creada con éxito', finalMessage);
        loadConsultas();
    } catch (error) {
        closeModal('popover-ingresar-paciente');
        const safeErrorMsg = document.createTextNode(error.message || 'Ocurrió un error inesperado.').textContent;
        showError("Error", safeErrorMsg);
        console.error('Error al crear consulta:', error);
    }
}

function buscarConsulta(event) {

    const texto = event.target.value.trim().toLowerCase();

    if (!texto) {
        renderizarTarjetas(consultas);
        return;
    }

    const resultados = consultas.filter((consulta) => {

        const nombreCompleto = [
            consulta.paciente_nombre,
            consulta.paciente_apellido
        ]
            .filter(Boolean)
            .join(' ')
            .toLowerCase();

        const cedula = String(consulta.paciente_cedula ?? '').toLowerCase();

        return (nombreCompleto.includes(texto) || cedula.includes(texto));
    });

    renderizarTarjetas(resultados);
}


function reasignar(id_paciente) {
    try {
        const inputIdConsulta = document.getElementById('id-consulta-reasignar');
        if (!inputIdConsulta) return;
        inputIdConsulta.value = id_paciente;
        openModal('popover-reasignar');
    } catch (error) {
        if (error.message.includes('Sesión expirada')) {
            window.location.href = '/login';
        }
        throw error;
    }
}

async function reasignarPaciente(event) {
    event.preventDefault();

    try {
        const inputIdConsulta = document.getElementById('id-consulta-reasignar');
        const selectServicio = document.getElementById('servicio-select');

        if (!inputIdConsulta || !selectServicio) throw new Error('No se encontraron los elementos del formulario.');


        const idConsulta = inputIdConsulta.value;
        const idServicio = selectServicio.value;

        if (!idConsulta) throw new Error('No se pudo identificar la consulta.');

        if (!idServicio) throw new Error('Por favor, selecciona un nuevo servicio.');


        const payload = {
            id_consulta: Number(idConsulta),
            id_servicio: Number(idServicio)
        };

        const data = await postFetch('/api/consultation/reasignar', payload, 'No se pudo reasignar el servicio.');
        closeModal('popover-reasignar');
        showSuccess('Éxito', data.message ?? 'Servicio reasignado correctamente.');
        await loadConsultas();
    } catch (error) {
        closeModal('popover-reasignar');
        showError('Error', error.message ?? 'Ocurrió un error inesperado.');
    }
}


async function altaMedica(id_consulta) {
    try {
        const usuario = getLocalStorangeData('usuario');
        const payload = {
            id_consulta: Number(id_consulta),
            id_usuario: Number(usuario.id)
        };
        const data = await postFetch('/api/consultation/alta', payload, 'No se pudo dar de alta al paciente.');
        showSuccess('Éxito', data.message || 'Alta ejecutacon con exito.');
        loadConsultas();
    } catch (error) {
        showError("Error", error);
    }
}


function editarPacienteModal(id_paciente) {
    const paciente = consultas.find(consulta => consulta.paciente_id == id_paciente);
    document.getElementById('edit-paciente-id').value = id_paciente;
    document.getElementById('edit-paciente-nombre').value = paciente.paciente_nombre;
    document.getElementById('edit-paciente-apellido').value = paciente.paciente_apellido;
    document.getElementById('edit-paciente-sexo').value = paciente.paciente_sexo;
    document.getElementById('edit-paciente-fecha').value = paciente.paciente_fecha_nacimiento || '';
    document.getElementById('edit-paciente-telefono').value = paciente.paciente_telefono;
    openModal('popover-editar-paciente');
}

async function editarPaciente(event) {
    event.preventDefault();
    const payload = {
        'editar_id': document.getElementById('edit-paciente-id').value,
        'editar_nombre': document.getElementById('edit-paciente-nombre').value,
        'editar_apellido': document.getElementById('edit-paciente-apellido').value,
        'editar_sexo': document.getElementById('edit-paciente-sexo').value,
        'editar_fecha_nacimiento': document.getElementById('edit-paciente-fecha').value,
        'editar_telefono': document.getElementById('edit-paciente-telefono').value
    }


    try {
        const data = await postFetch('/api/paciente/editar', payload, 'Error al actualizar la infomrmacion');
        closeModal('popover-editar-paciente');
        showSuccess('Éxito', data.message || 'Edicion ejecutacon con exito.');
        loadConsultas();
    } catch (error) {
        closeModal('popover-editar-paciente');
        showError('Error', error.message ?? 'Ocurrió un error inesperado.');
    }
}


function editarConsultaModal(consulta_id) {
    const paciente = consultas.find(consulta => consulta.consulta_id == consulta_id);
    document.getElementById('edit-bloque').value = paciente.bloque;
    document.getElementById('edit-sala').value = paciente.sala;
    document.getElementById('edit-cama').value = paciente.cama;
    document.getElementById('edit-paciente-consulta').value = paciente.consulta_id;
    document.getElementById('edit-diagnostico').value = paciente.diagnostico_medico;
    openModal('popover-ubicacion-dx');
}

async function editarConsulta(event) {
    event.preventDefault();
    const payload = {
        'editar_bloque': document.getElementById('edit-bloque').value,
        'editar_sala': document.getElementById('edit-sala').value,
        'editar_cama': document.getElementById('edit-cama').value,
        'edit_consulta': document.getElementById('edit-paciente-consulta').value
    }


    try {
        const data = await postFetch('/api/consultation/editar', payload, 'Error al actualizar la infomrmacion');
        closeModal('popover-ubicacion-dx');
        showSuccess('Éxito', data.message || 'Edicion ejecutacon con exito.');
        loadConsultas();
    } catch (error) {
        closeModal('popover-ubicacion-dx');
        showError('Error', error.message ?? 'Ocurrió un error inesperado.');
    }
}

function modalReceta(id_consulta) {
    document.getElementById('consulta-id').value = id_consulta;
    openModal('popover-receta');
}

async function generarReceta(event) {
    event.preventDefault();
    const form = event.target;
    const usuario = getLocalStorangeData('usuario');
    const payload = {
        'consulta_id': document.getElementById('consulta-id').value,
        'usuarios_id': usuario.id,
        'indicacion_nutricional': document.getElementById('indicacion-nutricional').value,
        'medida_porcion': document.getElementById('medida-porcion').value,
        'aporte_liquido': document.getElementById('aporte-liquido').value,
        'volumen_total': document.getElementById('volumen-total').value,
    }
    try {
        const data = await postFetch('/api/recetas', payload, 'No se pudo crear una nueva receta');
        closeModal('popover-receta');
        showSuccess('Exito', data.message ?? 'Receta Creada con Exito.');
    } catch (error) {
        closeModal('popover-receta');
        showError('Error', error.message ?? 'Ocurrió un error inesperado.');
    } finally {
        form.reset();
    }
}


//? Mostrar Recetas
function cargarRecetasModal(recetas) {

    const contenedor = document.getElementById('contenedor-recetas');
    const btnEnviar = document.getElementById('btn-enviar-receta');
    const textoSeleccion = document.getElementById('receta-seleccionada-texto');

    recetaSeleccionada = null;
    btnEnviar.disabled = true;
    textoSeleccion.textContent = 'Ninguna receta seleccionada';


    if (!recetas || recetas.length === 0) {
        contenedor.innerHTML = `
            <div class=" flex flex-col items-center justify-center py-12 text-center">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-surface-container text-on-surface-variant">
                    <span class="material-symbols-outlined text-3xl">
                        description
                    </span>
                </div>
                <h3 class="font-semibold text-on-surface">No hay recetas</h3>
                <pclass="mt-1 text-sm text-on-surface-variant">Este paciente no tiene recetas registradas.</p>
            </div>
        `;
        return;
    }


    const paciente = recetas[0].paciente_nombre_completo;

    document.getElementById('modal-recetas-paciente').textContent = paciente;
    contenedor.innerHTML = recetas.map((receta, index) => {

        return `
            <button type="button" data-index="${index}"
                class="receta-item group w-full rounded-2xl border border-outline-variant bg-surface-container-lowest p-5 text-left transition-all hover:border-primary hover:bg-surface-container-low">
                <div class=" flex items-start justify-between gap-4">

                    <div class="flex items-start gap-3">
                        <div
                            class=" flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-primary-fixed text-primary">
                            <span class="material-symbols-outlined">
                                description
                            </span>
                        </div>
                        <div>
                            <p class=" text-xs font-semibold uppercase tracking-wide text-primary">Receta ${recetas.length - index}</p>
                            <p class="mt-1 font-semibold text-on-surface">
                                ${receta.indicacion_nutricional || 'Sin indicación'}
                            </p>
                        </div>
                    </div>

                    <span class=" material-symbols-outlined receta-check text-outline-variant transition-colors">
                        radio_button_unchecked
                    </span>

                </div>

                <div class="mt-4 grid grid-cols-1 gap-3 border-t border-outline-variant pt-4 sm:grid-cols-3">
                    <div>
                        <p class="text-xs text-on-surface-variant">Medida/porción</p>
                        <p class="mt-1 text-sm font-medium text-on-surface">${receta.medida_porcion || '-'}</p>
                    </div>

                    <div>
                        <p class="text-xs text-on-surface-variant">Aporte líquido</p>
                        <p class="mt-1 text-sm font-medium text-on-surface">${receta.aporte_liquido || '-'}</p>
                    </div>

                    <div>
                        <p class="text-xs text-on-surface-variant">Volumen total</p>
                        <p class="mt-1 text-sm font-medium text-on-surface">${receta.volumen_total || '-'}</p>
                    </div>
                </div>

                <div class="mt-4 flex flex-col gap-1 text-xs text-on-surface-variant sm:flex-row sm:items-center sm:justify-between">
                    <span>
                        Profesional:<strong class="font-medium text-on-surface">${receta.profesional_nombre}</strong>
                    </span>
                    <span>    ${receta.profesional_servicio}</span>

                </div>
                <p class="mt-2 text-xs text-on-surface-variant">${formatearFecha(receta.fecha_creacion)}</p>
            </button>
        `;

    }).join('');

    document.querySelectorAll('.receta-item')
        .forEach(item => {
            item.addEventListener('click', () => {
                const index = Number(item.dataset.index);
                seleccionarReceta(recetas[index], item);
            });
        });

}

function seleccionarReceta(receta, elemento) {

    recetaSeleccionada = receta;
    document.querySelectorAll('.receta-item')
        .forEach(item => {
            item.classList.remove('border-primary', 'bg-primary-fixed');
            const icono = item.querySelector('.receta-check');

            if (icono) {
                icono.textContent = 'radio_button_unchecked';
                icono.classList.remove('text-primary');
                icono.classList.add('text-outline-variant');
            }
        });


    elemento.classList.add('border-primary', 'bg-primary-fixed');

    const icono = elemento.querySelector('.receta-check');
    if (icono) {
        icono.textContent = 'check_circle';
        icono.classList.remove('text-outline-variant');
        icono.classList.add('text-primary');
    }
    document.getElementById('btn-enviar-receta').disabled = false;
    document.getElementById('receta-seleccionada-texto').textContent = 'Receta seleccionada correctamente';
}

function formatearFecha(fecha) {

    if (!fecha) return '-';

    return new Intl.DateTimeFormat('es-PY',
        {
            dateStyle: 'medium',
            timeStyle: 'short'
        }
    ).format(new Date(fecha.replace(' ', 'T')));
}

async function enviarRecetaSeleccionada() {
    if (!recetaSeleccionada) {
        alert('Debe seleccionar una receta.');
        return;
    }

    try {
        const btn = document.getElementById('btn-enviar-receta');
        btn.disabled = true;
        btn.innerHTML = `<span class="material-symbols-outlined animate-spin">progress_activity</span>Enviando...`;

        const payload = {
            'consulta_id': document.getElementById('consulta_recetas_modal').value,
            'usuarios_id': getLocalStorangeData('usuario').id,
            'indicacion_nutricional': recetaSeleccionada.indicacion_nutricional,
            'medida_porcion': recetaSeleccionada.medida_porcion,
            'aporte_liquido': recetaSeleccionada.aporte_liquido,
            'volumen_total': recetaSeleccionada.volumen_total
        }

        const data = await postFetch('/api/recetas', payload, 'No se pudo crear una nueva receta');
        closeModal('modal-recetas');
        showSuccess('Exito', data.message ?? 'Receta Creada con Exito.');
    } catch (error) {
        closeModal('modal-recetas');
        showError('Error', error.message ?? 'Ocurrió un error inesperado.');
    } finally {
        const btn = document.getElementById('btn-enviar-receta');
        btn.disabled = false;
        btn.innerHTML = `<span class="material-symbols-outlined text-[20px]">send</span>Enviar receta`;
    }

}

async function historialRecetas(id_paciente, id_consulta) {
    try {
        const data = await getFetch(`/api/recetas/${id_paciente}`);
        document.getElementById('consulta_recetas_modal').value = id_consulta;
        cargarRecetasModal(data);
        document.getElementById('modal-recetas').showPopover();
    } catch (error) {
        console.log(error);
    }
}





document.addEventListener('DOMContentLoaded', () => {

    loadConsultas();
    servicios = getLocalStorangeData('servicios');
    loadOptions(servicios, 'ingreso-servicio');
    loadOptions(servicios, 'servicio-select');


    const inputBuscar = document.getElementById('input_buscar_paciente');

    if (inputBuscar) {
        inputBuscar.addEventListener('input', buscarConsulta);
    }

    const formIngresarPaciente = document.getElementById('form-ingresar-paciente');

    if (formIngresarPaciente) {
        formIngresarPaciente.addEventListener('submit', ingresarPacientes);
    }

    const formReasignarPaciente = document.getElementById('form-reasignar-paciente');

    if (formReasignarPaciente) {
        formReasignarPaciente.addEventListener('submit', reasignarPaciente);
    }

    const formEditarPaciente = document.getElementById('form-editar-paciente');

    if (formEditarPaciente) {
        formEditarPaciente.addEventListener('submit', editarPaciente);
    }

    const formRecetaPaciente = document.getElementById('form-receta-paciente');
    if (formRecetaPaciente) formRecetaPaciente.addEventListener('submit', generarReceta);

    const formUbicacionDx = document.getElementById('form-ubicacion-dx');
    if (formUbicacionDx) formUbicacionDx.addEventListener('submit', editarConsulta);

    document.getElementById('btn-enviar-receta').addEventListener('click', enviarRecetaSeleccionada);
});