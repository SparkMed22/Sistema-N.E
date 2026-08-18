const usuarioDataRawStorageHeader = localStorage.getItem('usuario');
const serviciosRaw = localStorage.getItem('servicios');

const usuarioData = usuarioDataRawStorageHeader ? JSON.parse(usuarioDataRawStorageHeader) : null;
const serviciosHeader = serviciosRaw ? JSON.parse(serviciosRaw) : null;

const nombre_header = document.getElementById('nombre_usuario');
const rol_header = document.getElementById('rol_usuario');
const inicial_header = document.getElementById('inicial_usuario');

const ROLES = {
    'admin': 'Administrador',
    'internacion': 'Internacion',
    'nutricionista': 'Nutricionista'
};

document.addEventListener('DOMContentLoaded', () => {
    if (!nombre_header) {
        console.error("Elemento nombre_usuario no encontrado en el DOM");
        return;
    }

    if (usuarioData && nombre_header && serviciosHeader) {
        try {
            const nombreCompleto = `${usuarioData.nombre} ${usuarioData.apellido}`;
            nombre_header.textContent = nombreCompleto;
            let servicioUsuario = '';

            if (usuarioData.id_servicio === 1) {
                servicioUsuario = 'Polivalente';
            } else {
                const index = usuarioData.id_servicio - 1;
                // Verificamos que el índice exista en el array
                if (index >= 0 && index < serviciosHeader.length) {
                    servicioUsuario = serviciosHeader[index].nombre;
                } else {
                    console.warn("ID de servicio inválido:", usuarioData.id_servicio);
                    servicioUsuario = 'Desconocido';
                }
            }

            if (rol_header && usuarioData.rol) {
                const rolTexto = ROLES[usuarioData.rol] || usuarioData.rol;
                rol_header.textContent = `${rolTexto} / ${servicioUsuario}`;
            }

            if (inicial_header && usuarioData.nombre && usuarioData.apellido) {
                const nombre = usuarioData.nombre || '';
                const apellido = usuarioData.apellido || '';
                const inicial = (nombre[0] + apellido[0]).toUpperCase();
                inicial_header.textContent = inicial;
            }
        } catch (e) {
            // Opcional: Redirigir si el formato de datos está corrupto
            window.location.href = '/start'; 
        }
    } else {
        console.warn("No se encontraron datos de sesión. Redirigiendo a /start");
        window.location.href = '/start';
    }
});