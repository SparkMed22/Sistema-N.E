<?php

$title = "Gestión de Pedidos | H.G.I";

require __DIR__ . '/../../utils/head.php';

?>

<body class="bg-background text-on-surface min-h-screen font-sans">

    <?php require __DIR__ . '/../../utils/header.php'; ?>


    <main class="pt-24 pb-10 max-w-[1600px] mx-auto px-4 sm:px-6 lg:px-8">


        <!-- HEADER -->
        <header class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5 mb-8">

            <div>

                <div class="flex items-center gap-3">

                    <div
                        class="w-11 h-11 rounded-xl bg-primary text-on-primary flex items-center justify-center shadow-sm">

                        <span class="material-symbols-outlined">
                            restaurant
                        </span>

                    </div>


                    <div>

                        <p class="text-xs font-bold uppercase tracking-[0.15em] text-secondary">
                            Nutrición
                        </p>

                        <h1 class="text-2xl sm:text-3xl font-bold tracking-tight text-on-surface">
                            Gestión de pedidos
                        </h1>

                    </div>

                </div>


                <p class="text-sm text-on-surface-variant mt-4 max-w-xl">

                    Administra, supervisa y procesa los pedidos nutricionales
                    activos de los pacientes.

                </p>

            </div>


            <div class="flex flex-wrap items-center gap-3">

                <div
                    class="px-4 py-3 rounded-xl bg-white border border-outline-variant/40 shadow-sm">

                    <p
                        class="text-[10px] uppercase font-bold tracking-wider text-on-surface-variant">

                        Última actualización

                    </p>

                    <p class="text-sm font-semibold mt-1">

                        Hace unos minutos

                    </p>

                </div>


                <button
                    type="button"
                    class="h-11 px-4 rounded-xl bg-primary text-on-primary text-sm font-bold hover:bg-primary-container transition flex items-center gap-2">

                    <span class="material-symbols-outlined text-[19px]">
                        refresh
                    </span>

                    Actualizar

                </button>

            </div>

        </header>



        <!-- RESUMEN -->
 



        <!-- FILTROS -->
        <section
            class="bg-white border border-outline-variant/40 rounded-2xl p-4 sm:p-5 mb-6 shadow-sm">

            <div class="flex flex-col xl:flex-row xl:items-center gap-3">


                <!-- BUSCADOR -->
                <div class="relative flex-1">

                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">

                        search

                    </span>


                    <input
                        type="text"
                        placeholder="Buscar por paciente, médico, sala..."
                        class="w-full h-11 pl-10 pr-4 bg-surface border border-outline-variant/50 rounded-xl text-sm outline-none transition focus:bg-white focus:border-secondary focus:ring-4 focus:ring-primary-fixed/40">

                </div>



                <!-- SERVICIO -->
                <select
                    class="h-11 px-4 bg-surface border border-outline-variant/50 rounded-xl text-sm text-on-surface outline-none transition focus:border-secondary">

                    <option>
                        Todos los servicios
                    </option>

                    <option>
                        UTI
                    </option>

                    <option>
                        Medicina Interna
                    </option>

                    <option>
                        Cirugía
                    </option>

                </select>



                <!-- BLOQUE -->
                <select
                    class="h-11 px-4 bg-surface border border-outline-variant/50 rounded-xl text-sm text-on-surface outline-none transition focus:border-secondary">

                    <option>
                        Todos los bloques
                    </option>

                    <option>
                        Bloque 1
                    </option>

                    <option>
                        Bloque 2
                    </option>

                    <option>
                        Bloque 3
                    </option>

                </select>



                <!-- FILTROS -->
                <button
                    type="button"
                    class="h-11 px-4 rounded-xl border border-outline-variant/50 text-sm font-semibold hover:bg-surface-container-low transition flex items-center justify-center gap-2">

                    <span class="material-symbols-outlined text-[18px]">

                        filter_list

                    </span>

                    Filtros

                </button>


            </div>

        </section>



        <!-- LISTADO DE PEDIDOS -->
        <section
            class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-3 gap-5">



            <!-- PEDIDO 1 -->
            <article
                class="group relative bg-white border border-outline-variant/40 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">


                <!-- HEADER CARD -->
                <div class="flex items-start justify-between gap-4">


                    <div class="flex items-center gap-3 min-w-0">


                        <div
                            class="w-11 h-11 shrink-0 rounded-xl bg-primary-fixed flex items-center justify-center text-primary font-bold">

                            CM

                        </div>


                        <div class="min-w-0">


                            <div class="flex items-center gap-2 flex-wrap">

                                <h2 class="font-bold text-base truncate">

                                    Carlos Mendoza

                                </h2>


                                <span
                                    class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-error-container text-error text-[10px] font-bold tracking-wide">

                                    <span
                                        class="material-symbols-outlined text-[13px]">

                                        priority_high

                                    </span>

                                    URGENTE

                                </span>

                            </div>


                            <p class="text-xs text-on-surface-variant mt-1">

                                Dr. Analia Rojas

                            </p>


                        </div>

                    </div>



                    <button
                        type="button"
                        class="w-9 h-9 shrink-0 rounded-lg text-on-surface-variant hover:bg-surface-container-low transition flex items-center justify-center">

                        <span class="material-symbols-outlined">

                            more_vert

                        </span>

                    </button>


                </div>



                <!-- UBICACION -->
                <div
                    class="mt-5 p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/30">


                    <div class="flex items-start gap-3">


                        <span
                            class="material-symbols-outlined text-secondary text-[20px]">

                            location_on

                        </span>


                        <div>


                            <p
                                class="text-[10px] uppercase tracking-wider font-bold text-on-surface-variant">

                                Ubicación

                            </p>


                            <p class="text-sm font-semibold mt-1">

                                UTI · B2 · Sala 4 · Cama 12

                            </p>


                            <p
                                class="text-xs text-on-surface-variant mt-1">

                                Cuidados Intensivos

                            </p>


                        </div>


                    </div>


                </div>



                <!-- PEDIDO NUTRICIONAL -->
                <div class="mt-5">


                    <div class="flex items-center justify-between mb-3">

                        <p
                            class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">

                            Pedido nutricional

                        </p>


                        <span class="text-xs text-on-surface-variant">

                            Enteral

                        </span>

                    </div>



                    <div class="grid grid-cols-3 gap-2">


                        <div
                            class="p-3 rounded-xl bg-surface text-center">

                            <p
                                class="text-[10px] uppercase text-on-surface-variant">

                                Porción

                            </p>

                            <p
                                class="font-bold text-primary mt-1">

                                250g

                            </p>

                        </div>



                        <div
                            class="p-3 rounded-xl bg-surface text-center">

                            <p
                                class="text-[10px] uppercase text-on-surface-variant">

                                Líquido

                            </p>

                            <p
                                class="font-bold text-primary mt-1">

                                150ml

                            </p>

                        </div>



                        <div
                            class="p-3 rounded-xl bg-primary-container text-center">

                            <p
                                class="text-[10px] uppercase text-on-primary-container">

                                Total

                            </p>

                            <p
                                class="font-bold text-on-primary-container mt-1">

                                400ml

                            </p>

                        </div>


                    </div>


                </div>



                <!-- FOOTER -->
                <div
                    class="flex items-center justify-between gap-4 mt-5 pt-4 border-t border-outline-variant/30">


                    <div>

                        <p
                            class="text-[10px] uppercase font-bold tracking-wider text-on-surface-variant">

                            Estado

                        </p>


                        <div class="flex items-center gap-2 mt-1">

                            <span
                                class="w-2 h-2 rounded-full bg-amber-500">
                            </span>


                            <span class="text-sm font-semibold">

                                Pendiente

                            </span>

                        </div>


                    </div>



                    <button
                        type="button"
                        class="h-10 px-4 rounded-xl bg-primary text-on-primary text-xs font-bold hover:bg-primary-container transition flex items-center gap-2">

                        Gestionar

                        <span
                            class="material-symbols-outlined text-[17px]">

                            arrow_forward

                        </span>

                    </button>


                </div>


            </article>



            <!-- PEDIDO 2 -->
            <article
                class="group relative bg-white border border-outline-variant/40 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">


                <div class="flex items-start justify-between gap-4">


                    <div class="flex items-center gap-3 min-w-0">


                        <div
                            class="w-11 h-11 shrink-0 rounded-xl bg-secondary-fixed flex items-center justify-center text-primary font-bold">

                            MR

                        </div>


                        <div class="min-w-0">


                            <h2 class="font-bold text-base truncate">

                                María Elena Rivas

                            </h2>


                            <p class="text-xs text-on-surface-variant mt-1">

                                Dr. Fernando Silva

                            </p>


                        </div>

                    </div>



                    <button
                        type="button"
                        class="w-9 h-9 shrink-0 rounded-lg text-on-surface-variant hover:bg-surface-container-low transition flex items-center justify-center">

                        <span class="material-symbols-outlined">

                            more_vert

                        </span>

                    </button>


                </div>



                <div
                    class="mt-5 p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/30">


                    <div class="flex items-start gap-3">

                        <span
                            class="material-symbols-outlined text-secondary text-[20px]">

                            location_on

                        </span>


                        <div>

                            <p
                                class="text-[10px] uppercase tracking-wider font-bold text-on-surface-variant">

                                Ubicación

                            </p>

                            <p class="text-sm font-semibold mt-1">

                                INT · B1 · Sala 2 · Cama 05

                            </p>

                            <p
                                class="text-xs text-on-surface-variant mt-1">

                                Medicina Interna

                            </p>

                        </div>

                    </div>

                </div>



                <div class="mt-5">


                    <div class="flex items-center justify-between mb-3">

                        <p
                            class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">

                            Pedido nutricional

                        </p>

                        <span class="text-xs text-on-surface-variant">

                            Enteral

                        </span>

                    </div>



                    <div class="grid grid-cols-3 gap-2">


                        <div class="p-3 rounded-xl bg-surface text-center">

                            <p
                                class="text-[10px] uppercase text-on-surface-variant">

                                Porción

                            </p>

                            <p class="font-bold text-primary mt-1">

                                300g

                            </p>

                        </div>



                        <div class="p-3 rounded-xl bg-surface text-center">

                            <p
                                class="text-[10px] uppercase text-on-surface-variant">

                                Líquido

                            </p>

                            <p class="font-bold text-primary mt-1">

                                200ml

                            </p>

                        </div>



                        <div
                            class="p-3 rounded-xl bg-primary-container text-center">

                            <p
                                class="text-[10px] uppercase text-on-primary-container">

                                Total

                            </p>

                            <p
                                class="font-bold text-on-primary-container mt-1">

                                500ml

                            </p>

                        </div>


                    </div>

                </div>



                <div
                    class="flex items-center justify-between gap-4 mt-5 pt-4 border-t border-outline-variant/30">


                    <div>

                        <p
                            class="text-[10px] uppercase font-bold tracking-wider text-on-surface-variant">

                            Estado

                        </p>


                        <div class="flex items-center gap-2 mt-1">

                            <span
                                class="w-2 h-2 rounded-full bg-blue-500">
                            </span>

                            <span class="text-sm font-semibold">

                                En preparación

                            </span>

                        </div>

                    </div>



                    <button
                        type="button"
                        class="h-10 px-4 rounded-xl bg-primary text-on-primary text-xs font-bold hover:bg-primary-container transition flex items-center gap-2">

                        Gestionar

                        <span
                            class="material-symbols-outlined text-[17px]">

                            arrow_forward

                        </span>

                    </button>


                </div>


            </article>



            <!-- PEDIDO 3 -->
            <article
                class="group relative bg-white border border-outline-variant/40 rounded-2xl p-5 shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">


                <div class="flex items-start justify-between gap-4">


                    <div class="flex items-center gap-3 min-w-0">


                        <div
                            class="w-11 h-11 shrink-0 rounded-xl bg-primary-fixed flex items-center justify-center text-primary font-bold">

                            RB

                        </div>


                        <div class="min-w-0">

                            <h2 class="font-bold text-base truncate">

                                Roberto Benítez

                            </h2>

                            <p class="text-xs text-on-surface-variant mt-1">

                                Dra. Carmen López

                            </p>

                        </div>

                    </div>



                    <button
                        type="button"
                        class="w-9 h-9 shrink-0 rounded-lg text-on-surface-variant hover:bg-surface-container-low transition flex items-center justify-center">

                        <span class="material-symbols-outlined">

                            more_vert

                        </span>

                    </button>


                </div>



                <div
                    class="mt-5 p-3.5 rounded-xl bg-surface-container-low border border-outline-variant/30">


                    <div class="flex items-start gap-3">


                        <span
                            class="material-symbols-outlined text-secondary text-[20px]">

                            location_on

                        </span>


                        <div>

                            <p
                                class="text-[10px] uppercase tracking-wider font-bold text-on-surface-variant">

                                Ubicación

                            </p>

                            <p class="text-sm font-semibold mt-1">

                                CIR · B3 · Sala 1 · Cama 02

                            </p>

                            <p
                                class="text-xs text-on-surface-variant mt-1">

                                Cirugía General

                            </p>

                        </div>

                    </div>

                </div>



                <div class="mt-5">


                    <div class="flex items-center justify-between mb-3">

                        <p
                            class="text-xs font-bold uppercase tracking-wider text-on-surface-variant">

                            Pedido nutricional

                        </p>

                        <span class="text-xs text-on-surface-variant">

                            Enteral

                        </span>

                    </div>



                    <div class="grid grid-cols-3 gap-2">


                        <div class="p-3 rounded-xl bg-surface text-center">

                            <p
                                class="text-[10px] uppercase text-on-surface-variant">

                                Porción

                            </p>

                            <p class="font-bold text-primary mt-1">

                                150g

                            </p>

                        </div>



                        <div class="p-3 rounded-xl bg-surface text-center">

                            <p
                                class="text-[10px] uppercase text-on-surface-variant">

                                Líquido

                            </p>

                            <p class="font-bold text-primary mt-1">

                                100ml

                            </p>

                        </div>



                        <div
                            class="p-3 rounded-xl bg-primary-container text-center">

                            <p
                                class="text-[10px] uppercase text-on-primary-container">

                                Total

                            </p>

                            <p
                                class="font-bold text-on-primary-container mt-1">

                                250ml

                            </p>

                        </div>


                    </div>


                </div>



                <div
                    class="flex items-center justify-between gap-4 mt-5 pt-4 border-t border-outline-variant/30">


                    <div>

                        <p
                            class="text-[10px] uppercase font-bold tracking-wider text-on-surface-variant">

                            Estado

                        </p>


                        <div class="flex items-center gap-2 mt-1">

                            <span
                                class="w-2 h-2 rounded-full bg-emerald-500">
                            </span>

                            <span class="text-sm font-semibold">

                                Listo

                            </span>

                        </div>

                    </div>



                    <button
                        type="button"
                        class="h-10 px-4 rounded-xl bg-primary text-on-primary text-xs font-bold hover:bg-primary-container transition flex items-center gap-2">

                        Gestionar

                        <span
                            class="material-symbols-outlined text-[17px]">

                            arrow_forward

                        </span>

                    </button>


                </div>


            </article>


        </section>



        <!-- PAGINACION -->
        <section
            class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-8 pt-5 border-t border-outline-variant/40">


            <p class="text-sm text-on-surface-variant">

                Mostrando
                <span class="font-semibold text-on-surface">
                    3
                </span>

                de

                <span class="font-semibold text-on-surface">
                    12
                </span>

                pedidos

            </p>



            <div class="flex items-center gap-2">


                <button
                    type="button"
                    class="w-10 h-10 border border-outline-variant/50 bg-white rounded-xl flex items-center justify-center hover:bg-surface-container-low transition">

                    <span class="material-symbols-outlined text-[20px]">

                        chevron_left

                    </span>

                </button>



                <span
                    class="w-10 h-10 rounded-xl bg-primary text-on-primary flex items-center justify-center text-sm font-bold">

                    1

                </span>



                <button
                    type="button"
                    class="w-10 h-10 border border-outline-variant/50 bg-white rounded-xl flex items-center justify-center hover:bg-surface-container-low transition">

                    <span class="material-symbols-outlined text-[20px]">

                        chevron_right

                    </span>

                </button>


            </div>


        </section>


    </main>


</body>

</html>