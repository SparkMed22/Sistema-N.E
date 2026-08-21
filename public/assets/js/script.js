/**
 * @fileoverview Script de usu general para funcionalidades comunes en toda la aplicacion.
 * @version      1.0.0
 * @date         2026-06-10
 * @author       Francisco David Medina Lourenzo <sparkmed0224@gmail.com>
 * @copyright    Sistema N.E. 2026
*/

// ? Manejo de Modal Popover
function openModal(id) {
    const popover = document.getElementById(id);
    popover.showPopover();
}

function closeModal(id) {
    const popover = document.getElementById(id);
    popover.hidePopover();
}

// ? Cerrar Sesión
function logout() {
    localStorage.removeItem('usuario');

    fetch('/logout', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (response.ok) {
                window.location.href = '/';
            } else {
                window.location.href = '/';
            }
        })
        .catch(error => {
            console.error('Error al cerrar sesión:', error);
            window.location.href = '/';
        });
}

// ?  Manejo de Alertas
const showError = (title, message, containerId) => {
    const targetElement = containerId
        ? (containerId.startsWith('#') ? containerId : `#${containerId}`)
        : 'body';
    Swal.fire({
        icon: 'error',
        title: title || '¡Ups!',
        text: message,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Entendido',
        target: targetElement
    });
};

const showSuccess = (title, message, containerId) => {
    const targetElement = containerId
        ? (containerId.startsWith('#') ? containerId : `#${containerId}`)
        : 'body';

    Swal.fire({
        icon: 'success',
        title: title || '¡Éxito!',
        text: message,
        confirmButtonColor: '#28a745',
        confirmButtonText: 'Genial',
        target: targetElement
    });
};

const showConfirm = (title, text) => {
    return Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
    });
};


// ? GET GENERICO 
async function getFetch(url, message_error) {
    try {
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        });
        if (!response.ok) {
            const errorData = await response.json().catch(() => ({}));
            throw new Error(errorData.message || errorMessage);
        }
        return (await response.json()).data;
    } catch (error) {
        showError('Error del servidor', error.message ?? 'ERROR HABLE CON SOPORTE.');
        return null;
    }
}


// ? POST GENERICO
async function postFetch(url, payload, messageError) {
    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        const data = await response.json();
        if (!response.ok || !data.success) throw new Error(data.message ?? messageError);
        return data;
    } catch (error) {
        console.error('Error en el servidor:', error);
        throw error;
    }
}
// ? Recuperar el localStorange y retornar un json
function getLocalStorangeData(key, message_error) {
    const data = localStorage.getItem(key);
    if (!data) throw new Error(message_error);
    return JSON.parse(data);
}


// ? Cargar select dinamicamente
function loadOptions(arreglo, id) {
    const select = document.getElementById(id);
    if (servicios.length === 0) {
        select.innerHTML = '<option value="" disabled>No hay servicios disponibles</option>';
        return;
    }
    servicios.forEach(servicio => {
        const option = document.createElement('option');
        option.value = servicio.id;
        option.textContent = servicio.nombre;
        select.appendChild(option);
    });
}


// ? Modo DARK
function getThemePreference(defaultValue = 'light') {
    try {
        return localStorage.getItem('preference') || defaultValue;
    } catch (error) {
        console.error('Error al leer localStorage:', error);
        return defaultValue;
    }
}

function setThemePreference(newTheme) {
    try {
        localStorage.setItem('preference', newTheme);

        if (newTheme === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        return newTheme;
    } catch (error) {
        console.error('Error al guardar en localStorage:', error);
    }
}

function toggleTheme() {
    const currentTheme = getThemePreference();
    const nextTheme = currentTheme === 'dark' ? 'light' : 'dark';
    return setThemePreference(nextTheme);
}


// ! SOLO PARA DESARROLLO 
// localStorage.setItem('autoReloadEnabled', 'false');
// localStorage.setItem('autoReloadEnabled', 'true'); 
document.addEventListener('DOMContentLoaded', () => {
    const debeRecargar = localStorage.getItem('autoReloadEnabled') === 'true';

    if (debeRecargar) {
        console.log('Recarga automática activada cada 5 segundos.');
        setInterval(() => {
            location.reload();
        }, 5000);
    } else {
        console.log('Recarga automática desactivada.');
    }
});


