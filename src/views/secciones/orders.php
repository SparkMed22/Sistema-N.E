<?php
$title = "Gestión de Pedidos | H.G.I";
require __DIR__ . '/../../utils/head.php';
?>

<body class="bg-background text-on-surface min-h-screen font-sans">

    <?php require __DIR__ . '/../../utils/header.php'; ?>


    <main class="pt-24 pb-10 max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">


        <header class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5 mb-8">
            <div>
                <div class="flex items-center gap-3">
                    <div class="w-11 h-11 rounded-xl bg-primary text-on-primary flex items-center justify-center">
                        <span class="material-symbols-outlined">prescriptions</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-secondary">Nutrición</p>
                        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface">Gestión de pedidos</h1>
                    </div>
                </div>
                <p class="text-sm text-on-surface-variant mt-4 max-w-xl">Administra, supervisa y procesa los pedidos nutricionales activos de los pacientes.</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <button type="button" onclick="window.location.reload()" class="h-11 px-4 rounded-xl bg-primary text-on-primary text-sm font-bold hover:bg-primary-container transition flex items-center gap-2">
                    <span class="material-symbols-outlined text-[19px]">refresh</span>Actualizar
                </button>
            </div>
        </header>


        <section class="mb-6 rounded-2xl border border-outline-variant/40 bg-surface p-4 sm:p-5">
            <div class="flex flex-col gap-3 xl:flex-row xl:items-center">

                <div class="relative flex-1">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">
                        search
                    </span>

                    <input id="bucar-receta" type="text" placeholder="Buscar por paciente, médico, sala..."
                        class=" h-11 w-full rounded-xl border border-outline-variant/50 bg-surface-container-lowest pl-10 pr-4 text-sm text-on-surface placeholder:text-on-surface-variant outline-none transition focus:border-primary focus:bg-surface focus:ring-4 focus:ring-primary-fixed/30" />
                </div>


                <div class="relative xl:w-64">
                    <span class="material-symbols-outlined pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-[19px] text-on-surface-variant">
                        business
                    </span>
                    <select
                        onchange="recetasFilterChange(this.value)"
                        id="opciones-servicio"
                        class="h-11 w-full appearance-none rounded-xl border border-outline-variant/50 bg-surface-container-lowest pl-10 pr-10 text-sm text-on-surface outline-none transition focus:border-primary focus:bg-surface focus:ring-4 focus:ring-primary-fixed/30">
                        <option value="0">Todos los servicios</option>
                        <option value="1">Polivalente</option>
                    </select>
                    <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[18px] text-on-surface-variant">
                        expand_more
                    </span>
                </div>
            </div>
        </section>


        <section id="contenedor-tarjetas-recetas" class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-5"></section>
    </main>

    <!-- SCRIPTS -->
    <script src="/assets/js/script.js" defer></script>
    <script src="/assets/js/orders.js" defer></script>

    <!-- POPOVER : RECHAZO DE RECETA/PEDIDO -->
    <div id="popover-cancelar-receta" popover="manual"
        class="m-auto w-full
        max-w-2xl overflow-hidden rounded-3xl border border-outline-variant/40
        bg-surface-container-lowest text-on-surface backdrop:bg-on-surface/40 backdrop:backdrop-blur-md">

        <div class=" flex items-center justify-between gap-4 border-b border-outline-variant/40 px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11
                    items-center justify-center rounded-2xl bg-error-container text-error">
                    <span class="material-symbols-outlined">cancel</span>
                </div>
                <div>
                    <h2 class="text-lg font-bold text-on-surface">Cancelar receta</h2>
                    <p class="text-sm text-on-surface-variant">Revise la información antes de cancelar la receta.</p>
                </div>
            </div>

            <button type="button" popovertarget="popover-cancelar-receta"
                popovertargetaction="hide"
                class="flex h-10 w-10 items-center justify-center
                rounded-xl text-on-surface-variant transition hover:bg-surface-container-high hover:text-on-surface">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>


        <form id="form-cancelar-receta" class="space-y-6 px-6 py-6">
            <input type="hidden" id="cancelar-receta-id" name="id_receta">
            <section class="rounded-2xl border border-outline-variant/40 bg-surface-container-low p-5">
                <div class="mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span>
                    <h3 class="text-sm font-bold text-on-surface">Información de la receta</h3>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant">Paciente</p>
                        <p id="cancelar-paciente" class="mt-1 text-sm font-semibold text-on-surface">-</p>

                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant"> Profesional</p>
                        <p id="cancelar-usuario" class="mt-1 text-sm font-semibold text-on-surface"></p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant">Servicio</p>
                        <p id="cancelar-servicio" class="mt-1 text-sm font-semibold text-on-surface"></p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant">Diagnóstico médico</p>
                        <p id="cancelar-diagnostico" class="mt-1 text-sm font-semibold text-on-surface"></p>
                    </div>
                </div>
                <div class=" mt-5 border-t border-outline-variant/40 pt-4">
                    <p class="text-xs font-medium text-on-surface-variant">Indicación nutricional</p>
                    <div id="cancelar-indicacion"
                        class=" mt-2 rounded-xl border border-outline-variant/40 bg-surface-container-lowest p-4 text-sm leading-relaxed text-on-surface"></div>
                </div>
            </section>
            <section class="space-y-3">

                <label for="cancelar-motivo-select" class=" flex items-center gap-2 text-sm font-bold text-on-surface">
                    <span class="material-symbols-outlined text-error text-[20px]"> edit_note</span>
                    Motivo de cancelación
                </label>
                <select id="cancelar-motivo-select" required
                    class=" w-full rounded-2xl border border-outline-variant/60 bg-surface-container-lowest p-4 text-sm text-on-surface outline-none transition-all focus:border-error focus:ring-2 focus:ring-error/20">
                    <option value="" disabled selected>Seleccione un motivo...</option>
                    <option value="Sin Stock disponible">Sin Stock disponible</option>
                    <option value="Error en la dosis/medicamento">Error en la dosis o medicamento</option>
                    <option value="Duplicación de receta">Receta duplicada</option>
                    <option value="Error tipografico">Error tipografico</option>
                    <option value="Cambio de tratamiento">Cambio de tratamiento médico</option>
                    <option value="Solicitud del paciente">Solicitud del paciente</option>
                </select>
                <p class="text-xs text-on-surface-variant">Este motivo quedará registrado en el historial de la receta.</p>
            </section>

            <div class=" flex gap-3 rounded-2xl border border-error/20 bg-error-container/50 p-4">
                <span class="material-symbols-outlined text-error">warning</span>
                <p class="text-xs leading-relaxed text-on-error-container">
                    Al cancelar esta receta, cambiará su estado y la operación
                    quedará registrada en el sistema.
                </p>
            </div>

            <div class="flex flex-col-reverse gap-3 border-t border-outline-variant/40 pt-5 sm:flex-row sm:justify-end">

                <button type="button" popovertarget="popover-cancelar-receta" popovertargetaction="hide"
                    class=" h-11 rounded-xl border border-outline-variant/60 px-5 text-sm font-semibold text-on-surface-variant">
                    Volver
                </button>

                <button type="submit"
                    class=" flex h-11 items-center justify-center gap-2 rounded-xl bg-error px-6 text-sm font-semibold text-on-error">
                    <span class="material-symbols-outlined text-[19px]"> cancel</span>
                    Cancelar receta
                </button>
            </div>
        </form>
    </div>

    <!-- POPOVER : PROSESAR RECETA/PEDIDO -->
    <div id="popover-procesar-receta" popover="manual" class="m-auto w-full max-w-3xl overflow-hidden rounded-3xl border border-outline-variant/40 bg-surface-container-lowest text-on-surface shadow-2xl backdrop:bg-on-surface/40 backdrop:backdrop-blur-md">
        <div class="flex items-center justify-between gap-4 border-b border-outline-variant/40 px-6 py-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-primary-container text-primary"><span class="material-symbols-outlined">inventory_2</span></div>
                <div>
                    <h2 class="text-lg font-bold text-on-surface">Procesar Pedido de Receta</h2>
                    <p class="text-sm text-on-surface-variant">Verifique los datos y agregue los productos a despachar.</p>
                </div>
            </div><button type="button" popovertarget="popover-procesar-receta" popovertargetaction="hide" class="flex h-10 w-10 items-center justify-center rounded-xl text-on-surface-variant transition hover:bg-surface-container-high hover:text-on-surface"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form id="form-procesar-receta" class="space-y-6 px-6 py-6"><input type="hidden" id="procesar-receta-id" name="id_receta"><input type="hidden" id="procesar-consulta-id" name="id_consulta">
            <section class="rounded-2xl border border-outline-variant/40 bg-surface-container-low p-5">
                <div class="mb-4 flex items-center gap-2"><span class="material-symbols-outlined text-primary">local_hospital</span>
                    <h3 class="text-sm font-bold text-on-surface">Información de Ubicación y Profesional</h3>
                </div>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-4">
                    <div class="sm:col-span-2">
                        <p class="text-xs font-medium text-on-surface-variant">Profesional</p>
                        <p id="procesar-usuario-nombre" class="mt-1 text-sm font-semibold text-on-surface">-</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant">Bloque</p>
                        <p id="procesar-bloque" class="mt-1 text-sm font-semibold text-on-surface">-</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-on-surface-variant">Sala / Cama</p>
                        <p class="mt-1 text-sm font-semibold text-on-surface">Sala: <span id="procesar-sala">-</span> | Cama: <span id="procesar-cama">-</span></p>
                    </div>
                </div>
                <div class="mt-4 border-t border-outline-variant/40 pt-3">
                    <p class="text-xs font-medium text-on-surface-variant">Diagnóstico médico</p>
                    <p id="procesar-diagnostico" class="mt-1 text-sm text-on-surface italic">-</p>
                </div>
            </section>
            <section class="space-y-3">
                <div class="flex items-center justify-between"><label class="flex items-center gap-2 text-sm font-bold text-on-surface"><span class="material-symbols-outlined text-primary text-[20px]">flatware</span>Productos / Insumos a enviar</label><button type="button" id="btn-agregar-producto" class="flex items-center gap-1.5 rounded-xl border border-primary/40 bg-primary-container/40 px-3 py-1.5 text-xs font-semibold text-primary transition hover:bg-primary-container"><span class="material-symbols-outlined text-[18px]">add</span>Agregar Producto</button></div>
                <div id="contenedor-productos" class="space-y-2"></div>
            </section>
            <div class="flex flex-col-reverse gap-3 border-t border-outline-variant/40 pt-5 sm:flex-row sm:justify-end"><button type="button" popovertarget="popover-procesar-receta" popovertargetaction="hide" class="h-11 rounded-xl border border-outline-variant/60 px-5 text-sm font-semibold text-on-surface-variant transition hover:bg-surface-container-high">Cancelar</button><button type="submit" class="flex h-11 items-center justify-center gap-2 rounded-xl bg-primary px-6 text-sm font-semibold text-on-primary shadow-sm transition hover:opacity-90 active:scale-[0.98]"><span class="material-symbols-outlined text-[19px]">check_circle</span>Procesar Pedido</button></div>
        </form>
    </div>
</body>

</html>