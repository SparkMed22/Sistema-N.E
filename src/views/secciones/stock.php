<?php
$title = "Gestión de Inventario | Hospital General de Itapúa";
require __DIR__ . '/../../utils/head.php';
?>


<body class="bg-background text-on-surface min-h-screen font-sans">

    <?php require __DIR__ . '/../../utils/header.php'; ?>
    <main class="pt-24 pb-10 max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">

        <section class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-secondary"> Gestión hospitalaria</span>
                </div>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-primary">Inventario </h1>
                <p class="mt-2 text-sm sm:text-base text-on-surface-variant">Controle el stock y disponibilidad de suministros médicos. </p>
            </div>

            <button class="w-full sm:w-auto
                       flex items-center justify-center gap-2 bg-primary hover:bg-primary-container text-white
                       px-5 py-3 rounded-xl font-semibold transition"
                onclick="openModal('modal-new-item')">
                <span class="material-symbols-outlined">add</span> Nueva formula
            </button>
        </section>


        <section class="bg-white border border-outline-variant rounded-2xl p-4 mb-6">
            <div class="flex flex-col lg:flex-row gap-3">


                <!-- // TODO: Hacer funcinal el Buscardor -->
                <div class="relative flex-1">

                    <span class="material-symbols-outlined absolute
                               left-4 top-1/2 -translate-y-1/2 text-on-surface-variant">
                        search
                    </span>

                    <input id="input_buscar_prodcuto" type="text" placeholder="Buscar por nombre, código o descripción..."
                        class="w-full pl-11 pr-4 py-3
                               rounded-xl bg-surface-container-low border border-transparent outline-none">
                </div>


                <!-- // TODO: Hacer funcinal los filtros -->
                <select class="px-4 py-3 rounded-xl
                           bg-surface-container-low border border-transparent outline-none">
                    <option>Todos los estados</option>
                    <option>Disponible</option>
                    <option>Stock bajo</option>
                    <option>Stock crítico</option>
                </select>

                <button class="flex items-center justify-center gap-2
                           px-5 py-3
                           border border-outline-variant rounded-xl text-sm font-semibold">
                    <span class="material-symbols-outlined">tune</span>Filtros
                </button>
            </div>
        </section>


        <section class="bg-white border border-outline-variant rounded-2xl overflow-hidden">

            <div class="px-5 sm:px-6 py-5 border-b border-outline-variant flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-lg text-primary"> Artículos registrados</h2>
                    <p class="text-sm text-on-surface-variant mt-1">Administre y consulte el estado actual del inventario.</p>
                </div>
            </div>

            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr id="table-titulos" class="bg-surface-container-low border-b border-outline-variant text-xs uppercase tracking-wide text-on-surface-variant"></tr>
                    </thead>
                    <tbody id="table-productos" class="divide-y divide-outline-variant"></tbody>
                </table>
            </div>
        </section>

    </main>

    <?php require __DIR__ . '/../../utils/footer.php'; ?>
    <script src="/assets/js/script.js" defer></script>
    <script src="/assets/js/stock.js" defer></script>

    <!-- Modal utilizando Popover API Nativamente -->
    <div id="modal-new-item" popover="manual" class="m-auto p-0 bg-transparent backdrop:bg-black/40 backdrop:backdrop-blur-[2px] animate-[fadeIn_.2s_ease-out]">

        <div class="relative w-full max-w-lg bg-white rounded-2xl overflow-hidden">

            <div class="flex items-start justify-between px-6 py-5 border-b border-outline-variant">
                <div>
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-indigo-100 text-primary flex items-center justify-center">
                            <span class="material-symbols-outlined">inventory_2</span>
                        </div>

                        <div>
                            <h2 class="text-lg font-bold text-primary">Nuevo artículo</h2>
                            <p class="text-sm text-on-surface-variant mt-1"> Registre un nuevo artículo en el inventario.</p>
                        </div>
                    </div>
                </div>

                <button
                    id="btn-close-modal"
                    type="button"
                    popovertarget="modal-new-item"
                    popovertargetaction="hide"
                    class="w-9 h-9 rounded-lg flex items-center justify-center text-on-surface-variant hover:bg-surface-container-low hover:text-primary transition">
                    <span class="material-symbols-outlined">
                        close
                    </span>
                </button>
            </div>

            <form id="form-new-item" class="p-6">
                <div class="space-y-5">        
                    <div>
                        <label for="new-item-nombre" class="block text-sm font-semibold text-on-surface mb-2">
                            Nombre del artículo
                        </label>

                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant"> 
                                inventory
                            </span>
                            <input
                                id="new-item-nombre"
                                name="new-item-nombre" type="text" placeholder="Ej. Paracetamol 500mg" required
                                class="w-full pl-11 pr-4 py-3 rounded-xl bg-surface-container-low border border-transparent outline-none transition focus:border-secondary focus:ring-2 focus:ring-indigo-100">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        
                        <div>
                            <label for="new-item-cantidad-inicial" class="block text-sm font-semibold text-on-surface mb-2">
                                Cantidad inicial
                            </label>
                            <input
                                id="new-item-cantidad-inicial" name="new-item-cantidad-inicial" type="number"
                                min="0" value="0" required
                                class="w-full px-4 py-3 rounded-xl bg-surface-container-low border border-transparent outline-none transition focus:border-secondary focus:ring-2 focus:ring-indigo-100">
                        </div>
                        <div>
                            <label for="new-item-cantidad-minima" class="block text-sm font-semibold text-on-surface mb-2">
                                Cantidad mínima
                            </label>

                            <input id="new-item-cantidad-minima" name="new-item-cantidad-minima" type="number"
                                min="0" value="0" required 
                                class="w-full px-4 py-3 rounded-xl bg-surface-container-low border border-transparent outline-none transition focus:border-secondary focus:ring-2 focus:ring-indigo-100">
                        </div>
                    </div>
                    <div
                        class="flex gap-3 p-4 rounded-xl bg-indigo-50 border border-indigo-100">
                        <span class="material-symbols-outlined text-secondary">info</span>
                        <p class="text-xs leading-relaxed text-indigo-700">
                            El sistema utilizará la cantidad mínima para identificar automáticamente cuando el artículo tenga un nivel de stock bajo.
                        </p>
                    </div>
                </div>

                <div
                    class="flex flex-col-reverse sm:flex-row justify-end gap-3 mt-8 pt-5 border-t border-outline-variant">
                    <button
                        id="btn-cancel-modal"
                        type="button"
                        popovertarget="modal-new-item"
                        popovertargetaction="hide"
                        class="w-full sm:w-auto px-5 py-3 rounded-xl border border-outline-variant text-sm font-semibold hover:bg-surface-container-low transition">
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="w-full sm:w-auto flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-primary text-white text-sm font-semibold hover:bg-primary-container transition">
                        <span class="material-symbols-outlined text-[20px]">
                            save
                        </span>
                        Guardar artículo
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>