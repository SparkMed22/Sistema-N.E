document.addEventListener('DOMContentLoaded', () => {
    const usuarioData = localStorage.getItem('usuario');
    const nombreSpan = document.getElementById('nombre_usuario');

    if (usuarioData && nombreSpan) {
        try {
            const usuario = JSON.parse(usuarioData);
            const nombreCompleto = `${usuario.nombre} ${usuario.apellido}`;
            nombreSpan.textContent = nombreCompleto;
        } catch (e) {
            console.error("Error al parsear datos del usuario", e);
            nombreSpan.textContent = "Usuario";
        }
    } else {
        window.location.href = '/start';
    }
});