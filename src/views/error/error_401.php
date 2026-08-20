<?php include_once __DIR__ . '/../../utils/head.php' ?>

<body class="min-h-screen bg-background text-textDark flex items-center justify-center px-6">

    <main class="w-full max-w-lg">

        <div class="card rounded-3xl p-10 text-center">

            <div class="w-20 h-20 mx-auto rounded-2xl bg-cyan-50 flex items-center justify-center mb-8">
                <span class="material-symbols-outlined text-primary text-[42px]">
                    lock
                </span>
            </div>

            <span class="text-primary text-sm font-semibold tracking-wide">
                ERROR 401
            </span>

            <h1 class="text-4xl md:text-5xl font-extrabold mt-3 mb-4">
                 No Autorizado
            </h1>

            <p class="text-textSoft text-base leading-relaxed max-w-md mx-auto">
                No tienes los permisos necesarios para acceder a esta sección. Por favor, inicia sesión con una cuenta autorizada.
            </p>

            <div class="flex flex-col sm:flex-row gaSp-3 justify-center mt-10">

                <a href="/"
                    class="px-6 py-3 rounded-2xl bg-primary text-white font-semibold soft-hover hover:opacity-95 flex items-center justify-center gap-2">
                    
                    <span class="material-symbols-outlined text-[20px]">
                        home
                    </span>
                    Ir al inicio
                </a>
            </div>

        </div>

        <div class="mt-6 text-center">
            <p class="text-xs text-textSoft">
                Hospital General de Itapúa · Nutrición Enteral
            </p>
        </div>

    </main>

    
    <script src="/assets/js/error.js" defer></script>

</body>
</html>