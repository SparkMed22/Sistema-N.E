let consultas = [];
let usuariosActivos = [];

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
                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-orange-50">
                                👨‍⚕️
                            </div>
                            <div>
                                <p class="text-xs text-gray-500">Profesional tratante</p>
                                <p class="text-sm font-medium text-gray-900">
                                    ${consulta.profesional_tratante}
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
                        class="rounded-lg bg-secondary px-4 py-2 text-sm font-medium text-on-secondary transition hover:bg-tertiary">
                        Receta
                      </button>

                      <button
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
                        onclick="editarPaciente(${consulta.paciente_id})"
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


function existeUsuarioLocal() {
    const usuarioStorage = localStorage.getItem('usuario');
    if (!usuarioStorage) throw new Error('No se encontró la información del usuario.');
    try {
        return JSON.parse(usuarioStorage);
    } catch (error) {
        throw new Error('La información del usuario está corrupta. Por favor, inicie sesión nuevamente.');
    }
}


async function loadConsultas() {
    try {
        const usuario = existeUsuarioLocal();

        const url = `/api/${usuario.rol}/consultation/${usuario.id}/activas`;

        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(
                `Error del servidor (${response.status}): No se pudieron obtener las consultas.`
            );
        }
        const res = await response.json();
        consultas = res.data;
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
    const cama = document.getElementById('ingreso-cama').value.trim();

    const usuario = JSON.parse(localStorage.getItem('usuario'));

    const dataPaciente = {
        cedula: cedula,
        servicio_id: parseInt(servicio, 10),
        usuario_ingreso_id: usuario.id,
        usuario_tratante_id: usuario.id,
        usuario_egreso_id: null,
        observaciones_ingreso: observaciones,
        bloque: bloque,
        sala: sala,
        cama: cama
    };

    try {
        const response = await fetch('/api/consultation', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(dataPaciente)
        });

        let data;
        try {
            data = await response.json();
        } catch (jsonError) {
            throw new Error('El servidor devolvió una respuesta inválida.');
        }

        if (!response.ok || !data?.success) {
            const errorMsg = data?.message || 'No se pudo crear la consulta.';
            const safeMsg = document.createTextNode(errorMsg).textContent;
            throw new Error(safeMsg);
        }

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



async function loadUsuariosConsultas() {
    try {
        const url = `/api/users/activos`;
        const response = await fetch(url);
        if (!response.ok) throw new Error(`Error del servidor (${response.status}): No se pudieron obtener los usuarios.`);
        const res = await response.json();
        usuariosActivos = res.data;
    } catch (error) {
        console.error('Error en loadConsultas:', error.message);
        if (error.message.includes('Sesión expirada')) {
            window.location.href = '/login';
        }
        throw error;
    }
}

function reasignar(id_paciente) {
    try {
        const usuario = existeUsuarioLocal();
        const lista = document.getElementById('profesional-select');
        const inputIdConsulta = document.getElementById('id-consulta-reasignar');
        document.getElementById('current-prof-name').innerText = `${usuario.nombre} ${usuario.apellido}`;
        if (!lista || !inputIdConsulta) return;
        inputIdConsulta.value = id_paciente;
        const fragment = document.createDocumentFragment();
        const defaultOption = new Option('Seleccionar profesional', '');
        fragment.appendChild(defaultOption);
        usuariosActivos.forEach(({ id, nombre, apellido }) => {
            const option = new Option(`${nombre} ${apellido}`, id);
            fragment.appendChild(option);
        });
        lista.replaceChildren(fragment);
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
        const selectProfesional = document.getElementById('profesional-select');

        if (!inputIdConsulta || !selectProfesional) {
            throw new Error('Error: Elementos del formulario no encontrados.');
        }

        const id_consulta = inputIdConsulta.value;
        const id_profesional = selectProfesional.value;

        if (!id_consulta) {
            throw new Error('No se pudo identificar la consulta.');
        }
        if (!id_profesional) {
            throw new Error('Por favor, selecciona un nuevo profesional.');
        }

        const payload = {
            id_consulta: Number(id_consulta),
            id_profesional: Number(id_profesional)
        };

        const response = await fetch('/api/consultation/reasignar', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        let data;
        try {
            data = await response.json();
        } catch (jsonError) {
            throw new Error('El servidor devolvió una respuesta inválida.');
        }

        if (!response.ok || !data?.success) {
            const errorMsg = data?.message || 'No se pudo reasignar el profesional.';
            const safeMsg = document.createTextNode(errorMsg).textContent;
            throw new Error(safeMsg);
        }

        closeModal('popover-reasignar');
        showSuccess('Éxito', data.message || 'Profesional reasignado correctamente.');

        loadConsultas();
        loadUsuariosConsultas();


    } catch (error) {
        closeModal('popover-reasignar');
        const safeErrorMsg = document.createTextNode(error.message || 'Ocurrió un error inesperado.').textContent;
        showError("Error", safeErrorMsg);
    }
}


async function altaMedica(id_consulta) {
    try {
        const usuario = existeUsuarioLocal();
        const payload = {
            id_consulta: Number(id_consulta),
            id_profesional: Number(usuario.id)
        };

        const response = await fetch('/api/consultation/alta', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });


        const data = await response.json();

        if (!response.ok) {
            const errorMsg = data?.message || 'No se pudo dar de alta al paciente.';
            throw new Error(safeMsg);
        }

        showSuccess('Éxito', data.message || 'Alta ejecutacon con exito.');

        loadConsultas();
        loadUsuariosConsultas();
    } catch (error) {
        showError("Error",error);
    }
}


async function editarPaciente(id_paciente){
    const paciente  = consultas.find(consulta => consulta.paciente_id == id_paciente);
    document.getElementById('edit-paciente-id').innerText = paciente.id_paciente || paciente.paciente_id;
    document.getElementById('edit-paciente-nombre').value = paciente.paciente_nombre;
    document.getElementById('edit-paciente-apellido').value = paciente.paciente_apellido;
    document.getElementById('edit-paciente-sexo').value = paciente.paciente_sexo;
    openModal('popover-editar-paciente');
}


document.addEventListener('DOMContentLoaded', () => {

    loadConsultas();
    loadUsuariosConsultas();

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

});