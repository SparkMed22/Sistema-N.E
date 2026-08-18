const tableBody = document.getElementById('users_table_body');
const tableHead = document.getElementById('table_tread');
const inputBuscar = document.getElementById('input_buscar_usuario');

const columnas = ['Usuario', 'Cedula', 'Rol', 'Servicio', 'Estado', 'Acciones'];

let usuarios = [];
let servicios = [];

columnas.forEach((columna) => {
    const th = document.createElement('th');
    th.className = 'px-6 py-4 text-xs font-bold uppercase tracking-wider text-on-surface-variant';
    th.textContent = columna;
    tableHead?.appendChild(th);
});


async function loadUsers() {
    try {
        usuarios = await getFetch('/api/users', 'Error al obtener los usuarios.') ?? [];
        renderizarUsuarios(usuarios);
    } catch (error) {
        console.error('loadUsers:', error);
        showError('Error del servidor', error.message ?? 'No se pudieron cargar los usuarios.');
    }
}


function renderizarUsuarios(usuariosData) {

    const usuariosRender = Array.isArray(usuariosData)
        ? usuariosData
        : [];

    if (!usuariosRender.length) {

        tableBody.innerHTML = `
            <tr>
                <td
                    colspan="${columnas.length}"
                    class="px-6 py-12 text-center text-sm text-on-surface-variant"
                >
                    No hay usuarios registrados.
                </td>
            </tr>
        `;

        return;
    }

    tableBody.innerHTML = usuariosRender.map((usuario) => crearFilaUsuario(usuario)).join('');
}

function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value ?? '';
    return div.innerHTML;
}

function crearFilaUsuario(usuario) {

    const estadoActivo = Boolean(usuario.estado);

    const estado = estadoActivo
        ? 'Activo'
        : 'Inactivo';

    const estadoClase = estadoActivo
        ? 'text-green-700'
        : 'text-on-surface-variant';

    const puntoClase = estadoActivo
        ? 'bg-green-500'
        : 'bg-gray-400';

    const nombre = escapeHtml(usuario.nombre);
    const apellido = escapeHtml(usuario.apellido);
    const cedula = escapeHtml(usuario.cedula);
    const nombre_servicio = escapeHtml(usuario.nombre_servicio);

    const rol = escapeHtml(
        ROLES?.[usuario.rol] ?? usuario.rol ?? 'Sin rol'
    );

    const id = escapeHtml(usuario.id);

    return `
        <tr class="group hover:bg-surface-container-low transition-colors">

            <!-- Usuario -->
            <td class="px-6 py-5">
                <div class="flex items-center gap-3">
                    <div>
                        <p class="font-semibold text-on-surface">
                            ${nombre}
                        </p>

                        <p class="text-xs text-on-surface-variant mt-0.5">
                            ${apellido}
                        </p>
                    </div>
                </div>
            </td>

            <!-- Cedula -->
            <td class="px-6 py-5">
                <p class="text-sm text-on-surface-variant">
                    ${cedula}
                </p>
            </td>

            <!-- Rol -->
            <td class="px-6 py-5">
                <span
                    class="inline-flex items-center px-2.5 py-1 rounded-lg bg-tertiary-fixed text-on-tertiary-fixed text-xs font-semibold"
                >
                    ${rol}
                </span>
            </td>

            <td class="px-6 py-5">
                <p class="text-sm text-on-surface-variant">
                    ${nombre_servicio}
                </p>
            </td>

            <!-- Estado -->
            <td class="px-6 py-5">
                <span
                    class="inline-flex items-center gap-2 text-sm font-medium ${estadoClase}"
                >
                    <span
                        class="w-2 h-2 rounded-full ${puntoClase}"
                    ></span>

                    ${estado}
                </span>
            </td>

            <!-- Acciones -->
            <td class="px-6 py-5">
                <div class="flex items-center gap-1">
                    <!-- Botón Editar -->
                    <button
                        type="button"
                        title="Editar usuario"
                        aria-label="Editar usuario"
                        data-action="edit-user"
                        data-id="${id}"
                        onclick="editarUserModel(this)"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full text-on-surface-variant transition-all duration-200 hover:bg-primary hover:text-on-primary focus:outline-none focus:ring-2 focus:ring-outline focus:ring-offset-2 focus:ring-offset-background active:scale-95 active:bg-primary/90">
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">edit</span>
                    </button>

                    <!-- Botón Reiniciar Contraseña -->
                    <button
                        type="button"
                        title="Reiniciar contraseña"
                        aria-label="Reiniciar contraseña"
                        data-action="reset-password"
                        data-id="${id}"
                        onclick="reiniciarPassword(this)"
                        class="inline-flex h-9 w-9 items-center justify-center rounded-full text-on-surface-variant transition-all duration-200 hover:bg-tertiary-container hover:text-on-tertiary-container focus:outline-none focus:ring-2 focus:ring-outline focus:ring-offset-2 focus:ring-offset-background active:scale-95 active:bg-tertiary-container/90">
                        <span class="material-symbols-outlined text-[20px]" aria-hidden="true">lock_reset</span>
                    </button>
                </div>
            </td>
        </tr>
    `;
}


function buscarUsuarios(event) {
    const texto = event.target.value.trim().toLowerCase();
    if (!texto) {
        renderizarUsuarios(usuarios);
        return;
    }
    const resultados = usuarios.filter((usuario) => {
        const nombreCompleto = [
            usuario.nombre,
            usuario.apellido
        ].filter(Boolean).join(' ').toLowerCase();
        const cedula = String(usuario.cedula ?? '').toLowerCase();
        return (nombreCompleto.includes(texto) || cedula.includes(texto));
    });
    renderizarUsuarios(resultados);
}



async function addUser(event) {
    event.preventDefault();
    const form = event.target;
    const formData = new FormData(form);
    const capitalizar = (texto) => {
        if (!texto) return '';
        texto = String(texto).trim();
        return texto.charAt(0).toUpperCase() + texto.slice(1).toLowerCase();
    };

    const cedula = String(formData.get('cedula') ?? '').trim();
    const nombre = capitalizar(formData.get('nombre'));
    const apellido = capitalizar(formData.get('apellido'));
    const rol = String(formData.get('rol') ?? '').trim();
    const id_servicio = parseInt(formData.get('id_servicio'));

    if (!cedula || !nombre || !apellido || !rol || isNaN(id_servicio)) {
        showError('Datos incompletos', 'Todos los campos son obligatorios.');
        return;
    }
    const paylod = { cedula, nombre, apellido, rol, id_servicio }
    try {
        const data = await postFetch('/api/users', paylod, 'El nuevo usuario no pudo ser creado.');
        closeModal('modal-nuevo-usuario');
        form.reset();
        await loadUsers();
        showSuccess('Usuario creado', data.message ?? 'El usuario fue creado correctamente.');
    } catch (error) {
        showError('Error al crear usuario', error.message ?? 'Ocurrió un error inesperado.');
    }
}


function editarUserModel(button) {
    const userId = button.dataset.id;
    const usuario = usuarios.find(
        user => String(user.id) === String(userId)
    );
    if (!usuario) {
        console.error('Usuario no encontrado:', userId);
        return;
    }
    document.getElementById('edit-id').value = usuario.id;
    document.getElementById('edit-nombre').value = usuario.nombre;
    document.getElementById('edit-apellido').value = usuario.apellido;
    document.getElementById('edit-cedula').value = usuario.cedula;
    document.getElementById('edit-rol').value = usuario.rol;
    document.getElementById('edit-estado').value = usuario.estado ? 'true' : 'false';
    document.getElementById('edit-id_servicio').value = usuario.id_servicio;
    openModal('modal-editar-usuario');
}



async function editUser(event) {
    event.preventDefault();
    const form = event.target;
    const id = document.getElementById('edit-id').value;
    const rol = document.getElementById('edit-rol').value;
    const estado = document.getElementById('edit-estado').value;
    const id_servicio = document.getElementById('edit-id_servicio').value;

    try {
        const paylod = {
            id: parseInt(id, 10),
            rol: rol,
            estado: estado === 'true',
            id_servicio: parseInt(id_servicio)
        }
        const data = await postFetch('/api/users/update-data', paylod, 'El usuario no pudo ser actualizado.');
        closeModal('modal-editar-usuario');
        form.reset();
        loadUsers();
        showSuccess('Usuario Actualizado', data.message ?? 'El usuario fue actualizado correctamente.');

    } catch (error) {
        closeModal('modal-editar-usuario');
        showError('Error al actualizar usuario', error.message ?? 'Ocurrió un error inesperado.');
    }
}


async function reiniciarPassword(button) {
    const userId = button.dataset.id;
    const usuario = usuarios.find(user => String(user.id) === String(userId));
    if (!usuario) {
        console.error('Usuario no encontrado:', userId);
        return;
    }
    try {
        const payload = {
            cedula: usuario.cedula,
            password_new: usuario.cedula,
            confirm_password: usuario.cedula
        };
        const data = await postFetch('/api/users/update-password', payload, 'Error al reiniciar la contraseña.');
        await loadUsers();
        showSuccess('Usuario actualizado', data.message ?? 'La contraseña fue reiniciada correctamente.');

    } catch (error) {
        showError('Error al actualizar usuario', error.message ?? 'Ocurrió un error inesperado.');
    }
}




document.addEventListener('DOMContentLoaded', () => {
    loadUsers();
    servicios = getLocalStorangeData('servicios');
    loadOptions(servicios, 'id_servicio');
    loadOptions(servicios, 'edit-id_servicio');


    const addUserForm = document.getElementById('form-add-user');
    if (addUserForm) {
        addUserForm.addEventListener('submit', addUser);
    }
    if (inputBuscar) {
        inputBuscar.addEventListener('input', buscarUsuarios);
    }

    const edit_User = document.getElementById('form-edit-user');
    if (edit_User) edit_User.addEventListener('submit', editUser);
});