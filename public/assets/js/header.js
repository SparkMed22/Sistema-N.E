const usuarioRaw = localStorage.getItem('usuario');
const serviciosRaw = localStorage.getItem('servicios');

const nombreHeader = document.getElementById('nombre_usuario');
const rolHeader = document.getElementById('rol_usuario');
const inicialHeader = document.getElementById('inicial_usuario');

const ROLES = {
    admin: 'Administrador',
    internacion: 'Internación',
    nutricionista: 'Nutricionista'
};

document.addEventListener('DOMContentLoaded', () => {
    try {
        setThemePreference(getThemePreference());
        if (!nombreHeader) {
            console.error('Elemento #nombre_usuario no encontrado');
            return;
        }

        if (!usuarioRaw) throw new Error('No se encontraron datos del usuario');        

        const usuarioData = JSON.parse(usuarioRaw);
        const servicios = serviciosRaw ? JSON.parse(serviciosRaw) : [];

        if (!usuarioData?.nombre || !usuarioData?.apellido) {
            throw new Error('Datos del usuario inválidos');
        }

        const nombreCompleto =`${usuarioData.nombre} ${usuarioData.apellido}`;

        nombreHeader.textContent = nombreCompleto;

        let servicioUsuario = 'Sin servicio';

        if (usuarioData.id_servicio && Array.isArray(servicios)) {
            const servicio = servicios.find(servicio => servicio.id === Number(usuarioData.id_servicio));

            if (servicio) {
                servicioUsuario = servicio.nombre;
            } else {
                console.warn('Servicio no encontrado:', usuarioData.id_servicio);
                servicioUsuario = 'Desconocido';
            }
        }

        if (rolHeader) {
            const rolTexto = ROLES[usuarioData.rol] || usuarioData.rol || 'Sin rol';
            rolHeader.textContent = `${rolTexto} / ${servicioUsuario}`;
        }

        if (inicialHeader) {
            const iniciales =
                `${usuarioData.nombre[0]}${usuarioData.apellido[0]}`
                    .toUpperCase();
            inicialHeader.textContent = iniciales;
        }
    } catch (error) {
        console.error('Error al cargar los datos del usuario:', error);
        localStorage.removeItem('usuario');
        window.location.href = '/start';
    }
});