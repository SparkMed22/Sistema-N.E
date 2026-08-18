/**
 * @fileoverview Inicia el proceso de autenticación del usuario.
 * @description Encargado de gestion src/index.php
 * @version      1.0.0
 * @date         2026-06-10
 * @author       Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @copyright    Sistema N.E. 2026
*/

// ? Manejo de Botones para la contraseña
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const visibilityIcon = document.getElementById('visibility-icon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        visibilityIcon.textContent = 'visibility_off';
    } else {
        passwordInput.type = 'password';
        visibilityIcon.textContent = 'visibility';
    }
}

// ? Cargar los Servicios del Hospital y Guardar en LocalStorange
async function loadConfig() {
    try {
        const data = await getFetch('/api/servicios', 'Error al obtener los usuarios.');
        localStorage.setItem('servicios', JSON.stringify(data));
    } catch (error) {
        console.error('Fallo en loadConfig:', error);
    }
}

// ? Iniciar login
async function stratLogin(event) {
    event.preventDefault();

    const form = event.target;
    const formData = new FormData(form);

    const cedula = formData.get('cedula');
    const password = formData.get('password');
    const submitBtn = document.getElementById('btn-login');

    const originalBtnText = submitBtn.textContent;

    submitBtn.disabled = true;
    submitBtn.textContent = 'Verificando...';
    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');

    try {
        if (!cedula || !password) throw new Error('Cédula y contraseña son requeridos.');
        const payload = { cedula, password }
        const data = await postFetch('/api/users/login', payload, 'Credenciales inválidas. Intente nuevamente.');
        localStorage.setItem('usuario', JSON.stringify(data.data));
        
        if (data.data.primer_ingreso === 1) {
            openModal('modal-password');
            return;
        }
        window.location.href = '/start/dashboard';
    } catch (error) {
        console.error('Error en login:', error);
        showError('Usuario no autenticado', error.message);
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
    }
}

// ? Actualizar Contraseña
async function updatePasswort(event) {
    event.preventDefault();

    const form = event.target;
    const submitBtn = document.getElementById('btn-change-password');
    const passwordNew = document.getElementById('new-password').value;
    const confirmPassword = document.getElementById('confirm-password').value;
    const originalBtnText = submitBtn.textContent;
    submitBtn.disabled = true;
    submitBtn.textContent = 'Actualizando...';
    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
    try {
        if (!passwordNew || !confirmPassword) throw new Error('Ambos campos de contraseña son requeridos.');
        if (passwordNew !== confirmPassword) throw new Error('Las contraseñas no coinciden.');
        if (passwordNew.length < 8) throw new Error('La contraseña debe tener al menos 8 caracteres.');
        const usuario = getLocalStorangeData('usuario', 'No se encontró la información del usuario.');
        if (!usuario.cedula) throw new Error('No se encontró la cédula del usuario.');

        const payload = {
            cedula: usuario.cedula,
            password_new: passwordNew,
            confirm_password: confirmPassword
        }

        const data = await postFetch('/users/update-password',payload,'Error al actualizar la contraseña.');
        closeModal('modal-password');
        showSuccess('Contraseña actualizada correctamente.');
        usuario.primer_ingreso = 0;
        localStorage.setItem('usuario', JSON.stringify(usuario));
        window.location.href = '/start/dashboard';

    } catch (error) {
        showError('Error en actualización', error.message, 'modal-password');
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = originalBtnText;
        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
        form.reset();
    }
}





document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const passwordForm = document.getElementById('form-password');
    if (loginForm) loginForm.addEventListener('submit', stratLogin);
    if (passwordForm) passwordForm.addEventListener('submit', updatePasswort);
    loadConfig().catch(err => console.error('Error en carga de fondo:', err));
});
