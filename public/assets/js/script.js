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
    localStorage.clear();
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

// Función auxiliar para éxito
const showSuccess = (title, message, containerId) => {
    // Garantiza que tenga el formato de selector CSS (#id)
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

// Función auxiliar para confirmar (opcional, si quieres pedir confirmación antes de borrar/cambiar)
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