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
        <section class="bg-surface-container-lowest border border-outline-variant rounded-2xl p-4 mb-4">

            <div class="flex flex-col md:flex-row gap-3 md:items-center md:justify-between">

                <div class="relative w-full md:max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[21px]">
                        search
                    </span>
                    <input id="input_buscar_usuario" type="search" placeholder="Buscar usuario..." class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low border border-outline-variant rounded-xl text-sm text-on-surface placeholder:text-on-surface-variant outline-none focus:border-primary focus:ring-2 focus:ring-primary/10" />
                </div>

                <button
                    popovertarget="modal-nuevo-usuario"
                    type="button" class="inline-flex items-center justify-center gap-2 bg-primary text-on-primary px-5 py-3 rounded-xl font-semibold text-sm hover:bg-primary-container transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-primary/30">
                    <span class="material-symbols-outlined text-[20px]">
                        person_add
                    </span>
                    Nuevo usuario
                </button>
            </div>
        </section>

        <section class="bg-surface-container-lowest border border-outline-variant rounded-2xl overflow-hidden">

            <!-- Table header -->
            <div class="px-6 py-5 border-b border-outline-variant">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="font-bold text-base text-on-surface">
                            Personal registrado
                        </h2>
                        <p class="text-sm text-on-surface-variant mt-1">
                            Lista de usuarios del sistema.
                        </p>
                    </div>
                </div>
            </div>


            <div class="overflow-x-auto">
                <table class="w-full min-w-[850px] text-left">
                    <thead>
                        <tr id='table_tread' class="bg-surface-container-low"></tr>
                    </thead>

                    <!-- Cargar los usuarios de manera dinamica-->
                    <tbody id="users_table_body" class="divide-y divide-outline-variant">

                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-sm text-on-surface-variant">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="material-symbols-outlined animate-spin">
                                        progress_activity
                                    </span>
                                    Cargando usuarios...
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>

        </section>
    </main>
    <?php require __DIR__ . '/../../utils/footer.php'; ?>
    <script src="/assets/js/script.js" defer></script>
    <script src="/assets/js/users.js" defer></script>
</body>

<!-- Popover Nuevo Usuario-->
<div id="modal-nuevo-usuario" popover="manual"
    class="w-[calc(100%-2rem)] max-w-2xl overflow-hidden rounded-2xl bg-surface-container-lowest text-on-surface border border-outline-variant/60 backdrop:bg-on-surface/50 backdrop:backdrop-blur-sm">

    <div class="flex items-center justify-between px-6 py-5 border-b border-outline-variant/60">

        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-primary-container text-on-primary-container">
                <span class="material-symbols-outlined text-[22px]">person_add</span>
            </div>
            <div>
                <h3 class="font-headline-sm text-headline-sm font-semibold text-on-surface">Nuevo usuario</h3>
                <p class="mt-0.5 text-sm text-on-surface-variant">Registra un nuevo usuario en el sistema </p>
            </div>

        </div>

        <button type="button" popovertarget="modal-nuevo-usuario" popovertargetaction="hide" aria-label="Cerrar modal"
            class="flex h-9 w-9 items-center justify-center rounded-full text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-on-surface cursor-pointer">
            <span class="material-symbols-outlined text-[20px]"> close</span>
        </button>
    </div>

    <form id="form-add-user" class="px-6 py-6">

        <div class="grid grid-cols-1 gap-x-5 gap-y-5 sm:grid-cols-4">

            <!-- Nombre -->
            <div class="flex flex-col gap-2 sm:col-span-2">
                <label for="nombre" class="text-sm font-medium text-on-surface"> Nombre</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">person</span>
                    <input id="nombre" name="nombre" type="text" required autocomplete="given-name" placeholder="Ej. Juan"
                        class="w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface placeholder:text-on-surface-variant/70 outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15" />
                </div>
            </div>

            <!-- Apellido -->
            <div class="flex flex-col gap-2 sm:col-span-2">
                <label for="apellido" class="text-sm font-medium text-on-surface"> Apellido </label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">badge</span>
                    <input id="apellido" name="apellido" type="text" required autocomplete="family-name" placeholder="Ej. Pérez"
                        class="w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface placeholder:text-on-surface-variant/70 outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15" />
                </div>
            </div>

            <!-- Cédula -->
            <div class="flex flex-col gap-2 sm:col-span-2">
                <label for="cedula" class="text-sm font-medium text-on-surface"> Cédula de identidad</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">id_card</span>
                    <input id="cedula" name="cedula" type="text" required inputmode="numeric" autocomplete="off" placeholder="Ej. 1234567"
                        class="w-full rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface placeholder:text-on-surface-variant/70 outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15" />
                </div>
            </div>

            <!-- Rol -->
            <div class="flex flex-col gap-2 sm:col-span-2">
                <label for="rol" class="text-sm font-medium text-on-surface"> Rol del usuario</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">admin_panel_settings</span>
                    <select id="rol" name="rol" required
                        class="w-full appearance-none rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-10 text-sm text-on-surface outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15 cursor-pointer">
                        <option value="">Seleccionar rol...</option>
                        <option value="admin">Administrador</option>
                        <option value="internacion">Internación</option>
                        <option value="nutricionista">Nutricionista</option>
                    </select>
                    <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">expand_more</span>
                </div>
            </div>

            <div class="flex flex-col gap-2 sm:col-span-2">
                <label for="id_servicio" class="text-sm font-medium text-on-surface"> Servicio</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">medical_services</span>

                    <select id="id_servicio" name="id_servicio" required
                        class="w-full appearance-none rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-10 text-sm text-on-surface outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15 cursor-pointer">
                         <option>Seleccionar Servicio</option>  
                         <option value="1">Polivalente</option>
                    </select>

                    <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">expand_more</span>
                </div>
            </div>

        </div>

        <div class="mt-7 flex flex-col-reverse gap-3 border-t border-outline-variant/60 pt-5 sm:flex-row sm:justify-end">
            <button type="button" popovertarget="modal-nuevo-usuario" popovertargetaction="hide"
                class="h-10 rounded-xl border border-outline-variant px-5 text-sm font-medium text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface cursor-pointer">
                Cancelar
            </button>
            <button type="submit"
                class="flex h-10 items-center justify-center gap-2 rounded-xl bg-primary px-5 text-sm font-medium text-on-primary transition-all hover:bg-primary-container active:scale-[0.98] cursor-pointer">
                <span class="material-symbols-outlined text-[19px]">person_add</span>
                Crear usuario
            </button>
        </div>
    </form>
</div>

<!-- Popover Editar Usuario-->
<div id="modal-editar-usuario" popover="manual"
    class="w-[calc(100%-2rem)] max-w-2xl overflow-hidden rounded-2xl bg-surface-container-lowest text-on-surface border border-outline-variant/60 backdrop:bg-on-surface/50 backdrop:backdrop-blur-sm">

    <div class="flex items-center justify-between border-b border-outline-variant/60 px-6 py-5">

        <div class="flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-secondary-container text-on-secondary-container">
                <span class="material-symbols-outlined text-[22px]">manage_accounts</span>
            </div>
            <div>
                <h3 class="text-headline-sm font-headline-sm font-semibold text-on-surface">Editar usuario</h3>
                <p class="mt-0.5 text-sm text-on-surface-variant">Modifica los datos del usuario seleccionado</p>
            </div>
        </div>

        <button type="button" popovertarget="modal-editar-usuario" popovertargetaction="hide" aria-label="Cerrar modal"
            class="flex h-9 w-9 cursor-pointer items-center justify-center rounded-full text-on-surface-variant transition-colors hover:bg-surface-container-high hover:text-on-surface">
            <span class="material-symbols-outlined text-[20px]"> close</span>
        </button>
    </div>

    <form id="form-edit-user" class="px-6 py-6">

        <input type="hidden" id="edit-id" name="id" />

        <div class="grid grid-cols-1 gap-x-5 gap-y-5 sm:grid-cols-4">

            <!-- Nombre (No editable) -->
            <div class="flex flex-col gap-2 sm:col-span-2">
                <label for="edit-nombre" class="text-sm font-medium text-on-surface"> Nombre <span class="text-xs font-normal text-on-surface-variant">(No editable)</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">person</span>
                    <input id="edit-nombre" name="nombre" type="text" readonly
                        class="w-full cursor-not-allowed rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15 opacity-70" />
                </div>
            </div>

            <!-- Apellido (No editable) -->
            <div class="flex flex-col gap-2 sm:col-span-2">
                <label for="edit-apellido" class="text-sm font-medium text-on-surface"> Apellido <span class="text-xs font-normal text-on-surface-variant">(No editable)</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">badge</span>
                    <input id="edit-apellido" name="apellido" type="text" readonly
                        class="w-full cursor-not-allowed rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-4 text-sm text-on-surface outline-none transition-all placeholder:text-on-surface-variant/70 focus:border-primary focus:ring-2 focus:ring-primary/15 opacity-70" />
                </div>
            </div>

            <!-- Cédula (No editable) -->
            <div class="flex flex-col gap-2 sm:col-span-2">
                <label for="edit-cedula" class="text-sm font-medium text-on-surface"> Cédula de identidad <span class="text-xs font-normal text-on-surface-variant">(No editable)</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant/60">id_card</span>
                    <input id="edit-cedula" name="cedula" type="text" readonly
                        class="w-full cursor-not-allowed rounded-xl border border-outline-variant/50 bg-surface-container py-2.5 pl-11 pr-4 text-sm text-on-surface-variant outline-none opacity-70" />
                </div>
            </div>

            <!-- Rol -->
            <div class="flex flex-col gap-2 sm:col-span-2">
                <label for="edit-rol" class="text-sm font-medium text-on-surface"> Rol del usuario</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">admin_panel_settings</span>
                    <select id="edit-rol" name="rol" required
                        class="w-full cursor-pointer appearance-none rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-10 text-sm text-on-surface outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15">
                        <option value="admin">Administrador</option>
                        <option value="internacion">Internación</option>
                        <option value="nutricionista">Nutricionista</option>
                    </select>
                    <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">expand_more</span>
                </div>
            </div>

            <!-- SERVICIO (Nuevo campo) -->
            <div class="flex flex-col gap-2 sm:col-span-2">
                <label for="edit-id_servicio" class="text-sm font-medium text-on-surface"> Servicio</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">medical_services</span>
                    <select id="edit-id_servicio" name="id_servicio" required
                        class="w-full cursor-pointer appearance-none rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-10 text-sm text-on-surface outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15">
                         <option>Seleccionar Servicio</option>
                         <option value="1">Polivalente</option> 
                    </select>
                    <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">expand_more</span>
                </div>
            </div>

            <!-- Estado -->
            <div class="flex flex-col gap-2 sm:col-span-2">
                <label for="edit-estado" class="text-sm font-medium text-on-surface"> Estado de la cuenta</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">toggle_on</span>
                    <select id="edit-estado" name="estado" required
                        class="w-full cursor-pointer appearance-none rounded-xl border border-outline-variant bg-surface-container-low py-2.5 pl-11 pr-10 text-sm text-on-surface outline-none transition-all focus:border-primary focus:ring-2 focus:ring-primary/15">
                        <option value="true">Activo</option>
                        <option value="false">Inactivo</option>
                    </select>
                    <span class="material-symbols-outlined pointer-events-none absolute right-3 top-1/2 -translate-y-1/2 text-[20px] text-on-surface-variant">expand_more</span>
                </div>
            </div>

        </div>

        <div class="mt-7 flex flex-col-reverse gap-3 border-t border-outline-variant/60 pt-5 sm:flex-row sm:justify-end">
            <button type="button" popovertarget="modal-editar-usuario" popovertargetaction="hide"
                class="h-10 cursor-pointer rounded-xl border border-outline-variant px-5 text-sm font-medium text-on-surface-variant transition-colors hover:bg-surface-container-low hover:text-on-surface">
                Cancelar
            </button>
            <button type="submit"
                class="flex h-10 cursor-pointer items-center justify-center gap-2 rounded-xl bg-primary px-5 text-sm font-medium text-on-primary transition-all hover:bg-primary-container active:scale-[0.98]">
                <span class="material-symbols-outlined text-[19px]">save</span>
                Guardar cambios
            </button>
        </div>
    </form>
</div>

</html>