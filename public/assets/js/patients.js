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
        <div class="max-w-md rounded-2xl border border-outline-variant bg-surface-container-lowest p-5 shadow-sm">

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


    <!-- DX Médico -->
    <div class="mt-4 rounded-lg bg-primary-fixed p-3">

        <div class="flex items-center gap-2">

            <span class="material-symbols-outlined text-primary">
                medical_information
            </span>

            <p class="text-xs font-medium text-on-primary-fixed-variant">
                DX Médico
            </p>

        </div>

        <p class="mt-2 text-sm text-on-primary-fixed">
            ${consulta.diagnostico_medico || 'Sin diagnóstico registrado'}
        </p>

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
            type="button"
            class="rounded-lg bg-primary px-4 py-2 text-sm font-medium text-on-primary transition hover:bg-primary-container"
        >
            Ver consulta
        </button>

        <button
            type="button"
            onclick="modalReceta(${consulta.consulta_id})"
            class="rounded-lg bg-secondary px-4 py-2 text-sm font-medium text-on-secondary transition hover:bg-tertiary"
        >
            Nueva Receta
        </button>

        <button
            onclick="verRecetas(${consulta.paciente_id})"
            type="button"
            class="rounded-lg border border-outline bg-surface px-4 py-2 text-sm font-medium text-primary transition hover:bg-surface-container-high"
        >
            Ver receta
        </button>

        <button
            onclick="altaMedica(${consulta.consulta_id})"
            type="button"
            class="rounded-lg bg-surface-container-highest px-4 py-2 text-sm font-medium text-primary transition hover:bg-outline-variant"
        >
            Alta
        </button>

        <button
            onclick="editarPacienteModal(${consulta.paciente_id})"
            type="button"
            class="rounded-lg bg-tertiary-container px-4 py-2 text-sm font-medium text-on-tertiary-container transition hover:bg-tertiary"
        >
            Editar
        </button>

        <button
            onclick="reasignar(${consulta.consulta_id})"
            type="button"
            class="rounded-lg border border-outline-variant bg-surface-container-low px-4 py-2 text-sm font-medium text-on-surface-variant transition hover:bg-surface-container"
        >
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
    document.getElementById('edit-paciente-consulta').value = paciente.consulta_id;
    document.getElementById('edit-paciente-nombre').value = paciente.paciente_nombre;
    document.getElementById('edit-paciente-apellido').value = paciente.paciente_apellido;
    document.getElementById('edit-paciente-sexo').value = paciente.paciente_sexo;
    document.getElementById('edit-bloque').value = paciente.bloque;
    document.getElementById('edit-sala').value = paciente.sala;
    document.getElementById('edit-cama').value = paciente.cama;
    document.getElementById('edit-paciente-fecha').value = paciente.paciente_fecha_nacimiento || '';
    document.getElementById('edit-paciente-telefono').value = paciente.paciente_telefono;
    openModal('popover-editar-paciente');
}

async function editarPaciente(event) {
    event.preventDefault();
    const payload = {
        'editar_id': document.getElementById('edit-paciente-id').value,
        'edit_consulta': document.getElementById('edit-paciente-consulta').value,
        'editar_nombre': document.getElementById('edit-paciente-nombre').value,
        'editar_apellido': document.getElementById('edit-paciente-apellido').value,
        'editar_telefono': document.getElementById('edit-paciente-telefono').value,
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