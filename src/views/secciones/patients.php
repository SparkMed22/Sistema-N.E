<?php
$title = "HGI - Pacientes";
require __DIR__ . '/../../utils/head.php';
?>

<body class="bg-background text-on-background font-body-md min-h-screen flex flex-col">

    <?php require __DIR__ . '/../../utils/header.php'; ?>

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-20 md:mt-24 pt-6 pb-12">


        <section class="mb-7">
            <div class="flex flex-col gap-4 rounded-2xl border border-outline-variant/60 bg-surface-container-lowest p-4 sm:flex-row sm:items-center">
                <div class="relative flex-1">

                    <span class="material-symbols-outlined pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-[21px] text-on-surface-variant">
                        search
                    </span>
                    <input
                        id="input_buscar_paciente"
                        type="search" placeholder="Buscar por nombre, apellido o cédula..." class="h-11 w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-12 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15">
                </div>
                <div
                    class="flex h-11 items-center justify-center gap-2 rounded-xl  px-4 text-sm font-medium text-on-surface-variant">
                    <button type="button" popovertarget="popover-ingresar-paciente" popovertargetaction="show" class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-primary px-5 text-sm font-semibold text-on-primary transition-all hover:bg-primary-container active:scale-[0.98]">
                        <span class="material-symbols-outlined text-[20px]">
                            person_add
                        </span>
                        Nuevo paciente
                    </button>
                </div>
            </div>
        </section>

        <!-- GRID DE PACIENTES -->
        <section>
            <div id="pacientes_grid" class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3"></div>
        </section>

    </main>

    <?php require __DIR__ . '/../../utils/footer.php'; ?>
    <script src="/assets/js/script.js" defer></script>
    <script src="/assets/js/patients.js" defer></script>
    <script src="/assets/js/recetas.js" defer></script>


    <!-- POPOVER: Consulta -->
    <div id="popover-ubicacion-dx" popover="manual"
        class=" w-full max-w-2xl overflow-hidden rounded-3xl
        border border-outline-variant bg-surface-container-lowest text-on-surface backdrop:bg-on-surface/40 backdrop:backdrop-blur-md transition-all">


        <div class="flex items-center justify-between border-b border-outline-variant/40 bg-surface-container-lowest px-7 py-5">
            <div class="flex items-center gap-3.5">
                <!-- Icono -->
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl border border-outline-variant/60 bg-primary-fixed text-primary">
                    <span class="material-symbols-outlined text-[24px]">
                        domain
                    </span>
                </div>

                <div>
                    <h3 class="text-lg font-bold tracking-tight text-on-surface">Ubicación y Diagnóstico</h3>
                    <p class="text-xs font-medium text-on-surface-variant"> Actualiza la ubicación del paciente y consulta el diagnóstico.</p>
                </div>
            </div>

            <button type="button" popovertarget="popover-ubicacion-dx" popovertargetaction="hide" aria-label="Cerrar"
                class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-full text-on-surface-variant transition-all hover:bg-surface-container-high hover:text-on-surface active:scale-95">
                <span class="material-symbols-outlined text-[20px]">
                    close
                </span>
            </button>
        </div>


        <form id="form-ubicacion-dx" class="px-7 py-6 space-y-6">
            <input type="hidden" id="edit-paciente-consulta" name="id_consulta">
            <section
                class=" relative overflow-hidden rounded-2xl border border-outline-variant border-l-4 border-l-primary bg-primary-fixed p-5">
                <div class="flex items-center gap-2 mb-3">
                    <span class=" material-symbols-outlined text-primary text-[20px]">
                        medical_information
                    </span>
                    <span class=" text-xs font-bold uppercase tracking-wider text-primary">
                        Diagnóstico Médico Actual
                    </span>
                </div>
                <label for="edit-diagnostico" class="sr-only">
                    Diagnóstico Médico
                </label>

                <textarea readonly id="edit-diagnostico" name="diagnostico_medico" rows="3" placeholder="Sin diagnóstico médico registrado"
                    class=" w-full resize-none border-0 bg-transparent p-0 text-sm font-normal text-on-primary-fixed outline-none cursor-default placeholder:text-on-primary-fixed-variant focus:ring-0"></textarea>
            </section>

            <section class="space-y-3.5">
                <div class="flex items-center gap-2">
                    <span class=" material-symbols-outlined text-[20px] text-primary">location_on</span>
                    <h4 class=" text-sm font-bold text-on-surface"> Ubicación del paciente</h4>
                </div>

                <div class="rounded-2xl border border-outline-variant bg-surface-container-low p-5">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                        <div class="flex flex-col gap-1.5">
                            <label for="edit-bloque" class="text-xs font-semibold text-on-surface-variant">Bloque</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[18px] text-on-surface-variant">
                                    domain
                                </span>
                                <select id="edit-bloque" name="bloque" required
                                    class=" h-11 w-full cursor-pointer appearance-none rounded-xl border border-outline-variant bg-surface-container-lowest py-2 pl-10 pr-9 text-sm font-medium text-on-surface outline-none transition-all hover:border-outline focus:border-primary focus:ring-2 focus:ring-primary/20">
                                    <option value="">Seleccionar...</option>
                                    <option value="Bloque A">Bloque A</option>
                                    <option value="Bloque B">Bloque B </option>
                                    <option value="Bloque C">Bloque C </option>
                                    <option value="Bloque D">Bloque D</option>
                                </select>
                                <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">
                                    expand_more
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <label for="edit-sala" class=" text-xs font-semibold text-on-surface-variant"> Sala</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[18px] text-on-surface-variant">meeting_room</span>
                                <input id="edit-sala" name="sala" type="text" placeholder="Ej. 12" required
                                    class=" h-11 w-full rounded-xl border border-outline-variant bg-surface-container-lowest py-2 pl-10 pr-3.5 text-sm font-medium text-on-surface outline-none transition-all placeholder:text-on-surface-variant/50 hover:border-outline focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label for="edit-cama" class=" text-xs font-semibold text-on-surface-variant"> Cama</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-[18px] text-on-surface-variant">bed</span>

                                <input
                                    id="edit-cama"
                                    name="cama"
                                    type="text"
                                    placeholder="Ej. 3"
                                    required
                                    class=" h-11 w-full rounded-xl border border-outline-variant bg-surface-container-lowest py-2 pl-10 pr-3.5 text-sm font-medium text-on-surface outline-none transition-all placeholder:text-on-surface-variant/50 hover:border-outline focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <div class=" pt-2 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <!-- Cancelar -->
                <button
                    type="button"
                    popovertarget="popover-ubicacion-dx"
                    popovertargetaction="hide"
                    class=" h-11 cursor-pointer rounded-xl border border-outline-variant bg-surface-container-lowest px-5 text-sm font-semibold text-on-surface-variant transition-all hover:bg-surface-container-high hover:text-on-surface active:scale-95">Cancelar</button>

                <button
                    type="submit"
                    class=" flex h-11 cursor-pointer items-center justify-center gap-2 rounded-xl bg-primary px-6 text-sm font-semibold text-on-primary transition-all hover:bg-primary-container active:scale-95">
                    <span class=" material-symbols-outlined text-[18px]">save</span>
                    Guardar cambios
                </button>
            </div>
        </form>
    </div>

    <!-- POPOVER: INGRESAR PACIENTE -->
    <div id="popover-ingresar-paciente"
        popover="manual" class="w-[calc(100%-2rem)] max-w-2xl overflow-hidden rounded-2xl border border-outline-variant/60 bg-surface-container-lowest text-on-surface  backdrop:bg-on-surface/50 backdrop:backdrop-blur-sm">

        <div class="flex items-center justify-between border-b border-outline-variant/60 px-6 py-5">

            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-container text-on-primary">
                    <span class="material-symbols-outlined text-[22px]">
                        person_add
                    </span>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-on-surface">
                        Ingresar paciente
                    </h3>

                    <p class="mt-0.5 text-sm text-on-surface-variant">
                        Registra el ingreso del paciente al servicio.
                    </p>
                </div>

            </div>

            <button type="button" popovertarget="popover-ingresar-paciente" popovertargetaction="hide" aria-label="Cerrar" class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-full text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-on-surface">
                <span class="material-symbols-outlined text-[20px]">
                    close
                </span>
            </button>

        </div>

        <form id="form-ingresar-paciente" class="px-6 py-6">

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">

                <div class="flex flex-col gap-2 sm:col-span-3">
                    <label for="ingreso-cedula" class="text-sm font-medium text-on-surface">Cédula de identidad</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">id_card</span>
                        <input id="ingreso-cedula" name="cedula" type="text" autocomplete="off" placeholder="Ej. 4567890" required
                            class="h-11 w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15">
                    </div>
                </div>

                <div class="flex flex-col gap-2 sm:col-span-1">
                    <label for="ingreso-bloque" class="text-sm font-medium text-on-surface">Bloque</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">domain</span>
                        <select id="ingreso-bloque" name="bloque" required
                            class="h-11 w-full cursor-pointer appearance-none rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-10 text-sm text-on-surface outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15">
                            <option value="">Seleccionar bloque...</option>
                            <option value="Bloque A">Bloque A</option>
                            <option value="Bloque B">Bloque B</option>
                            <option value="Bloque C">Bloque C</option>
                            <option value="Bloque D">Bloque D</option>
                        </select>
                        <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">expand_more</span>
                    </div>
                </div>

                <div class="flex flex-col gap-2 sm:col-span-1">
                    <label for="ingreso-sala" class="text-sm font-medium text-on-surface">Sala</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">meeting_room</span>
                        <input id="ingreso-sala" name="sala" type="number" min="1" placeholder="Ej. 12" required
                            class="h-11 w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15">
                    </div>
                </div>

                <div class="flex flex-col gap-2 sm:col-span-1">
                    <label for="ingreso-cama" class="text-sm font-medium text-on-surface">Cama</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">bed</span>
                        <input id="ingreso-cama" name="cama" type="number" min="1" placeholder="Ej. 3" required
                            class="h-11 w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15">
                    </div>
                </div>

                <div class="flex flex-col gap-2 sm:col-span-3">
                    <label for="ingreso-servicio" class="text-sm font-medium text-on-surface">Servicio</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">medical_services</span>
                        <select id="ingreso-servicio" name="servicio" required
                            class="h-11 w-full cursor-pointer appearance-none rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-10 text-sm text-on-surface outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15">
                        </select>
                        <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">expand_more</span>
                    </div>
                </div>

                <!-- Nuevo Campo: Diagnóstico Médico (Obligatorio) -->
                <div class="flex flex-col gap-2 sm:col-span-3">
                    <label for="ingreso-diagnostico" class="text-sm font-medium text-on-surface">Diagnóstico Médico</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-3 text-[20px] text-on-surface-variant">health_and_safety</span>
                        <textarea id="ingreso-diagnostico" name="diagnostico_medico" rows="3" required
                            placeholder="Ingrese el diagnóstico médico detallado..."
                            class="w-full resize-none rounded-xl border border-outline-variant bg-surface-container-low py-3 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15"></textarea>
                    </div>
                </div>

                <div class="flex flex-col gap-2 sm:col-span-3">
                    <div class="flex items-center justify-between">
                        <label for="ingreso-observaciones-egreso" class="text-sm font-medium text-on-surface">Observaciones de egreso</label>
                        <span class="text-xs text-on-surface-variant">Opcional</span>
                    </div>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-3 text-[20px] text-on-surface-variant">notes</span>
                        <textarea id="ingreso-observaciones-egreso" name="observaciones_egreso" rows="4" maxlength="500"
                            placeholder="Ingrese observaciones relacionadas con el egreso del paciente..."
                            class="w-full resize-none rounded-xl border border-outline-variant bg-surface-container-low py-3 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15"></textarea>
                    </div>
                    <p class="text-xs text-on-surface-variant">Máximo 500 caracteres.</p>
                </div>

            </div>

            <div class="mt-7 flex flex-col-reverse gap-3 border-t border-outline-variant/60 pt-5 sm:flex-row sm:justify-end">
                <button type="button" popovertarget="popover-ingresar-paciente" popovertargetaction="hide"
                    class="h-10 cursor-pointer rounded-xl border border-outline-variant px-5 text-sm font-medium text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface">
                    Cancelar
                </button>
                <button type="submit"
                    class="flex h-10 cursor-pointer items-center justify-center gap-2 rounded-xl bg-primary px-5 text-sm font-semibold text-on-primary transition-all hover:bg-primary-container active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[19px]">save</span>
                    Registrar ingreso
                </button>
            </div>

        </form>
    </div>

    <!-- POPOVER: Reasignar -->
    <div id="popover-reasignar" popover="manual" class="m-auto border-0 bg-transparent p-0 backdrop:bg-slate-900/50 backdrop:backdrop-blur-sm">
        <div class="w-80 max-w-sm rounded-xl border border-outline-variant bg-surface p-5 text-on-surface">

            <div class="mb-4">
                <h3 class="text-base font-semibold text-on-surface"> Reasignar servicio</h3>
                <p class="mt-1 text-xs text-on-surface-variant"> Selecciona el servicio que continuará con esta consulta.</p>
            </div>

            <label for="servicio-select" class="mb-1 block text-xs font-medium text-on-surface-variant">
                Nuevo Servicio
            </label>


            <form id="form-reasignar-paciente">

                <input type="hidden" id="id-consulta-reasignar" name="consulta_id" value="">

                <select id="servicio-select" name="servicio_id"
                    class="w-full rounded-lg border border-outline bg-surface-container-lowest px-3 py-2 text-sm text-on-surface outline-none transition focus:border-primary focus:ring-2 focus:ring-primary-container">
                    <option value=""> Seleccionar Servicio </option>
                </select>

                <div class="mt-5 flex justify-end gap-2">

                    <button
                        type="button"
                        popovertarget="popover-reasignar"
                        popovertargetaction="hide"
                        class="rounded-lg px-3.5 py-2 text-sm font-medium text-on-surface-variant transition hover:bg-surface-container-high">
                        Cancelar
                    </button>

                    <button
                        type="submit"
                        class="rounded-lg bg-primary px-3.5 py-2 text-sm font-medium text-on-primary transition hover:bg-primary-container">
                        Reasignar
                    </button>

                </div>

            </form>
        </div>
    </div>

    <!-- POPOVER: Editar Paciente -->
    <div id="popover-editar-paciente" popover="manual"
        class=" max-w-2xl overflow-hidden rounded-2xl border border-outline-variant/60 bg-surface-container-lowest text-on-surface  backdrop:bg-on-surface/50 backdrop:backdrop-blur-sm">

        <div class="flex items-center justify-between border-b border-outline-variant/60 px-6 py-5">
            <div class="flex items-center gap-3">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-xl bg-secondary-container text-on-secondary-container">
                    <span class="material-symbols-outlined text-[22px]">
                        manage_accounts
                    </span>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-on-surface"> Editar paciente</h3>

                    <p class="mt-0.5 text-sm text-on-surface-variant"> Actualiza los datos permitidos del paciente.</p>
                </div>
            </div>

            <button type="button" popovertarget="popover-editar-paciente"
                popovertargetaction="hide" aria-label="Cerrar"
                class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-full text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-on-surface">
                <span class="material-symbols-outlined text-[20px]"> close</span>
            </button>
        </div>
        <form id="form-editar-paciente" class="px-6 py-6">
            <input type="hidden" id="edit-paciente-id" name="id">
            <section class="space-y-4">

                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px] text-primary">
                        person
                    </span>

                    <h4 class="text-sm font-semibold text-on-surface">
                        Datos personales
                    </h4>
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                    <!-- Nombre -->
                    <div class="flex flex-col gap-2">
                        <label
                            for="edit-paciente-nombre"
                            class="text-sm font-medium text-on-surface">
                            Nombre
                        </label>

                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">
                                person
                            </span>

                            <input
                                id="edit-paciente-nombre"
                                name="nombre"
                                type="text"
                                maxlength="50"
                                autocomplete="off"
                                required
                                class="h-11 w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15">
                        </div>
                    </div>

                    <!-- Apellido -->
                    <div class="flex flex-col gap-2">
                        <label
                            for="edit-paciente-apellido"
                            class="text-sm font-medium text-on-surface">
                            Apellido
                        </label>

                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">
                                badge
                            </span>

                            <input
                                id="edit-paciente-apellido"
                                name="apellido"
                                type="text"
                                maxlength="50"
                                autocomplete="off"
                                required
                                class="h-11 w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15">
                        </div>
                    </div>

                    <!-- Teléfono (Nuevo Campo) -->
                    <div class="flex flex-col gap-2">
                        <label
                            for="edit-paciente-telefono"
                            class="text-sm font-medium text-on-surface">
                            Teléfono
                        </label>

                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">
                                call
                            </span>

                            <input
                                id="edit-paciente-telefono"
                                name="telefono"
                                type="tel"
                                maxlength="20"
                                autocomplete="off"
                                placeholder="Ej. 0981 123456"
                                class="h-11 w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15">
                        </div>
                    </div>

                    <!-- Sexo -->
                    <div class="flex flex-col gap-2">
                        <label
                            for="edit-paciente-sexo"
                            class="text-sm font-medium text-on-surface">
                            Sexo
                        </label>

                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">
                                wc
                            </span>

                            <select
                                id="edit-paciente-sexo"
                                name="sexo"
                                required
                                class="h-11 w-full cursor-pointer appearance-none rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-10 text-sm text-on-surface outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15">

                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                                <option value="INDEFINIDO">No definido</option>

                            </select>

                            <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">
                                expand_more
                            </span>
                        </div>
                    </div>

                    <!-- Fecha de nacimiento -->
                    <div class="flex flex-col gap-2 sm:col-span-2">
                        <label
                            for="edit-paciente-fecha"
                            class="text-sm font-medium text-on-surface">
                            Fecha de nacimiento
                        </label>

                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">
                                event
                            </span>

                            <input
                                id="edit-paciente-fecha"
                                name="fecha_nacimiento"
                                type="date"
                                required
                                class="h-11 w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15">
                        </div>
                    </div>
                </div>
            </section>

            <div class="mt-7 flex flex-col-reverse gap-3 border-t border-outline-variant/60 pt-5 sm:flex-row sm:justify-end">

                <button
                    type="button"
                    popovertarget="popover-editar-paciente"
                    popovertargetaction="hide"
                    class="h-10 cursor-pointer rounded-xl border border-outline-variant px-5 text-sm font-medium text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface">
                    Cancelar
                </button>

                <button
                    type="submit"
                    class="flex h-10 cursor-pointer items-center justify-center gap-2 rounded-xl bg-primary px-5 text-sm font-semibold text-on-primary transition-all hover:bg-primary-container active:scale-[0.98]">

                    <span class="material-symbols-outlined text-[19px]">
                        save
                    </span>

                    Guardar cambios

                </button>

            </div>
        </form>
    </div>

    <!-- POPOVER: Recetas -->
    <div id="popover-receta" popover="manual"
        class="bg-surface-container-lowest text-on-surface rounded-2xl border border-outline-variant w-full max-w-2xl p-6 backdrop:bg-on-background/40 my-auto mx-auto">

        <div class="flex justify-between items-center pb-4 mb-4 border-b border-surface-variant">
            <div>
                <h2 class="text-xl font-bold text-primary">Cargar Receta Nutricional</h2>
                <p class="text-xs text-on-surface-variant mt-0.5">Ingresa los detalles clínicos e indicaciones del paciente</p>
            </div>
            <button
                onclick="document.getElementById('popover-receta').hidePopover()"
                class="text-on-surface-variant hover:text-error transition p-1.5 rounded-lg hover:bg-surface-container-low">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form class="space-y-4" id="form-receta-paciente">
            <input type="hidden" id="consulta-id" name="id">

            <div>
                <label for="indicacion-nutricional" class="block text-xs font-semibold text-on-surface-variant uppercase mb-1">
                    Indicación Nutricional *
                </label>
                <textarea id="indicacion-nutricional" name="indicacion_nutricional" required rows="2"
                    placeholder="Detalle de prescripción dietética..."
                    class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-outline focus:ring-1 focus:ring-outline transition"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                    <label for="medida-porcion" class="block text-xs font-semibold text-on-surface-variant uppercase mb-1">
                        Medida Porción
                    </label>
                    <input type="text" id="medida-porcion" name="medida_porcion" placeholder="Ej: 200g"
                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-outline focus:ring-1 focus:ring-outline transition">
                </div>
                <div>
                    <label for="aporte-liquido" class="block text-xs font-semibold text-on-surface-variant uppercase mb-1">
                        Aporte Líquido
                    </label>
                    <input type="text" id="aporte-liquido" name="aporte_liquido" placeholder="Ej: 1500 ml/día"
                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-outline focus:ring-1 focus:ring-outline transition">
                </div>
                <div>
                    <label for="volumen-total" class="block text-xs font-semibold text-on-surface-variant uppercase mb-1">
                        Volumen Total
                    </label>
                    <input type="text" id="volumen-total" name="volumen_total" placeholder="Ej: 2000 ml"
                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-outline focus:ring-1 focus:ring-outline transition">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-surface-variant mt-6">
                <button type="button" id="btn-cancelar-receta"
                    onclick="document.getElementById('popover-receta').hidePopover()"
                    class="px-4 py-2 text-sm font-medium text-on-surface-variant hover:bg-surface-container-high rounded-lg transition">
                    Cancelar
                </button>
                <button type="submit" id="btn-guardar-receta"
                    class="px-5 py-2 text-sm font-medium bg-primary hover:bg-tertiary text-on-primary rounded-lg">
                    Guardar Receta
                </button>
            </div>
        </form>
    </div>


    <div id="modal-recetas" popover="manual"
        class=" m-auto w-full max-w-3xl overflow-hidden
        rounded-3xl border border-outline-variant bg-surface-container-lowest text-on-surface backdrop:bg-on-surface/40 backdrop:backdrop-blur-md">

        <input type="hidden" id="consulta_recetas_modal" name="id">

        <div class=" flex items-start justify-between gap-4 border-b border-outline-variant px-6 py-5">

            

            <div class="flex items-center gap-3">

                <div
                    class="
                    flex
                    h-11
                    w-11
                    items-center
                    justify-center
                    rounded-2xl
                    bg-primary-fixed
                    text-primary
                ">
                    <span class="material-symbols-outlined">
                        description
                    </span>
                </div>

                <div>

                    <h2 class="text-lg font-bold text-on-surface">
                        Recetas del paciente
                    </h2>

                    <p
                        id="modal-recetas-paciente"
                        class="text-sm text-on-surface-variant">
                        Seleccione una receta para enviar.
                    </p>

                </div>

            </div>


            <button
                type="button"
                popovertarget="modal-recetas"
                popovertargetaction="hide"
                class="
                flex
                h-10
                w-10
                items-center
                justify-center
                rounded-xl
                text-on-surface-variant
                transition-colors
                hover:bg-surface-container-high
                hover:text-on-surface
            ">

                <span class="material-symbols-outlined">
                    close
                </span>

            </button>

        </div>

        <div id="contenedor-recetas" class=" max-h-[60vh] space-y-3 overflow-y-auto p-6"></div>

        <div class="flex flex-col-reverse gap-3 border-t border-outline-variant bg-surface-container-low px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

            <p id="receta-seleccionada-texto" class="text-sm text-on-surface-variant">Ninguna receta seleccionada</p>

            <div class="flex gap-3">
                <button type="button" popovertarget="modal-recetas" popovertargetaction="hide"
                    class=" rounded-xl border border-outline-variant
                    bg-surface-container-lowest px-5 py-3 text-sm font-semibold text-on-surface transition-colors hover:bg-surface-container-high">
                    Cancelar
                </button>


                <button
                    id="btn-enviar-receta"
                    type="button"
                    disabled
                    class="flex items-center justify-center gap-2 rounded-xl bg-primary
                    px-5 py-3 text-sm font-semibold text-on-primary transition-all disabled:cursor-not-allowed disabled:opacity-50 hover:bg-primary-container">

                    <span class="material-symbols-outlined text-[20px]">
                        send
                    </span>

                    Enviar receta

                </button>

            </div>

        </div>

    </div>

</body>

</html>