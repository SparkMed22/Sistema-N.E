const usuarioData = localStorage.getItem('usuario');

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
        console.error("Elemento nombre_usuario no encontrado");
        return;
    }

    if (usuarioData && nombre_header) {
        try {
            const usuario = JSON.parse(usuarioData);
            const nombreCompleto = `${usuario.nombre} ${usuario.apellido}`;
            nombre_header.textContent = nombreCompleto;

            if (rol_header && usuario.rol) {
                rol_header.textContent = ROLES[usuario.rol] || usuario.rol;
            }

            // Agregar inicial al círculo
            if (inicial_header && usuario.nombre && usuario.apellido) {
                const inicial = (usuario.nombre[0] + usuario.apellido[0]).toUpperCase();
                inicial_header.textContent = inicial;
            }
        } catch (e) {
            console.error("Error al parsear datos del usuario", e);
            nombre_header.textContent = "Usuario";
        }
    } else {
        window.location.href = '/start';
    }
});