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
    console.log(id_producto);
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



// ? INFORME 
const formInforme = document.getElementById('form-informe');

formInforme.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(formInforme);

    const desde = formData.get('fechaDesde');
    const hasta = formData.get('fechaHasta');

    if (!desde || !hasta) {
        alert('Debe seleccionar ambas fechas.');
        return;
    }

    if (desde > hasta) {
        alert('La fecha desde no puede ser mayor que la fecha hasta.');
        return;
    }

    try {


        const usuarioStorage = localStorage.getItem('usuario');

        if (!usuarioStorage) {
            alert('No se encontró la información del usuario.');
            return;
        }

        const usuario = JSON.parse(usuarioStorage);

        const nombreUsuario =
            `${usuario.nombre ?? ''} ${usuario.apellido ?? ''}`.trim();

        const response = await fetch('/api/informes/stock', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                fecha_desde: desde,
                fecha_hasta: hasta
            })
        });

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const resultado = await response.json();

        if (!resultado.success) {
            throw new Error(
                resultado.message || 'No se pudo generar el informe.'
            );
        }

        const datos = resultado.data;

        if (!Array.isArray(datos) || datos.length === 0) {
            alert('No existen datos para el período seleccionado.');
            return;
        }

        const productos = datos.map(item => ({
            producto: item.producto ?? '',
            stockInicial: Number(item.stock_inicial) || 0,
            entradas: Number(item.cantidad_entradas) || 0,
            salidas: Number(item.cantidad_salidas) || 0,
            stockActual: Number(item.cantidad_actual) || 0
        }));

        const totalStockInicial = productos.reduce(
            (total, item) => total + item.stockInicial,
            0
        );

        const totalEntradas = productos.reduce(
            (total, item) => total + item.entradas,
            0
        );

        const totalSalidas = productos.reduce(
            (total, item) => total + item.salidas,
            0
        );

        const totalStockActual = productos.reduce(
            (total, item) => total + item.stockActual,
            0
        );

        const productosConStock = productos.filter(
            item => item.stockActual > 0
        ).length;

        const ahora = new Date();

        const fechaGeneracion = ahora.toLocaleDateString('es-PY');

        const horaGeneracion = ahora.toLocaleTimeString('es-PY', {
            hour: '2-digit',
            minute: '2-digit'
        });

        const workbook = new ExcelJS.Workbook();

        workbook.creator = nombreUsuario;
        workbook.lastModifiedBy = nombreUsuario;
        workbook.created = ahora;
        workbook.modified = ahora;

        workbook.properties.title = 'Reporte de Stock';
        workbook.properties.subject =
            'Informe de movimientos y stock';
        workbook.properties.company = 'S.N.E';

        const worksheet = workbook.addWorksheet(
            'Reporte de Stock',
            {
                pageSetup: {
                    orientation: 'landscape',
                    paperSize: 9,
                    fitToPage: true,
                    fitToWidth: 1,
                    fitToHeight: 0
                }
            }
        );


        worksheet.columns = [
            {
                key: 'producto',
                width: 48
            },
            {
                key: 'inicial',
                width: 18
            },
            {
                key: 'entradas',
                width: 18
            },
            {
                key: 'salidas',
                width: 18
            },
            {
                key: 'actual',
                width: 18
            }
        ];

        // ======================================================
        // PALETA
        // ======================================================

        const AZUL_OSCURO = '17365D';
        const AZUL = '2F75B5';
        const AZUL_CLARO = 'D9EAF7';
        const GRIS = 'F3F6F9';
        const GRIS_BORDE = 'D9E1F2';
        const BLANCO = 'FFFFFF';
        const NEGRO = '222222';
        const VERDE = '548235';
        const ROJO = 'C00000';

        // ======================================================
        // TÍTULO
        // ======================================================

        worksheet.mergeCells('A1:E1');

        const titulo = worksheet.getCell('A1');

        titulo.value = 'REPORTE DE STOCK';

        titulo.font = {
            name: 'Arial',
            size: 20,
            bold: true,
            color: {
                argb: BLANCO
            }
        };

        titulo.fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: {
                argb: AZUL_OSCURO
            }
        };

        titulo.alignment = {
            horizontal: 'center',
            vertical: 'middle'
        };

        worksheet.getRow(1).height = 35;


        worksheet.mergeCells('A2:E2');

        const subtitulo = worksheet.getCell('A2');

        subtitulo.value ='Sistema Nutrición Enteral';

        subtitulo.font = {
            name: 'Arial',
            size: 11,
            bold: true,
            color: {
                argb: AZUL_OSCURO
            }
        };

        subtitulo.alignment = {
            horizontal: 'center',
            vertical: 'middle'
        };

        worksheet.getRow(2).height = 22;

        // ======================================================
        // PERÍODO
        // ======================================================

        worksheet.mergeCells('A3:E3');

        const periodo = worksheet.getCell('A3');

        periodo.value =
            `Período: ${desde}  →  ${hasta}`;

        periodo.font = {
            name: 'Arial',
            size: 10,
            italic: true,
            color: {
                argb: '666666'
            }
        };

        periodo.alignment = {
            horizontal: 'center',
            vertical: 'middle'
        };

        worksheet.mergeCells('A5:E5');

        const infoTitulo = worksheet.getCell('A5');

        infoTitulo.value = 'INFORMACIÓN DEL REPORTE';

        aplicarTituloSeccion(infoTitulo, AZUL);

        const informacion = [
            ['Emitido por', 'S.N.E', 'Generado por', nombreUsuario],
            ['Cédula', usuario.cedula ?? '', 'Rol', usuario.rol ?? ''],
            ['Fecha generación', fechaGeneracion, 'Hora generación', horaGeneracion]
        ];

        informacion.forEach((fila, index) => {

            const row = worksheet.getRow(6 + index);

            row.values = [
                fila[0],
                fila[1],
                fila[2],
                fila[3]
            ];

            row.height = 21;

            aplicarEtiqueta(row.getCell(1));
            aplicarValor(row.getCell(2));

            aplicarEtiqueta(row.getCell(3));
            aplicarValor(row.getCell(4));

            row.getCell(5).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: BLANCO
                }
            };
        });

        worksheet.mergeCells('A10:E10');

        const resumenTitulo = worksheet.getCell('A10');

        resumenTitulo.value = 'RESUMEN DEL MOVIMIENTO';

        aplicarTituloSeccion(resumenTitulo, AZUL);


        const resumen = [
            {
                columna: 1,
                titulo: 'STOCK INICIAL',
                valor: totalStockInicial
            },
            {
                columna: 2,
                titulo: 'ENTRADAS',
                valor: totalEntradas
            },
            {
                columna: 3,
                titulo: 'SALIDAS',
                valor: totalSalidas
            },
            {
                columna: 4,
                titulo: 'STOCK ACTUAL',
                valor: totalStockActual
            }
        ];

        resumen.forEach(item => {

            const col = item.columna;

            const tituloCelda = worksheet.getCell(11, col);

            tituloCelda.value = item.titulo;

            tituloCelda.font = {
                name: 'Arial',
                size: 9,
                bold: true,
                color: {
                    argb: '666666'
                }
            };

            tituloCelda.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: GRIS
                }
            };

            tituloCelda.alignment = {
                horizontal: 'center',
                vertical: 'middle'
            };

            const valorCelda = worksheet.getCell(12, col);

            valorCelda.value = item.valor;

            valorCelda.font = {
                name: 'Arial',
                size: 16,
                bold: true,
                color: {
                    argb: AZUL_OSCURO
                }
            };

            valorCelda.numFmt = '#,##0';

            valorCelda.alignment = {
                horizontal: 'center',
                vertical: 'middle'
            };

            valorCelda.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: BLANCO
                }
            };

            valorCelda.border = borde();
        });



        worksheet.getCell('E11').value =
            'PRODUCTOS CON STOCK';

        worksheet.getCell('E11').font = {
            name: 'Arial',
            size: 9,
            bold: true,
            color: {
                argb: '666666'
            }
        };

        worksheet.getCell('E11').alignment = {
            horizontal: 'center'
        };

        worksheet.getCell('E12').value =
            productosConStock;

        worksheet.getCell('E12').font = {
            name: 'Arial',
            size: 16,
            bold: true,
            color: {
                argb: VERDE
            }
        };

        worksheet.getCell('E12').alignment = {
            horizontal: 'center'
        };

        worksheet.getCell('E12').numFmt = '#,##0';

        worksheet.getCell('E12').border = borde();

        // ======================================================
        // DETALLE
        // ======================================================

        worksheet.mergeCells('A14:E14');

        const detalleTitulo = worksheet.getCell('A14');

        detalleTitulo.value = 'DETALLE DEL STOCK';

        aplicarTituloSeccion(detalleTitulo, AZUL);

        // ======================================================
        // ENCABEZADOS
        // ======================================================

        const encabezado = worksheet.getRow(15);

        encabezado.values = [
            'PRODUCTO',
            'STOCK INICIAL',
            'ENTRADAS',
            'SALIDAS',
            'STOCK ACTUAL'
        ];

        encabezado.height = 28;

        encabezado.eachCell(cell => {

            cell.font = {
                name: 'Arial',
                size: 10,
                bold: true,
                color: {
                    argb: BLANCO
                }
            };

            cell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: AZUL_OSCURO
                }
            };

            cell.alignment = {
                horizontal: 'center',
                vertical: 'middle',
                wrapText: true
            };

            cell.border = borde();
        });

        // ======================================================
        // PRODUCTOS
        // ======================================================

        productos.forEach((item, index) => {

            const rowNumber = 16 + index;

            const row = worksheet.getRow(rowNumber);

            row.values = [
                item.producto,
                item.stockInicial,
                item.entradas,
                item.salidas,
                item.stockActual
            ];

            row.height = 21;

            row.eachCell((cell, colNumber) => {

                cell.font = {
                    name: 'Arial',
                    size: 10,
                    color: {
                        argb: NEGRO
                    }
                };

                cell.border = borde();

                if (colNumber === 1) {

                    cell.alignment = {
                        horizontal: 'left',
                        vertical: 'middle'
                    };

                } else {

                    cell.alignment = {
                        horizontal: 'center',
                        vertical: 'middle'
                    };

                    cell.numFmt = '#,##0';
                }

                // Filas alternadas
                if (index % 2 === 1) {

                    cell.fill = {
                        type: 'pattern',
                        pattern: 'solid',
                        fgColor: {
                            argb: GRIS
                        }
                    };
                }
            });
        });

        // ======================================================
        // TOTAL
        // ======================================================

        const filaTotal = 16 + productos.length;

        const totalRow = worksheet.getRow(filaTotal);

        totalRow.values = [
            'TOTAL',
            totalStockInicial,
            totalEntradas,
            totalSalidas,
            totalStockActual
        ];

        totalRow.height = 25;

        totalRow.eachCell((cell, colNumber) => {

            cell.font = {
                name: 'Arial',
                size: 10,
                bold: true,
                color: {
                    argb: BLANCO
                }
            };

            cell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: AZUL_OSCURO
                }
            };

            cell.border = borde();

            cell.alignment = {
                horizontal: colNumber === 1
                    ? 'left'
                    : 'center',
                vertical: 'middle'
            };

            if (colNumber > 1) {
                cell.numFmt = '#,##0';
            }
        });

        // ======================================================
        // FILTRO
        // ======================================================

        worksheet.autoFilter = {
            from: 'A15',
            to: `E${filaTotal - 1}`
        };

        // ======================================================
        // CONGELAR ENCABEZADO
        // ======================================================

        worksheet.views = [
            {
                state: 'frozen',
                ySplit: 15
            }
        ];

        // ======================================================
        // CONFIGURACIÓN DE IMPRESIÓN
        // ======================================================

        worksheet.pageSetup = {
            orientation: 'landscape',
            paperSize: 9,
            fitToPage: true,
            fitToWidth: 1,
            fitToHeight: 0,
            horizontalDpi: 300,
            verticalDpi: 300
        };

        worksheet.pageMargins = {
            left: 0.25,
            right: 0.25,
            top: 0.5,
            bottom: 0.5,
            header: 0.2,
            footer: 0.2
        };

        // ======================================================
        // ENCABEZADO DE IMPRESIÓN
        // ======================================================

        worksheet.headerFooter.oddHeader =
            '&L&S.N.E&RReporte de Stock';

        worksheet.headerFooter.oddFooter =
            '&LGenerado por: ' +
            nombreUsuario +
            '&RPágina &P de &N';

        // ======================================================
        // HOJA RESUMEN
        // ======================================================

        const resumenSheet = workbook.addWorksheet(
            'Resumen'
        );

        resumenSheet.columns = [
            {
                width: 32
            },
            {
                width: 20
            }
        ];

        resumenSheet.mergeCells('A1:B1');

        const resumenHeader =
            resumenSheet.getCell('A1');

        resumenHeader.value = 'RESUMEN DE STOCK';

        resumenHeader.font = {
            name: 'Arial',
            size: 20,
            bold: true,
            color: {
                argb: BLANCO
            }
        };

        resumenHeader.fill = {
            type: 'pattern',
            pattern: 'solid',
            fgColor: {
                argb: AZUL_OSCURO
            }
        };

        resumenHeader.alignment = {
            horizontal: 'center',
            vertical: 'middle'
        };

        resumenSheet.getRow(1).height = 35;

        resumenSheet.getCell('A3').value = 'Indicador';
        resumenSheet.getCell('B3').value = 'Cantidad';

        ['A3', 'B3'].forEach(celda => {

            resumenSheet.getCell(celda).font = {
                bold: true,
                color: {
                    argb: BLANCO
                }
            };

            resumenSheet.getCell(celda).fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: AZUL
                }
            };

            resumenSheet.getCell(celda).alignment = {
                horizontal: 'center'
            };
        });

        const indicadores = [
            ['Stock inicial', totalStockInicial],
            ['Entradas', totalEntradas],
            ['Salidas', totalSalidas],
            ['Stock actual', totalStockActual],
            ['Productos con stock', productosConStock]
        ];

        indicadores.forEach((item, index) => {

            const row = 4 + index;

            resumenSheet.getCell(`A${row}`).value =
                item[0];

            resumenSheet.getCell(`B${row}`).value =
                item[1];

            resumenSheet.getCell(`B${row}`).numFmt =
                '#,##0';

            resumenSheet.getCell(`B${row}`).alignment = {
                horizontal: 'center'
            };

            resumenSheet.getCell(`A${row}`).border =
                borde();

            resumenSheet.getCell(`B${row}`).border =
                borde();
        });

        // ======================================================
        // FUNCIONES AUXILIARES
        // ======================================================

        function borde() {
            return {
                top: {
                    style: 'thin',
                    color: {
                        argb: GRIS_BORDE
                    }
                },
                bottom: {
                    style: 'thin',
                    color: {
                        argb: GRIS_BORDE
                    }
                },
                left: {
                    style: 'thin',
                    color: {
                        argb: GRIS_BORDE
                    }
                },
                right: {
                    style: 'thin',
                    color: {
                        argb: GRIS_BORDE
                    }
                }
            };
        }

        function aplicarTituloSeccion(cell, color) {

            cell.font = {
                name: 'Arial',
                size: 10,
                bold: true,
                color: {
                    argb: BLANCO
                }
            };

            cell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: color
                }
            };

            cell.alignment = {
                horizontal: 'left',
                vertical: 'middle'
            };

            cell.border = borde();
        }

        function aplicarEtiqueta(cell) {

            cell.font = {
                name: 'Arial',
                size: 9,
                bold: true,
                color: {
                    argb: '44546A'
                }
            };

            cell.fill = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: AZUL_CLARO
                }
            };

            cell.alignment = {
                vertical: 'middle'
            };

            cell.border = borde();
        }

        function aplicarValor(cell) {

            cell.font = {
                name: 'Arial',
                size: 9,
                color: {
                    argb: NEGRO
                }
            };

            cell.alignment = {
                vertical: 'middle'
            };

            cell.border = borde();
        }

    
        const buffer = await workbook.xlsx.writeBuffer();

        const blob = new Blob(
            [buffer],
            {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            }
        );

        const url = URL.createObjectURL(blob);

        const link = document.createElement('a');

        link.href = url;

        link.download =
            `Reporte_de_stock_${desde}_${hasta}.xlsx`;

        document.body.appendChild(link);

        link.click();

        document.body.removeChild(link);

        URL.revokeObjectURL(url);

    } catch (error) {

        console.error(
            'Error al generar el reporte:',
            error
        );

        alert(
            error.message ||
            'Ocurrió un error al generar el reporte.'
        );
    }
});
