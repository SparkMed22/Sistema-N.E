<?php
$title = "HGI - Usuarios";
require __DIR__ . '/../../utils/head.php';

$usuarios_id = $_SESSION['user_id'];
$usuarios_rol = $_SESSION['user_rol'];
$usuarios = $_SESSION['user_nombre'] ?? 'Personal de Guardia';
?>

<body class="bg-background text-on-background font-body-md min-h-screen flex flex-col">

    <?php require __DIR__ . '/../../utils/header.php'; ?>

    <main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 mt-24">

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

                <!-- // TODO: CARGAR DINAMICAMENTE -->
                <div class="flex flex-col gap-2 sm:col-span-3">
                    <label for="ingreso-servicio" class="text-sm font-medium text-on-surface">Servicio</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">medical_services</span>
                        <select id="ingreso-servicio" name="servicio" required
                            class="h-11 w-full cursor-pointer appearance-none rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-10 text-sm text-on-surface outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15">
                            <option value="">Seleccionar servicio...</option>
                            <option value="1">Clínica Médica</option>
                            <option value="2">Cirugía y Traumatología</option>
                            <option value="3">Ginecología</option>
                            <option value="4">Pediatría</option>
                            <option value="5">UTI Adultos</option>
                            <option value="6">Urgencia Clínica Médica</option>
                            <option value="7">Urgencia Cirugía y Traumatología</option>
                            <option value="8">Urgencia Ginecología</option>
                            <option value="9">Urgencia Pediatría</option>
                        </select>
                        <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">expand_more</span>
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
        <div class="w-80 max-w-sm rounded-xl border border-outline-variant bg-surface p-5 shadow-2xl text-on-surface">

            <div class="mb-4">
                <h3 class="text-base font-semibold text-on-surface"> Reasignar profesional</h3>
                <p class="mt-1 text-xs text-on-surface-variant"> Selecciona el profesional que continuará con esta consulta.</p>
            </div>

            <div class="mb-4 rounded-lg bg-surface-container-low p-3">
                <p class="text-xs text-on-surface-variant">Profesional actual</p>
                <p class="mt-1 text-sm font-medium text-on-surface" id="current-prof-name"></p>
            </div>

            <!-- Seleccionar profesional -->
            <label for="profesional-select" class="mb-1 block text-xs font-medium text-on-surface-variant">
                Nuevo profesional
            </label>


            <form id="form-reasignar-paciente">

                <input
                    type="hidden"
                    id="id-consulta-reasignar"
                    name="consulta_id"
                    value="">

                <select
                    id="profesional-select"
                    name="profesional_id"
                    class="w-full rounded-lg border border-outline bg-surface-container-lowest px-3 py-2 text-sm text-on-surface outline-none transition focus:border-primary focus:ring-2 focus:ring-primary-container">

                    <option value="">
                        Seleccionar profesional
                    </option>

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
        class=" max-w-2xl overflow-hidden rounded-2xl border border-outline-variant/60 bg-surface-container-lowest text-on-surface shadow-xl backdrop:bg-on-surface/50 backdrop:backdrop-blur-sm">

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

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

                <div class="flex flex-col gap-2">
                    <label for="edit-paciente-nombre" class="text-sm font-medium text-on-surface">
                        Nombre
                    </label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant"> person</span>
                        <input id="edit-paciente-nombre" name="nombre"
                            type="text" maxlength="50" autocomplete="off" required
                            class="h-11 w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15">
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="edit-paciente-apellido" class="text-sm font-medium text-on-surface">
                        Apellido
                    </label>

                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">
                            badge
                        </span>

                        <input id="edit-paciente-apellido" name="apellido" type="text"
                            maxlength="50"
                            autocomplete="off"
                            required
                            class="h-11 w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15">
                    </div>
                </div>

                <div class="flex flex-col gap-2 sm:col-span-2">

                    <label
                        for="edit-paciente-sexo"
                        class="text-sm font-medium text-on-surface">
                        Sexo
                    </label>

                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">wc</span>

                        <select id="edit-paciente-sexo" name="sexo" required
                            class="h-11 w-full cursor-pointer appearance-none rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-10 text-sm text-on-surface outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15">
                            <option value="M"> Masculino</option>
                            <option value="F"> Femenino</option>
                            <option value="INDEFINIDO"> No definido</option>
                        </select>
                        <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">
                            expand_more
                        </span>
                    </div>
                </div>
            </div>


            <!-- Footer -->
            <div
                class="mt-7 flex flex-col-reverse gap-3 border-t border-outline-variant/60 pt-5 sm:flex-row sm:justify-end">

                <!-- Cancelar -->
                <button
                    type="button"
                    popovertarget="popover-editar-paciente"
                    popovertargetaction="hide"
                    class="h-10 cursor-pointer rounded-xl border border-outline-variant px-5 text-sm font-medium text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface">
                    Cancelar
                </button>


                <!-- Guardar -->
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


</body>

</html>