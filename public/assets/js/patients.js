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
        <div class="max-w-md rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
                    <div class="mb-4 flex items-start justify-between">
                        <div>
                            <span class="text-xs font-medium uppercase tracking-wide text-gray-500">
                                Consulta #${consulta.consulta_id}
                            </span>

                            <h2 class="mt-1 text-lg font-semibold text-gray-900">
                                ${consulta.paciente_nombre} ${consulta.paciente_apellido}
                            </h2>

                            <p class="text-sm text-gray-500">
                                C.I.: ${consulta.paciente_cedula}
                            </p>
                        </div>
                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                            Activa
                        </span>
                    </div>

                    <div class="space-y-3 border-t border-gray-100 pt-4">
                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50">
                                🏥
                            </div>

                            <div>
                                <p class="text-xs text-gray-500">Servicio</p>
                                <p class="text-sm font-medium text-gray-900">
                                    ${consulta.servicio_nombre}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-purple-50">
                                🛏️
                            </div>

                            <div>
                                <p class="text-xs text-gray-500">Ubicación</p>
                                <p class="text-sm font-medium text-gray-900">
                                    ${consulta.bloque} · Sala ${consulta.sala} · Cama ${consulta.cama}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100">
                                📅
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Fecha de ingreso</p>
                                <p class="text-sm font-medium text-gray-900"> ${consulta.fecha_ingreso}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 rounded-lg bg-gray-50 p-3">
                        <p class="text-xs font-medium text-gray-500">Observaciones</p>
                        <p class="mt-1 text-sm text-gray-700"> ${consulta.observaciones_ingreso} </p>
                    </div>

                    <div class="mt-5 grid grid-cols-2 gap-2">
                      <button type="button"
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
                        onclick="verRecetas(${consulta.paciente_id})"
                        type="button"
                        class="rounded-lg border border-outline bg-surface px-4 py-2 text-sm font-medium text-primary transition hover:bg-surface-container-high">
                        Ver receta
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
                        Editar
                      </button>

                      <button
                        onclick="reasignar(${consulta.consulta_id})"
                        type="button"
                        class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2 text-sm font-medium text-on-surface-variant transition hover:bg-surface-container">
                        Reasignar
                      </button>
                    </div>
                    
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
        diagnostico_medico:ingreso_diagnostico,
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
    document.getElementById('edit-paciente-consulta').value = paciente.consulta_id;
    document.getElementById('edit-paciente-nombre').value = paciente.paciente_nombre;
    document.getElementById('edit-paciente-apellido').value = paciente.paciente_apellido;
    document.getElementById('edit-paciente-sexo').value = paciente.paciente_sexo;
    document.getElementById('edit-bloque').value = paciente.bloque;
    document.getElementById('edit-sala').value = paciente.sala;
    document.getElementById('edit-cama').value = paciente.cama;
    document.getElementById('edit-paciente-fecha').value = paciente.paciente_fecha_nacimiento || '';


    openModal('popover-editar-paciente');
}

async function editarPaciente(event) {
    event.preventDefault();
    const payload = {
        'editar_id': document.getElementById('edit-paciente-id').value,
        'edit_consulta': document.getElementById('edit-paciente-consulta').value,
        'editar_nombre': document.getElementById('edit-paciente-nombre').value,
        'editar_apellido': document.getElementById('edit-paciente-apellido').value,
        'editar_sexo': document.getElementById('edit-paciente-sexo').value,
        'editar_bloque': document.getElementById('edit-bloque').value,
        'editar_sala': document.getElementById('edit-sala').value,
        'editar_cama': document.getElementById('edit-cama').value,
        'editar_fecha_nacimiento': document.getElementById('edit-paciente-fecha').value,
    }

    try {
        const data = await postFetch('/api/consultation/editar', payload, 'Error al actualizar la infomrmacion');
        closeModal('popover-editar-paciente');
        showSuccess('Éxito', data.message || 'Edicion ejecutacon con exito.');
        loadConsultas();
    } catch (error) {
        closeModal('popover-editar-paciente');
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



function verRecetas(id_consulta) {
    alert("ñj");
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


});