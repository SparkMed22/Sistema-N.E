<?php
$title = 'ERROR - H.G.I';
include_once __DIR__ . './../../utils/head.php' ?>


<body class="min-h-screen bg-background text-textDark flex items-center justify-center px-6">

    <main class="w-full max-w-lg">

        <!-- CARD -->
        <div class="card rounded-3xl p-10 text-center">

            <!-- ICON -->
            <div
                class="w-20 h-20 mx-auto rounded-2xl bg-cyan-50 flex items-center justify-center mb-8">

                <span class="material-symbols-outlined text-primary text-[42px]">
                    error
                </span>

            </div>

            <!-- 404 -->
            <span class="text-primary text-sm font-semibold tracking-wide">
                ERROR 404
            </span>

            <h1 class="text-4xl md:text-5xl font-extrabold mt-3 mb-4">
                Página no encontrada
            </h1>

            <p class="text-textSoft text-base leading-relaxed max-w-md mx-auto">
                La página que intentas abrir no existe o fue movida a otra ubicación.
            </p>

            <!-- ACTIONS -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center mt-10">

                <a href="/"
                    class="px-6 py-3 rounded-2xl bg-primary text-white font-semibold soft-hover hover:opacity-95 flex items-center justify-center gap-2">

                    <span class="material-symbols-outlined text-[20px]">
                        home
                    </span>

                    Ir al inicio

                </a>

            </div>

        </div>

        <!-- FOOTER -->
        <div class="mt-6 text-center">

            <p class="text-xs text-textSoft">
                Hospital General de Itapúa · Nutrición Enteral
            </p>

        </div>

    </main>


    <script src="/assets/js/error.js" defer></script>
</body>

</html>