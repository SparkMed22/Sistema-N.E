<header class="fixed top-0 left-0 right-0 z-50 bg-white border-b border-borderColor">
    <div class="max-w-7xl mx-auto px-6 top-2">

        <div class="h-16 flex items-center justify-between">

            <div class="flex items-center gap-4">

                <div class="relative">
                    <img src="/assets/img/logo2.png" alt="Hospital General de Itapúa" class="w-11 h-11 object-contain">
                </div>

                <a href="/start/dashboard/" class="text-lg font-bold text-primary">
                    <div>
                        <p class="text-[10px] uppercase tracking-[0.25em] text-primary font-bold">
                            Sistema Hospitalario
                        </p>

                        <h1 class="text-lg font-extrabold text-textDark leading-none">
                            Nutrición Enteral
                        </h1>
                    </div>
                </a>
            </div>


            <div class="hidden lg:flex items-center gap-8">

                <div class="text-center">
                    <p class="text-[10px] uppercase text-textSoft font-semibold">
                        Institución
                    </p>

                    <p class="text-sm font-bold text-primary">
                        Hospital General de Itapúa
                    </p>
                </div>

            </div>

            <!-- Usuario -->
            <div class="flex items-center gap-3">

                <div class="hidden sm:flex flex-col items-end">
                    <span id="nombre_usuario" class="text-sm font-bold text-textDark"></span>
                    <span id="rol_usuario" class="text-[11px] text-textSoft"></span>
                </div>
                <div id="inicial_usuario" class="w-10 h-10 rounded-full bg-primary text-white font-bold flex items-center justify-center">
                </div>


                <button onclick="logout()"
                    class="p-2 rounded-xl text-textSoft hover:bg-red-50 hover:text-red-600 transition"
                    title="Cerrar sesión">

                    <span class="material-symbols-outlined">
                        logout
                    </span>
                </button>
            </div>
        </div>
    </div>
</header>

<script src="/assets/js/header.js"></script>