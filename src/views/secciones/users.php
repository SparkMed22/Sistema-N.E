<?php
$title = "HGI - Usuarios";
require __DIR__ . '/../../utils/head.php';

$usuarios_id = $_SESSION['user_id'];
$usuarios_rol = $_SESSION['user_rol'];
$usuarios = $_SESSION['user_nombre'] ?? 'Personal de Guardia';
?>

<body class="bg-background font-jakarta text-textDark min-h-screen flex flex-col">

    <?php require __DIR__ . '/../../utils/header.php'; ?>

    <main class="pt-28 pb-12 px-4 max-w-7xl w-full mx-auto flex-grow space-y-6">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-primary tracking-tight">Gestión de Usuarios</h1>
                <p class="text-xs text-textSoft mt-1">Administra los accesos, bloquea cuentas y restablece credenciales del personal.</p>
            </div>
            <button onclick="openModal('modal-add_usuarios')" class="px-4 py-2 bg-primary hover:bg-opacity-95 text-white text-xs font-bold rounded-xl flex items-center gap-1.5 transition-colors shadow-sm self-start sm:self-center">
                <span class="material-symbols-outlined text-sm">person_add</span>
                Nuevo Usuario
            </button>
        </div>

        <div class="bg-surface border border-borderColor rounded-2xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-background border-b border-borderColor text-[11px] font-bold uppercase tracking-wider text-textSoft">
                            <th class="py-4 px-6">N° Registro</th>
                            <th class="py-4 px-6">Nombre Completo</th>
                            <th class="py-4 px-6">N° Cédula</th>
                            <th class="py-4 px-6">Rol / Permiso</th>
                            <th class="py-4 px-6">Estado</th>
                            <th class="py-4 px-6 text-right">Acciones de Gestión</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-usuarios-body" class="divide-y divide-borderColor text-xs">
                        <tr>
                            <td colspan="6" class="py-8 text-center text-textSoft">
                                Cargando usuarios...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <?php require __DIR__ . '/../../utils/footer.php'; ?>
    </main>


    <div id="modal-add_usuarios" class="modal-backdrop fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4 font-jakarta transition-all duration-300">

        <div class="bg-surface w-full max-w-2xl max-h-[90vh] rounded-[24px] shadow-2xl border border-borderColor overflow-hidden flex flex-col bg-white transform scale-100 transition-all">

            <form id="formAddUsuarios" class="flex flex-col h-full m-0">

                <div class="px-8 py-5 border-b border-borderColor bg-slate-50/50 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-black text-textDark tracking-tight">Registrar Nuevo Usuario</h3>
                        <p class="text-xs text-textSoft mt-0.5">Completa los datos del personal para el acceso al sistema.</p>
                    </div>
                    <button type="button" onclick="closeModal('modal-add_usuarios')" class="w-8 h-8 flex items-center justify-center rounded-full text-textSoft hover:text-textDark hover:bg-slate-100 transition-colors duration-200">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-8 space-y-5 bg-white scrollbar-thin">

                    <div id="modalErrorContainer" class="hidden p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-xs font-semibold flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">error</span>
                        <span class="error-message"></span>
                    </div>

                    <div class="group flex flex-col">
                        <label for="add_nombre" class="text-xs font-bold text-textSoft mb-1.5 transition-colors group-focus-within:text-primary">
                            Nombre Completo <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50/50 px-4 focus-within:border-primary focus-within:bg-white focus-within:ring-4 focus-within:ring-primary/10 transition-all duration-200">
                            <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary mr-3 text-[20px] transition-colors">person</span>
                            <input
                                type="text"
                                id="add_nombre"
                                name="nombre"
                                placeholder="Ej. Juan Pérez"
                                class="w-full py-3.5 bg-transparent outline-none text-textDark text-sm font-medium placeholder:text-slate-400"
                                required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="group flex flex-col">
                            <label for="add_cedula" class="text-xs font-bold text-textSoft mb-1.5 transition-colors group-focus-within:text-primary">
                                Cédula de Identidad <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50/50 px-4 focus-within:border-primary focus-within:bg-white focus-within:ring-4 focus-within:ring-primary/10 transition-all duration-200">
                                <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary mr-3 text-[20px] transition-colors">badge</span>
                                <input
                                    type="text"
                                    id="add_cedula"
                                    name="cedula"
                                    placeholder="Ej. 1234567"
                                    class="w-full py-3.5 bg-transparent outline-none text-textDark text-sm font-medium placeholder:text-slate-400"
                                    required />
                            </div>
                        </div>

                        <div class="group flex flex-col">
                            <div class="flex justify-between items-center mb-1.5">
                                <label for="add_numero_registro" class="text-xs font-bold text-textSoft transition-colors group-focus-within:text-primary">
                                    N° de Registro Profesional
                                </label>
                                <span class="text-[10px] text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md font-bold tracking-wide uppercase">Opcional</span>
                            </div>
                            <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50/50 px-4 focus-within:border-primary focus-within:bg-white focus-within:ring-4 focus-within:ring-primary/10 transition-all duration-200">
                                <span class="material-symbols-outlined text-slate-400 group-focus-within:text-primary mr-3 text-[20px] transition-colors">clinical_notes</span>
                                <input
                                    type="text"
                                    id="add_numero_registro"
                                    name="numero_registro"
                                    placeholder="Ej. REG-884"
                                    class="w-full py-3.5 bg-transparent outline-none text-textDark text-sm font-medium placeholder:text-slate-400" />
                            </div>
                        </div>
                    </div>

                    <div class="group flex flex-col relative" id="custom-select-container">
                        <label for="add_rol" class="text-xs font-bold text-textSoft mb-1.5 transition-colors group-focus-within:text-primary">
                            Rol Asignado <span class="text-red-500">*</span>
                        </label>

                        <input type="hidden" id="add_rol" name="rol" required />

                        <button
                            type="button"
                            id="custom-select-trigger"
                            class="w-full flex items-center justify-between border border-slate-200 rounded-xl bg-slate-50/50 px-4 py-3.5 focus:border-primary focus:bg-white focus:ring-4 focus:ring-primary/10 text-left transition-all duration-200">

                            <div class="flex items-center text-slate-400 group-focus-within:text-primary transition-colors">
                                <span class="material-symbols-outlined mr-3 text-[20px]">manage_accounts</span>
                                <span id="custom-select-text" class="text-slate-400 text-sm font-medium">Selecciona el rol de acceso</span>
                            </div>

                            <span id="custom-select-arrow" class="material-symbols-outlined text-slate-400 text-[20px] transition-transform duration-200">expand_more</span>
                        </button>

                        <div
                            id="custom-select-options"
                            class="hidden absolute z-50 left-0 right-0 top-[calc(100%+4px)] bg-white border border-slate-100 rounded-xl shadow-xl py-1.5 transform scale-95 opacity-0 transition-all duration-150 origin-top">

                            <button type="button" data-value="Administracion" class="custom-option w-full px-4 py-3 text-sm text-textDark hover:bg-slate-50 font-medium flex items-center justify-between transition-colors text-left">
                                <span>Administración</span>
                                <span class="material-symbols-outlined text-primary text-base hidden check-icon">check</span>
                            </button>

                            <button type="button" data-value="Licenciado" class="custom-option w-full px-4 py-3 text-sm text-textDark hover:bg-slate-50 font-medium flex items-center justify-between transition-colors text-left">
                                <span>Licenciado</span>
                                <span class="material-symbols-outlined text-primary text-base hidden check-icon">check</span>
                            </button>
                        </div>
                    </div>

                    <div class="bg-slate-50 border border-slate-200/60 rounded-xl p-4 flex items-start gap-3">
                        <span class="material-symbols-outlined text-slate-500 text-[20px] mt-0.5">info</span>
                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            La contraseña predeterminada para el primer acceso del usuario será <span class="font-bold text-slate-900">únicamente su número de cédula</span>. El sistema le solicitará cambiarla obligatoriamente al ingresar.
                        </p>
                    </div>

                </div>

                <div class="px-8 py-4 border-t border-borderColor bg-slate-50/50 flex justify-end gap-3">
                    <button
                        type="button"
                        onclick="closeModal('modal-add_usuarios')"
                        class="px-5 py-2.5 text-xs rounded-xl border border-slate-200 bg-white hover:bg-slate-50 hover:border-slate-300 text-slate-600 font-bold transition-all duration-150 active:scale-[0.98]">
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        id="btnSubmitAddUsuario"
                        class="px-6 py-2.5 text-xs rounded-xl bg-primary hover:bg-primary/95 text-white font-bold flex items-center gap-2 shadow-sm transition-all duration-150 active:scale-[0.98]">
                        <span class="material-symbols-outlined text-sm">save</span>
                        <span>Agregar Usuario</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="/assets/js/script.js" defer></script>
    <script src="/assets/js/usuarios.js" defer></script>

</body>

</html>