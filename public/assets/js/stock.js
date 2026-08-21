const table_titulos_stock = document.getElementById('table-titulos');
const filter_items = document.getElementById('filter-items');
const titulos_stock = ['Artículo', 'Stock', 'Estado', 'Acciones'];
const INTERVALO = 5;
let prodcutosFormulasEnterales = [];
let prodcutosFormulasDispobibles = [];


table_titulos_stock.innerHTML = titulos_stock.map((titulo, index) => {
    const esAcciones = index === titulos_stock.length - 1;
    const alineacion = esAcciones ? 'text-right' : 'text-left';

    return `<th class="px-6 py-4 font-semibold ${alineacion}">${titulo}</th>`;
}).join('');

// ? Renderisar tablas
function renderInventario(productos) {
    const tbody = document.getElementById("table-productos");

    tbody.innerHTML = productos.map(producto => {

        let estado;
        let estadoClass;
        let puntoClass;

        if (producto.cantidad > producto.stock_minimo + 5) {
            estado = "Disponible";
            estadoClass = "bg-emerald-50 text-emerald-700";
            puntoClass = "bg-emerald-500";

        } else if (producto.cantidad >= producto.stock_minimo) {
            estado = "Stock bajo";
            estadoClass = "bg-amber-50 text-amber-700";
            puntoClass = "bg-amber-500";

        } else {
            estado = "Crítico";
            estadoClass = "bg-rose-50 text-rose-700";
            puntoClass = "bg-rose-500";
        }

        return `
            <tr class="hover:bg-surface-container-low transition">

                <td class="px-6 py-5">
                    <div class="flex items-center gap-4">
                        <div>
                            <p class="font-bold">${producto.nombre}</p>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-5">
                    <p class="font-bold text-primary">${producto.cantidad}</p>
                    <p class="text-xs text-on-surface-variant">unidades</p>
                </td>
                <!-- Estado -->
                <td class="px-6 py-5">
                    <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full ${estadoClass} text-xs font-bold">
                        <span class="w-2 h-2 rounded-full ${puntoClass}"></span>${estado}
                    </span>
                </td>

                <!-- Acciones -->
                <td class="px-6 py-5 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <!-- Botón 1: Editar -->
                        <button
                            type="button"
                            onclick="modalIncrementStock(${producto.id})" 
                            title="Editar"
                            class="p-2 rounded-xl text-on-surface-variant hover:text-primary hover:bg-surface-container transition inline-flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">edit</span>
                        </button>

                        <!-- Botón 2: Eliminar -->
                        <button
                            onclick="modalDecrementStock(${producto.id})"
                            type="button"
                            title="Eliminar"
                            class="p-2 rounded-xl text-on-surface-variant hover:text-rose-600 hover:bg-rose-50 transition inline-flex items-center justify-center">
                            <span class="material-symbols-outlined text-xl">delete</span>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    }).join("");
}

// ? Cargar los productos
async function loadProductos() {
    try {
        prodcutosFormulasEnterales = await getFetch('/api/stock/productos', 'Error al obtener los prductos.') ?? [];
        prodcutosFormulasDispobibles = prodcutosFormulasEnterales.filter(p => p.cantidad > 0);
        renderInventario(prodcutosFormulasDispobibles);
    } catch (error) {
        console.error('loadProductos:', error);
        showError('Error del servidor', error ?? 'No se pudieron cargar los productos.');
    }
}


// ? Cargar nuevos productos 
async function addNewItem(event) {
    event.preventDefault();
    const form = event.target;
    const payload = {
        nombre: document.getElementById('new-item-nombre').value,
        cantidad_inicial: parseInt(document.getElementById('new-item-cantidad-inicial').value),
        cantidad_minima: parseInt(document.getElementById('new-item-cantidad-minima').value)
    }
    try {
        const data = await postFetch('/api/stock/productos', payload, 'No se pudo crear el nuevo producto');
        closeModal('modal-new-item');
        showSuccess('Producto Agregado', data.message ?? 'La formula fue añadida a la base de datos correctamente.');
        loadProductos();
    } catch (error) {
        closeModal('modal-new-item');
        showError('Error al Agregar el producto', error.message ?? 'Ocurrió un error inesperado.');
    } finally {
        form.reset();
    }
}


function buscarProducto(event) {
    const texto = event.target.value.trim().toLowerCase();
    if (!texto) {
        renderInventario(prodcutosFormulasDispobibles);
        return;
    }
    const resultados = prodcutosFormulasEnterales.filter((producto) => {
        const nombreCompleto = [
            producto.nombre
        ].filter(Boolean).join(' ').toLowerCase();
        return (nombreCompleto.includes(texto));
    });
    renderInventario(resultados);
}


function handleFilterChange(status) {
    let list = [];
    switch (status) {
        case '0':
            renderInventario(prodcutosFormulasDispobibles);
            break;
        case '1':
            list = prodcutosFormulasDispobibles.filter(p => p.cantidad > (p.stock_minimo + INTERVALO));
            renderInventario(list);
            break;
        case '2':
            list = prodcutosFormulasDispobibles.filter(p => p.cantidad > p.stock_minimo && p.cantidad <= (p.stock_minimo + INTERVALO));
            renderInventario(list);
            break;
        case '3':
            list = prodcutosFormulasDispobibles.filter(p => p.cantidad < p.stock_minimo);
            renderInventario(list);
            break;
    }
}

// ? Incrementar Stock
function modalIncrementStock(id_producto) {
    openModal('modal-increment-stock');
    document.getElementById('inc-item-cantidad-id').value = id_producto;
}

async function incrementStock(event) {
    event.preventDefault();
    const form = event.target;

    const cantidadInput = document.getElementById('inc-item-cantidad').value;
    const cantidad = parseInt(cantidadInput, 10);

    if (isNaN(cantidad) || cantidad <= 0) {
        closeModal('modal-increment-stock');
        showError("Cantidad Inválida", 'Ingrese una cantidad mayor a 0');
        return;
    }

    const payload = {
        productoId: parseInt(document.getElementById('inc-item-cantidad-id').value, 10),
        usuarioId: getLocalStorangeData('usuario').id,
        cantidad: cantidad,
        motivo: document.getElementById('inc-item-motivo').value.trim()
    };

    try {
        const data = await postFetch('/api/stock/productos/incrementar', payload, 'No se pudo crear el nuevo producto');
        closeModal('modal-increment-stock');
        showSuccess('Producto Agregado', data.message ?? 'La formula fue añadida a la base de datos correctamente.');
        loadProductos();
    } catch (error) {
        closeModal('modal-increment-stock');
        showError('Error al Agregar el producto', error.message ?? 'Ocurrió un error inesperado.');
    } finally {
        form.reset();
    }
}

// ? Incrementar Stock
function modalDecrementStock(id_producto) {
    if (typeof id_producto === 'object') {
        console.error('Error: Se envió un evento en lugar de un ID numérico.');
        return;
    }
    openModal('modal-decrement-stock');
    document.getElementById('dec-item-cantidad-id').value = id_producto;
}
async function decrementStock(event) {
    event.preventDefault();
    const form = event.target;

    const productoID = parseInt(document.getElementById('dec-item-cantidad-id').value, 10);
    const cantidad = parseInt(document.getElementById('dec-item-cantidad').value, 10);

    const motivoInput = document.getElementById('dec-item-motivo');
    const motivo = motivoInput ? motivoInput.value.trim() : '';

    const producto = prodcutosFormulasEnterales.find(p => p.id === productoID);

    if (!producto) {
        closeModal('modal-decrement-stock');
        showError("Error de Selección", 'El producto seleccionado no existe en la lista.');
        return;
    }

    if (isNaN(cantidad) || cantidad <= 0 || cantidad > producto.cantidad) {
        form.reset();
        closeModal('modal-decrement-stock');
        showError("Cantidad Inválida", `La cantidad ingresada debe ser entre 1 y ${producto.cantidad}.`);
        return;
    }

    const payload = {
        'productoId': parseInt(productoID),
        'usuarioId': parseInt(getLocalStorangeData('usuario').id), 
        'cantidad': parseInt(cantidad),
        'motivo': motivo
    };

    console.log('Payload listo para enviar:', payload);

    try {
        const data = await postFetch('/api/stock/productos/decrementar', payload, 'No se pudo decrementar');
        closeModal('modal-decrement-stock');
        showSuccess('Producto decrementado', data.message ?? 'La formula fue añadida a la base de datos correctamente.');
        loadProductos();
    } catch (error) {
        closeModal('modal-decrement-stock');
        showError('Error al decrementar el producto', error.message ?? 'Ocurrió un error inesperado.');
    } finally {
        form.reset();
    }
}



document.addEventListener('DOMContentLoaded', () => {
    loadProductos();
    const inputBuscar = document.getElementById('input_buscar_producto');
    if (inputBuscar) {
        inputBuscar.addEventListener('input', buscarProducto);
    }
    const newItemForm = document.getElementById('form-new-item');
    if (newItemForm) {
        newItemForm.addEventListener('submit', addNewItem);
    }
    const formIncrementStock = document.getElementById('form-increment-stock');
    if (formIncrementStock) {
        formIncrementStock.addEventListener('submit', incrementStock);
    }


    const formDecrementStock = document.getElementById('form-decrement-stock');
    if (formDecrementStock) {
        formDecrementStock.addEventListener('submit', decrementStock);
    }

});