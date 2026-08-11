<?php
$title = "H.G.I - Sistema de Nutrición Enteral - Login";
include_once __DIR__ . '/utils/head.php';

?>


<body class="bg-surface-container min-h-screen flex items-center justify-center p-4 md:p-container-padding">

    <main class="w-full max-w-5xl bg-surface-container-lowest rounded-[2rem] shadow-xl overflow-hidden flex flex-col md:flex-row h-auto min-h-[600px] border border-surface-variant/40">

        <section class="w-full md:w-1/2 bg-gradient-to-br from-primary via-tertiary to-on-primary-fixed p-8 md:p-12 flex flex-col justify-between items-center text-center relative overflow-hidden text-on-primary">

            <div class="absolute -top-16 -left-16 w-48 h-48 bg-secondary-container/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-16 -right-16 w-48 h-48 bg-primary-fixed-dim/20 rounded-full blur-2xl pointer-events-none"></div>

            <div class="z-10 my-auto">
                <p class="text-xs font-bold text-primary-fixed-dim uppercase tracking-widest mb-4">
                    Hospital General de Itapúa
                </p>
                <h1 class="text-3xl md:text-4xl font-extrabold text-on-primary mb-6 leading-tight">
                    Sistema de <br />
                    Nutrición Enteral
                </h1>
                <p class="text-sm text-surface-container-high/90 max-w-sm mx-auto leading-relaxed">
                    Gestionar de manera eficiente y segura la información de pacientes, personal y servicios hospitalarios.
                </p>
            </div>

            <div class="z-10 mt-8 mb-2 flex items-center gap-3">
                <img src="/assets/img/logo.png" alt="Logo de HGI" class="w-72 object-contain brightness-0 invert" />
            </div>
        </section>

        <section class="w-full md:w-1/2 bg-surface-container-lowest p-8 md:p-16 flex flex-col justify-center">

            <div class="mb-8">
                <h2 class="text-2xl font-bold text-on-surface mb-1">Bienvenido</h2>
                <p class="text-sm text-on-surface-variant">Inicia sesión para continuar</p>
            </div>

            <form class="space-y-5" id="login-form" data-form-target="auth">
                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant" for="cedula">Cédula</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-outline group-focus-within:text-secondary transition-colors text-xl">badge</span>
                        </div>
                        <input class="block w-full pl-10 pr-3 py-2.5 border border-surface-variant rounded-xl bg-surface-bright text-on-surface text-sm placeholder:text-outline-variant/80 focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none" id="cedula" name="cedula" placeholder="Ingresa tu identificación" type="text" />
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="block text-xs font-semibold text-on-surface-variant" for="password">Contraseña</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="material-symbols-outlined text-outline group-focus-within:text-secondary transition-colors text-xl">lock</span>
                        </div>
                        <input class="block w-full pl-10 pr-10 py-2.5 border border-surface-variant rounded-xl bg-surface-bright text-on-surface text-sm placeholder:text-outline-variant/80 focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none" id="password" name="password" placeholder="••••••••" type="password" />
                        <button class="absolute inset-y-0 right-0 pr-3 flex items-center text-outline hover:text-secondary transition-colors" onclick="togglePassword()" type="button">
                            <span class="material-symbols-outlined text-xl" id="visibility-icon">visibility</span>
                        </button>
                    </div>
                </div>

                <button id="btn-login" data-action="submit-login" class="w-full bg-secondary hover:bg-tertiary-container text-on-primary font-semibold text-sm py-3 px-4 rounded-xl transition-all duration-200 ease-in-out shadow-md shadow-secondary/20 mt-2" type="submit">
                    Iniciar Sesión
                </button>
            </form>

        </section>
    </main>


    <div id="modal-password" class="modal-popover" popover="manual">
        <div class="w-full max-w-md rounded-[2rem] bg-surface-container-lowest p-8 shadow-2xl border border-surface-variant/50">

            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-primary-fixed/40 text-primary shadow-sm">
                <span class="material-symbols-outlined text-3xl">lock_reset</span>
            </div>

            <div class="mt-5 text-center">
                <h2 class="text-xl font-bold text-on-surface tracking-tight">
                    Cambio de contraseña requerido
                </h2>
                <p class="mt-2 text-sm leading-relaxed text-on-surface-variant">
                    Es tu primer ingreso al Sistema de Nutrición Enteral. Debes actualizar tus credenciales para continuar.
                </p>
            </div>

            <form id="form-password" class="mt-6 space-y-4">
                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-on-surface-variant" for="new-password">
                        Nueva contraseña
                    </label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary text-xl transition-colors">key</span>
                        <input type="password" id="new-password" name="new_password" placeholder="••••••••" required
                            class="w-full rounded-xl border border-surface-variant bg-surface-bright pl-10 pr-3 py-2.5 text-sm text-on-surface placeholder:text-outline-variant/80 focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="block text-xs font-semibold text-on-surface-variant" for="confirm-password">
                        Confirmar contraseña
                    </label>
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary text-xl transition-colors">check_circle</span>
                        <input type="password" id="confirm-password" name="confirm_password" placeholder="••••••••" required
                            class="w-full rounded-xl border border-surface-variant bg-surface-bright pl-10 pr-3 py-2.5 text-sm text-on-surface placeholder:text-outline-variant/80 focus:border-secondary focus:ring-2 focus:ring-secondary/20 outline-none transition-all">
                    </div>
                </div>

                <p id="password-error" class="hidden text-xs font-medium text-error bg-error-container/60 p-2.5 rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-base">error</span>
                    <span id="error-text">Las contraseñas no coinciden.</span>
                </p>

                <button type="submit" id="btn-change-password"
                    class="mt-3 flex w-full items-center justify-center gap-2 rounded-xl bg-secondary px-4 py-3 text-sm font-semibold text-on-primary shadow-md shadow-secondary/20 hover:bg-tertiary-container active:scale-[0.98] transition-all">
                    <span class="material-symbols-outlined text-lg">save</span>
                    Actualizar contraseña
                </button>
            </form>
        </div>
    </div>

    <script src="/assets/js/index.js" defer></script>
    <script src="/assets/js/script.js" defer></script>

</body>



</html>