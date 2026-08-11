<?php
$title = "HGI - Pacientes";
require __DIR__ . '/../../utils/head.php';

$usuarios_id = $_SESSION['user_id'];
$usuarios_rol = $_SESSION['user_rol'];
$usuarios = $_SESSION['user_nombre'] ?? 'Personal de Guardia';
?>

<body class="bg-background font-jakarta text-textDark min-h-screen flex flex-col">

    <?php require __DIR__ . '/../../utils/header.php'; ?>

    <main class="pt-28 pb-12 px-4 max-w-7xl w-full mx-auto flex-grow space-y-6">

        <section class="bg-surface border border-borderColor p-4 rounded-2xl shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
            <!--<div class="relative w-full sm:max-w-md">
                <span class="material-symbols-outlined text-textSoft absolute left-3 top-2.5 text-xl">search</span>
                <input type="text" placeholder="Buscar paciente por Nombre, Apellido o Cód. de Cédula..."
                    class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:border-primary transition-colors font-medium">
            </div>-->
            <button onclick="openModal('modal-internacion')" class="w-full sm:w-auto bg-primary hover:bg-opacity-95 text-surface text-xs font-bold px-4 py-2.5 rounded-xl flex items-center justify-center gap-2 shadow-sm transition-all whitespace-nowrap">
                <span class="material-symbols-outlined text-base">bed</span>
                <span>Registrar Nueva Internación</span>
            </button>
        </section>

        <div id="listaInternaciones" class="space-y-6"></div>

        <?php require __DIR__ . '/../../utils/footer.php'; ?>
    </main>


    <!-- MODAL DE REGISTRAR NUEVA INTERNACIÓN -->
    <div id="modal-internacion" class="modal-backdrop fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
        <div class="bg-surface w-full max-w-5xl rounded-2xl shadow-xl border border-borderColor max-h-[90vh] flex flex-col animate-fadeIn">

            <div class="p-5 border-b border-borderColor flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-2xl bg-background p-2 rounded-xl border border-borderColor">bed</span>
                    <div>
                        <h3 class="font-bold text-sm text-textDark">Nueva Internación</h3>
                        <p class="text-[10px] text-textSoft">Registro de ingreso y situación social del paciente internado - HGI</p>
                    </div>
                </div>
                <button onclick="closeModal('modal-internacion')" class="text-textSoft hover:text-textDark flex items-center">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="formInternacion" class="flex flex-col overflow-hidden m-0">

                <div class="p-6 overflow-y-auto space-y-6 text-xs">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                        <!-- COLUMNA IZQUIERDA -->
                        <div class="space-y-6 lg:border-r lg:border-borderColor lg:pr-8">

                            <!-- DATOS INGRESO -->
                            <div>
                                <h2 class="text-[10px] font-bold uppercase tracking-wider text-primary mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">clinical_notes</span>
                                    1. Datos del Ingreso
                                </h2>

                                <div class="grid grid-cols-3 gap-3">

                                    <div class="col-span-2">

                                        <label class="block text-[11px] font-bold text-textDark mb-1">
                                            Buscar Paciente <span class="text-red-500">*</span>
                                        </label>

                                        <div class="relative">
                                            <span class="material-symbols-outlined text-sm text-textSoft absolute left-3 top-2.5">
                                                search
                                            </span>

                                            <input
                                                type="text"
                                                id="buscar_paciente"
                                                placeholder="Ingrese cédula del paciente..."
                                                autocomplete="off"
                                                class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg pl-9 pr-3 py-2 focus:outline-none focus:border-primary">

                                            <input
                                                type="hidden"
                                                id="paciente_id"
                                                name="paciente_id">

                                        </div>

                                        <div
                                            id="resultadoPaciente"
                                            class="hidden mt-2 p-3 rounded-lg border border-green-200 bg-green-50">
                                        </div>

                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-bold text-textDark mb-1">
                                            Sala / Cama
                                        </label>

                                        <input
                                            type="text"
                                            id="sala"
                                            name="sala"
                                            placeholder="Ej: Sala 4 - B"
                                            class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary">
                                    </div>

                                </div>

                                <div class="grid grid-cols-2 gap-3 mt-3">

                                    <div>
                                        <label class="block text-[11px] font-bold text-textDark mb-1">
                                            Fecha de Ingreso
                                        </label>

                                        <input
                                            type="text"
                                            value="<?= date('d/m/Y') ?>"
                                            disabled
                                            class="w-full bg-background border border-borderColor text-textSoft text-xs rounded-lg px-2.5 py-1.5">
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-bold text-textDark mb-1">
                                            Fecha Entrevista Social
                                        </label>

                                        <input
                                            type="datetime-local"
                                            id="fecha_entrevista"
                                            name="fecha_entrevista"
                                            class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary">
                                    </div>

                                </div>

                            </div>

                            <!-- ENTORNO -->
                            <div class="pt-4 border-t border-borderColor">

                                <h2 class="text-[10px] font-bold uppercase tracking-wider text-primary mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">group</span>
                                    2. Entorno y Movilidad
                                </h2>

                                <div class="grid grid-cols-2 gap-3">

                                    <div>
                                        <label class="block text-[11px] font-bold text-textDark mb-1">
                                            Procedencia
                                        </label>

                                        <input
                                            type="text"
                                            id="procedencia"
                                            name="procedencia"
                                            placeholder="Ej: Urgencias"
                                            class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary">
                                    </div>

                                    <div>
                                        <label class="block text-[11px] font-bold text-textDark mb-1">
                                            Acompañante Responsable
                                        </label>

                                        <input
                                            type="text"
                                            id="acompanante"
                                            name="acompanante"
                                            placeholder="Nombre del familiar"
                                            class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary">
                                    </div>

                                </div>

                                <div class="mt-4 bg-background p-3 rounded-xl border border-borderColor flex items-center justify-between">

                                    <div class="flex items-center gap-2.5">

                                        <span class="material-symbols-outlined text-textSoft text-lg">
                                            accessibility_new
                                        </span>

                                        <div>
                                            <label class="block text-[11px] font-bold text-textDark">
                                                ¿Se desplaza solo?
                                            </label>

                                            <span class="text-[10px] text-textSoft block mt-0.5">
                                                El paciente posee autonomía de movimiento.
                                            </span>
                                        </div>

                                    </div>

                                    <input
                                        type="checkbox"
                                        id="se_desplaza_solo"
                                        name="se_desplaza_solo"
                                        value="1"
                                        checked
                                        class="accent-primary h-5 w-5 cursor-pointer">

                                </div>

                            </div>

                        </div>

                        <!-- COLUMNA DERECHA -->
                        <div class="space-y-6">

                            <div>

                                <h2 class="text-[10px] font-bold uppercase tracking-wider text-primary mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">assignment</span>
                                    3. Evaluación Social
                                </h2>

                                <div>
                                    <label class="block text-[11px] font-bold text-textDark mb-1">
                                        Patología Actual / Diagnóstico Clínico
                                        <span class="text-red-500">*</span>
                                    </label>

                                    <textarea
                                        id="patologia_actual"
                                        name="patologia_actual"
                                        rows="3"
                                        required
                                        class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary resize-none"></textarea>
                                </div>

                                <div class="mt-3">
                                    <label class="block text-[11px] font-bold text-textDark mb-1">
                                        Situación Referida
                                    </label>

                                    <textarea
                                        id="situacion_referida"
                                        name="situacion_referida"
                                        rows="4"
                                        class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary resize-none"></textarea>
                                </div>

                            </div>

                            <div class="pt-4 border-t border-borderColor">

                                <h2 class="text-[10px] font-bold uppercase tracking-wider text-primary mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">event_upcoming</span>
                                    4. Planificación
                                </h2>

                                <div>
                                    <label class="block text-[11px] font-bold text-textDark mb-1">
                                        Fecha Probable de Alta
                                    </label>

                                    <input
                                        type="date"
                                        id="posible_alta"
                                        name="posible_alta"
                                        class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary">
                                </div>

                                <div class="mt-3">
                                    <label class="block text-[11px] font-bold text-textDark mb-1">
                                        Motivo de Permanencia
                                    </label>

                                    <textarea
                                        id="motivo_permanencia"
                                        name="motivo_permanencia"
                                        rows="3"
                                        class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary resize-none"></textarea>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="p-4 bg-background border-t border-borderColor flex justify-end gap-2 rounded-b-2xl">

                    <button
                        type="button"
                        onclick="closeModal('modal-internacion')"
                        class="px-4 py-2 bg-surface text-textSoft font-bold rounded-xl border border-borderColor text-xs">

                        Cancelar

                    </button>

                    <button
                        type="submit"
                        class="px-5 py-2 bg-primary text-surface font-bold rounded-xl text-xs flex items-center gap-1.5">

                        <span class="material-symbols-outlined text-sm">
                            save
                        </span>

                        <span>
                            Registrar Internación
                        </span>

                    </button>

                </div>

            </form>

        </div>
    </div>

    <!-- MODAL 1: ANTECEDENTES SOCIALES -->
    <div id="modal-antecedente" class="modal-backdrop fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
        <div class="bg-surface w-full max-w-4xl rounded-2xl shadow-xl border border-borderColor max-h-[90vh] flex flex-col animate-fadeIn">

            <div class="p-5 border-b border-borderColor flex items-center justify-between bg-surface sticky top-0 z-10 rounded-t-2xl">
                <div class="flex items-center gap-4">
                    <span class="material-symbols-outlined text-primary text-3xl bg-background p-3 rounded-xl border border-borderColor">
                        person_add
                    </span>
                    <div>
                        <h1 class="text-xl font-bold text-primary">Registro de Paciente</h1>
                        <p class="text-textSoft text-[11px] lg:text-xs">Formulario de alta para el Sistema de Acción Social - Hospital General de Itapúa</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">

                    <button onclick="closeModal('modal-antecedente')" class="text-textSoft hover:text-textDark flex items-center transition-colors" type="button" aria-label="Cerrar modal">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            </div>

            <form id="formPaciente" class="flex flex-col overflow-hidden m-0 flex-1">

                <input type="hidden" id="paciente_edit_id" name="id">

                <div class="p-6 overflow-y-auto space-y-6 text-xs flex-1">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">

                        <div class="space-y-6 lg:border-r lg:border-borderColor lg:pr-8">

                            <div>
                                <h2 class="text-[11px] font-bold uppercase tracking-wider text-primary mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">badge</span>
                                    1. Identificación y Personales
                                </h2>

                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label for="tipo_documento" class="block text-[11px] font-bold text-textDark mb-1">Tipo Doc.</label>
                                        <select id="tipo_documento" name="tipo_documento" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors cursor-pointer">
                                            <option value="Cedula" selected>Cédula</option>
                                            <option value="Pasaporte">Pasaporte</option>
                                            <option value="Sin Documento">Sin Documento</option>
                                            <option value="Desconocido">Desconocido</option>
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <label for="cedula" class="block text-[11px] font-bold text-textDark mb-1">Número de Documento / Cédula</label>
                                        <input type="text" id="cedula" name="cedula" placeholder="Ej: 1234567" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label for="nombre_completo" class="block text-[11px] font-bold text-textDark mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                                    <input type="text" id="nombre_completo" name="nombre_completo" required placeholder="Como figura en la cédula" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                </div>

                                <div class="mt-3">
                                    <label for="nombre_social" class="block text-[11px] font-bold text-textDark mb-1">Nombre Social <span class="text-[10px] font-normal text-textSoft">(Opcional)</span></label>
                                    <input type="text" id="nombre_social" name="nombre_social" placeholder="Nombre por el cual prefiere ser llamado" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                </div>

                                <div class="grid grid-cols-2 gap-3 mt-3">
                                    <div>
                                        <label for="fecha_nacimiento" class="block text-[11px] font-bold text-textDark mb-1">Fecha de Nacimiento</label>
                                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary transition-colors">
                                    </div>
                                    <div>
                                        <span class="block text-[11px] font-bold text-textDark mb-1">Sexo</span>
                                        <div class="flex gap-4 mt-2">
                                            <label class="inline-flex items-center cursor-pointer text-xs">
                                                <input type="radio" name="sexo" value="Masculino" class="accent-primary h-4 w-4">
                                                <span class="ml-2 text-textSoft font-medium">Masculino</span>
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer text-xs">
                                                <input type="radio" name="sexo" value="Femenino" class="accent-primary h-4 w-4">
                                                <span class="ml-2 text-textSoft font-medium">Femenino</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-borderColor">
                                <h2 class="text-[11px] font-bold uppercase tracking-wider text-primary mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">call</span>
                                    2. Información de Contacto
                                </h2>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label for="telefono" class="block text-[11px] font-bold text-textDark mb-1">Teléfono / Celular</label>
                                        <input type="tel" id="telefono" name="telefono" placeholder="Ej: 0981 123456" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                    </div>
                                    <div>
                                        <label for="correo" class="block text-[11px] font-bold text-textDark mb-1">Correo Electrónico</label>
                                        <input type="email" id="correo" name="correo" placeholder="ejemplo@correo.com" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="space-y-6">
                            <div>
                                <h2 class="text-[11px] font-bold uppercase tracking-wider text-primary mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm">home_pin</span>
                                    3. Residencia Habitual
                                </h2>

                                <div class="grid grid-cols-3 gap-3">
                                    <div>
                                        <label for="departamento" class="block text-[11px] font-bold text-textDark mb-1">Departamento</label>
                                        <input type="text" id="departamento" name="departamento" placeholder="Itapúa" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                    </div>
                                    <div>
                                        <label for="distrito" class="block text-[11px] font-bold text-textDark mb-1">Distrito</label>
                                        <input type="text" id="distrito" name="distrito" placeholder="Encarnación" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                    </div>
                                    <div>
                                        <label for="barrio" class="block text-[11px] font-bold text-textDark mb-1">Barrio</label>
                                        <input type="text" id="barrio" name="barrio" placeholder="Centro" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                    </div>
                                </div>

                                <div class="grid grid-cols-3 gap-3 mt-3">
                                    <div>
                                        <label for="sector" class="block text-[11px] font-bold text-textDark mb-1">Sector</label>
                                        <input type="text" id="sector" name="sector" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                    </div>
                                    <div>
                                        <label for="manzana" class="block text-[11px] font-bold text-textDark mb-1">Manzana</label>
                                        <input type="text" id="manzana" name="manzana" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                    </div>
                                    <div>
                                        <label for="casa" class="block text-[11px] font-bold text-textDark mb-1">Nº Casa</label>
                                        <input type="text" id="casa" name="casa" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label for="direccion" class="block text-[11px] font-bold text-textDark mb-1">Dirección Exacta</label>
                                    <input type="text" id="direccion" name="direccion" placeholder="Calle principal y transversales" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                </div>

                                <div class="mt-3">
                                    <label for="residencia_ocasional" class="block text-[11px] font-bold text-textDark mb-1">Residencia Ocasional <span class="text-[10px] font-normal text-textSoft">(Si aplica)</span></label>
                                    <input type="text" id="residencia_ocasional" name="residencia_ocasional" placeholder="Lugar o localidad temporal" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-3 items-end">
                                    <div class="sm:col-span-2">
                                        <label for="referencia" class="block text-[11px] font-bold text-textDark mb-1">Punto de Referencia</label>
                                        <input type="text" id="referencia" name="referencia" placeholder="Ej: Frente a la iglesia, cerca de..." class="w-full bg-background border border-borderColor text-textDark text-xs rounded-lg px-3 py-2 focus:outline-none focus:border-primary transition-colors">
                                    </div>
                                    <div class="bg-background p-2 rounded-lg border border-borderColor">
                                        <span class="block text-[10px] font-bold text-textDark mb-1">Área Geográfica</span>
                                        <div class="flex gap-3">
                                            <label class="inline-flex items-center cursor-pointer text-[11px]">
                                                <input type="radio" name="area" value="Urbana" class="accent-primary h-3.5 w-3.5">
                                                <span class="ml-1 text-textSoft font-medium">Urbana</span>
                                            </label>
                                            <label class="inline-flex items-center cursor-pointer text-[11px]">
                                                <input type="radio" name="area" value="Rural" class="accent-primary h-3.5 w-3.5">
                                                <span class="ml-1 text-textSoft font-medium">Rural</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="p-4 bg-background border-t border-borderColor flex justify-end gap-2 rounded-b-2xl sticky bottom-0 z-10">
                    <button type="button" onclick="closeModal('modal-antecedente')" class="px-4 py-2 bg-surface text-textSoft font-bold rounded-xl border border-borderColor text-xs hover:bg-background transition-colors">
                        Cancelar
                    </button>

                    <button type="submit" class="px-5 py-2 bg-primary hover:bg-opacity-95 text-surface font-bold rounded-xl text-xs flex items-center gap-1.5 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-sm">save</span>
                        <span>Guardar Paciente</span>
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- MODAL 2: SOCIOECONÓMICO Y VIVIENDA  EN PROSESO -->
    <div id="modal-socioeconomico" class="fixed inset-0 z-50 hidden bg-textDark/40 backdrop-blur-sm flex items-center justify-center p-4 font-jakarta">
        <div class="w-full max-w-6xl bg-surface rounded-[32px] shadow-2xl border border-borderColor flex flex-col h-[92vh] overflow-hidden animate-fadeIn">

            <div class="flex items-center justify-between p-6 border-b border-borderColor bg-background/50">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary text-2xl bg-surface p-2.5 rounded-2xl border border-borderColor shadow-sm">analytics</span>
                    <div>
                        <h1 class="text-xl font-extrabold text-textDark">II PARTE: ANTECEDENTES</h1>
                        <p class="text-textSoft text-xs">Informe Socio-Económico, Infraestructura y Composición del Cuadro Familiar.</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('modal-socioeconomico')" class="text-textSoft hover:text-textDark p-2 rounded-xl hover:bg-background transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <div class="flex border-b border-borderColor bg-background px-6 gap-2">
                <button type="button" onclick="switchSocioTab('tab-economica')" id="btn-tab-economica" class="socio-tab-btn px-4 py-3 text-xs font-bold border-b-2 border-primary text-primary transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">payments</span> 1. Situación Socio-Económica
                </button>
                <button type="button" onclick="switchSocioTab('tab-vivienda')" id="btn-tab-vivienda" class="socio-tab-btn px-4 py-3 text-xs font-bold border-b-2 border-transparent text-textSoft hover:text-textDark transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">home</span> 2. Vivienda y Servicios
                </button>
                <button type="button" onclick="switchSocioTab('tab-familiar')" id="btn-tab-familiar" class="socio-tab-btn px-4 py-3 text-xs font-bold border-b-2 border-transparent text-textSoft hover:text-textDark transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">group</span> 3. Cuadro Familiar y Contactos
                </button>
            </div>

            <form id="formAntecedentes" class="flex flex-col flex-1 overflow-hidden m-0">
                <input type="hidden" id="socio_paciente_id" name="paciente_id">

                <div class="flex-1 overflow-y-auto p-8 bg-white text-xs">

                    <div id="tab-economica" class="socio-tab-content space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                            <div class="space-y-4">
                                <h3 class="text-xs font-bold text-primary uppercase tracking-wider border-b pb-2 border-borderColor">10.1 Vivienda - Tenencia & Laboral</h3>
                                <div>
                                    <label for="tenencia" class="block text-[11px] font-bold text-textDark mb-1">Tenencia de la Vivienda</label>
                                    <select id="tenencia" name="tenencia" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary cursor-pointer">
                                        <option value="" disabled selected>Seleccione...</option>
                                        <option value="1">1. Ocupación</option>
                                        <option value="2">2. Asentamiento Fiscal – Encargado</option>
                                        <option value="3">3. Con Familiares – Propio</option>
                                        <option value="4">4. Amortizando (especificar)</option>
                                        <option value="5">5. Propietario con Título</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="detalle_tenencia" class="block text-[11px] font-bold text-textDark mb-1">Especificar / Amortizando Detalle</label>
                                    <input type="text" id="detalle_tenencia" name="detalle_tenencia" placeholder="Detalles de cuotas o amortización" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary">
                                </div>
                                <div class="pt-2">
                                    <h4 class="text-[11px] font-bold text-textDark mb-2">10.2 Antecedentes Laborales</h4>
                                    <div class="space-y-3">
                                        <input type="text" name="lugar_trabajo" placeholder="1. Lugar de Trabajo" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary">
                                        <input type="text" name="direccion_laboral" placeholder="2. Dirección Laboral" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-bold text-textDark mb-1">3. Frecuencia Salario</label>
                                        <select name="salario_tipo" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary cursor-pointer">
                                            <option value="Diario">Diario</option>
                                            <option value="Semanal">Semanal</option>
                                            <option value="Quincenal">Quincenal</option>
                                            <option value="Mensual">Mensual</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-textDark mb-1">Monto Especificar (Gs.)</label>
                                        <input type="number" name="salario_monto" placeholder="Monto exacto" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary text-right">
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <h3 class="text-xs font-bold text-primary uppercase tracking-wider border-b pb-2 border-borderColor">10.3 Beneficios Sociales & 10.4 Manutención</h3>
                                <div class="grid grid-cols-2 gap-3 items-center bg-background p-3 rounded-xl border border-borderColor">
                                    <span class="text-[11px] font-bold text-textDark">¿Recibe Beneficios del Gobierno?</span>
                                    <div class="flex gap-4 justify-end">
                                        <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="recibe_beneficio" value="0" checked class="accent-primary"> No</label>
                                        <label class="flex items-center gap-1.5 cursor-pointer"><input type="radio" name="recibe_beneficio" value="1" class="accent-primary"> Sí</label>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <label class="text-[11px] font-bold text-textDark">Detalle de Beneficios Estatales</label>
                                        <button type="button" id="btn-add-beneficio" class="text-[10px] text-primary font-bold hover:underline flex items-center gap-0.5"><span class="material-symbols-outlined text-xs">add</span> Agregar Fila</button>
                                    </div>
                                    <div id="contenedor-beneficios" class="space-y-2 border border-borderColor rounded-xl p-2 bg-background/30">
                                    </div>
                                </div>

                                <div class="pt-2">
                                    <h4 class="text-[11px] font-bold text-textDark mb-2">10.4 Manutención del Hogar</h4>
                                    <div class="grid grid-cols-2 gap-2">
                                        <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="radio" name="manutencion" value="El Paciente" class="accent-primary"> 1. El Paciente</label>
                                        <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="radio" name="manutencion" value="Familiar" class="accent-primary"> 2. Familiar</label>
                                        <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="radio" name="manutencion" value="No Pariente" class="accent-primary"> 3. No Pariente</label>
                                        <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="radio" name="manutencion" value="Especificar" class="accent-primary"> 4. Especificar</label>
                                    </div>
                                    <input type="text" name="manutencion_especificar" placeholder="Detalle de manutención o nombres" class="w-full mt-2 bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab-vivienda" class="socio-tab-content hidden space-y-6">
                        <h3 class="text-xs font-bold text-primary uppercase tracking-wider border-b pb-2 border-borderColor">10.5 Vivienda & 10.6 - 10.7 Servicios Sanitarios / Básicos</h3>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="pared" class="block text-[11px] font-bold text-textDark mb-1">1. PARED</label>
                                <select id="pared" name="pared" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary cursor-pointer">
                                    <option value="1">1. Ladrillo</option>
                                    <option value="2">2. Madera</option>
                                    <option value="3">3. Estaqueo</option>
                                    <option value="4">4. Adobe</option>
                                    <option value="5">5. Bloque de Cemento</option>
                                    <option value="6">6. Tronco de Palma</option>
                                    <option value="7">7. Cartón, hule, madera de embalaje</option>
                                    <option value="8">8. No tiene Pared</option>
                                    <option value="9">9. Otro</option>
                                </select>
                            </div>
                            <div>
                                <label for="techo" class="block text-[11px] font-bold text-textDark mb-1">2. TECHO</label>
                                <select id="techo" name="techo" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary cursor-pointer">
                                    <option value="1">1. Teja</option>
                                    <option value="2">2. Paja</option>
                                    <option value="3">3. Fibrocemento o Eternit</option>
                                    <option value="4">4. Chapas de Zinc</option>
                                    <option value="5">5. Tablilla de madera</option>
                                    <option value="6">6. Hormigón armado, loza o bovedilla</option>
                                    <option value="7">7. Tronco de Palma</option>
                                    <option value="8">8. Cartón, hule, madera de embalaje</option>
                                    <option value="9">9. Otro</option>
                                </select>
                            </div>
                            <div>
                                <label for="piso" class="block text-[11px] font-bold text-textDark mb-1">3. PISO</label>
                                <select id="piso" name="piso" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary cursor-pointer">
                                    <option value="1">1. Tierra</option>
                                    <option value="2">2. Ladrillo</option>
                                    <option value="3">3. Baldosa Común</option>
                                    <option value="4">4. Cemento (lecherada)</option>
                                    <option value="5">5. Mosaico, cerámica, granito, mármol</option>
                                    <option value="6">6. Tablón de Madera</option>
                                    <option value="7">7. Parquet</option>
                                    <option value="8">8. Alfombra</option>
                                    <option value="9">9. Otro</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                            <div>
                                <label for="servicio_agua" class="block text-[11px] font-bold text-textDark mb-1">1. AGUA</label>
                                <select id="servicio_agua" name="servicio_agua" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary cursor-pointer">
                                    <option value="1">1. ESSAP/SENASA</option>
                                    <option value="2">2. Pozo sin bomba</option>
                                    <option value="3">3. Pozo con bomba</option>
                                    <option value="4">4. Red Privada</option>
                                    <option value="5">5. Tajamar, naciente, río o arroyo</option>
                                    <option value="6">6. Aljibe</option>
                                    <option value="7">7. Otro</option>
                                </select>
                            </div>
                            <div>
                                <label for="eliminacion_basura" class="block text-[11px] font-bold text-textDark mb-1">2. ELIMINACIÓN DE BASURA</label>
                                <select id="eliminacion_basura" name="eliminacion_basura" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary cursor-pointer">
                                    <option value="1">1. Quema</option>
                                    <option value="2">2. La recoge camión o carrito de basura</option>
                                    <option value="3">3. Tira en el hoyo</option>
                                    <option value="4">4. Tira en el patio, baldío, zanja o calle</option>
                                    <option value="5">5. Tira en la chacra</option>
                                    <option value="6">6. Tira en arroyo, río o laguna</option>
                                    <option value="7">7. Otro</option>
                                </select>
                            </div>
                            <div>
                                <label for="desague_banio" class="block text-[11px] font-bold text-textDark mb-1">3. EL BAÑO SE DESAGÜA EN</label>
                                <select id="desague_banio" name="desague_banio" class="w-full bg-background border border-borderColor text-textDark text-xs rounded-xl px-3 py-2.5 focus:outline-none focus:border-primary cursor-pointer">
                                    <option value="1">1. Hoyo o Pozo</option>
                                    <option value="2">2. Pozo ciego</option>
                                    <option value="3">3. Red Pública (cloaca)</option>
                                    <option value="4">4. La superficie de la tierra, arroyo, río, etc</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                            <div class="space-y-3">
                                <span class="block text-[11px] font-bold text-textDark">4. DEPENDENCIAS DE LA VIVIENDA</span>
                                <div class="grid grid-cols-3 gap-2">
                                    <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="checkbox" name="dependencias[]" value="Sala" class="accent-primary"> Sala</label>
                                    <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="checkbox" name="dependencias[]" value="Comedor" class="accent-primary"> Comedor</label>
                                    <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="checkbox" name="dependencias[]" value="Cocina" class="accent-primary"> Cocina</label>
                                    <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="checkbox" name="dependencias[]" value="Baño" class="accent-primary"> Baño</label>
                                </div>
                                <div class="grid grid-cols-2 gap-2 pt-1">
                                    <div>
                                        <label class="block text-[10px] font-bold text-textSoft mb-0.5">5. N° Dormitorios</label>
                                        <input type="number" name="dormitorios_n" min="0" class="w-full bg-background border border-borderColor text-xs rounded-lg p-2 focus:outline-none">
                                    </div>
                                    <div>
                                        <label class="block text-[10px] font-bold text-textSoft mb-0.5">5. N° Personas en Hogar</label>
                                        <input type="number" name="personas_hogar_n" min="1" class="w-full bg-background border border-borderColor text-xs rounded-lg p-2 focus:outline-none">
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 pt-1">
                                    <div class="flex items-center justify-between p-2 bg-background border border-borderColor rounded-xl">
                                        <span class="font-bold text-textDark text-[11px]">6. Hacinamiento</span>
                                        <div class="flex gap-2"><label><input type="radio" name="hacinamiento" value="1"> Sí</label><label><input type="radio" name="hacinamiento" value="0" checked> No</label></div>
                                    </div>
                                    <div class="flex items-center justify-between p-2 bg-background border border-borderColor rounded-xl">
                                        <span class="font-bold text-textDark text-[11px]">6. Comparte cama</span>
                                        <div class="flex gap-2"><label><input type="radio" name="comparte_cama" value="1"> Sí</label><label><input type="radio" name="comparte_cama" value="0" checked> No</label></div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <span class="block text-[11px] font-bold text-textDark mb-2">10.7 SERVICIOS BÁSICOS DISPONIBLES</span>
                                <div class="grid grid-cols-2 gap-2">
                                    <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="checkbox" name="servicios_basicos[]" value="Luz Electrica" class="accent-primary"> 1. Luz Eléctrica</label>
                                    <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="checkbox" name="servicios_basicos[]" value="Telef. Linea Baja" class="accent-primary"> 2. Teléf. Línea Baja</label>
                                    <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="checkbox" name="servicios_basicos[]" value="Telef. Celular" class="accent-primary"> 3. Teléf. Celular</label>
                                    <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="checkbox" name="servicios_basicos[]" value="Heladera" class="accent-primary"> 4. Heladera</label>
                                    <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="checkbox" name="servicios_basicos[]" value="TV" class="accent-primary"> 5. TV</label>
                                    <label class="flex items-center gap-2 p-2 bg-background border border-borderColor rounded-xl cursor-pointer"><input type="checkbox" name="servicios_basicos[]" value="Otros" class="accent-primary"> 6. Otros</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="tab-familiar" class="socio-tab-content hidden space-y-6">

                        <div>
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="text-xs font-bold text-primary uppercase tracking-wider">11. Cuadro Familiar (Cohabitantes del Hogar)</h3>
                                <button type="button" id="btn-add-familiar" class="text-[10px] bg-primary text-white font-bold px-3 py-1 rounded-lg flex items-center gap-1 hover:opacity-90 transition-all"><span class="material-symbols-outlined text-xs">add</span> Agregar Integrante</button>
                            </div>
                            <div class="border border-borderColor rounded-xl overflow-hidden shadow-sm bg-background">
                                <table class="w-full border-collapse text-left text-[11px]">
                                    <thead class="bg-slate-100 font-bold text-textDark border-b border-borderColor text-center">
                                        <tr>
                                            <th class="p-2 border-r border-borderColor w-[12%]">CI</th>
                                            <th class="p-2 border-r border-borderColor w-[25%]">Nombre y Apellido</th>
                                            <th class="p-2 border-r border-borderColor w-[12%]">Parentesco</th>
                                            <th class="p-2 border-r border-borderColor w-[12%]">Estado Civil</th>
                                            <th class="p-2 border-r border-borderColor w-[12%]">Escolaridad</th>
                                            <th class="p-2 border-r border-borderColor w-[7%]">Edad</th>
                                            <th class="p-2 border-r border-borderColor w-[12%]">Ocupación</th>
                                            <th class="p-2 border-r border-borderColor w-[12%]">Ingresos</th>
                                            <th class="p-2 w-[5%]">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody-cuadro-familiar" class="bg-white divide-y divide-borderColor">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-borderColor space-y-4">
                            <div class="flex justify-between items-center">
                                <h3 class="text-xs font-bold text-primary uppercase tracking-wider">11.1 Datos de Persona para Contacto / Emergencia</h3>
                                <label class="flex items-center gap-1.5 font-bold cursor-pointer text-textDark"><input type="checkbox" name="croquis_domicilio" value="1" class="accent-primary"> a) Croquis de domicilio</label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div><label class="block text-[10px] font-bold text-textSoft mb-1">b) Documento Identificación N°</label><input type="text" name="contacto_ci" class="w-full bg-background border border-borderColor text-xs rounded-lg p-2 focus:outline-none"></div>
                                <div class="md:col-span-2"><label class="block text-[10px] font-bold text-textSoft mb-1">c) Apellido(s) y Nombre(s)</label><input type="text" name="contacto_nombre" class="w-full bg-background border border-borderColor text-xs rounded-lg p-2 focus:outline-none"></div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div><label class="block text-[10px] font-bold text-textSoft mb-1">d) Vínculo</label><input type="text" name="contacto_vinculo" class="w-full bg-background border border-borderColor text-xs rounded-lg p-2 focus:outline-none"></div>
                                <div><label class="block text-[10px] font-bold text-textSoft mb-1">e) N° Teléfono</label><input type="text" name="contacto_telefono" class="w-full bg-background border border-borderColor text-xs rounded-lg p-2 focus:outline-none"></div>
                                <div><label class="block text-[10px] font-bold text-textSoft mb-1">f) Dirección</label><input type="text" name="contacto_direccion" class="w-full bg-background border border-borderColor text-xs rounded-lg p-2 focus:outline-none"></div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div><label class="block text-[10px] font-bold text-textSoft mb-1">g) Distrito</label><input type="text" name="contacto_distrito" class="w-full bg-background border border-borderColor text-xs rounded-lg p-2 focus:outline-none"></div>
                                <div><label class="block text-[10px] font-bold text-textSoft mb-1">h) Departamento</label><input type="text" name="contacto_departamento" class="w-full bg-background border border-borderColor text-xs rounded-lg p-2 focus:outline-none"></div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="p-5 bg-background border-t border-borderColor flex justify-end gap-2 rounded-b-2xl">
                    <button type="button" onclick="closeModal('modal-socioeconomico')" class="px-5 py-2.5 bg-white text-textSoft font-bold rounded-xl border border-borderColor text-xs hover:bg-slate-50 transition-all">Cancelar</button>
                    <button type="submit" class="px-6 py-2.5 bg-primary hover:opacity-95 text-surface font-bold rounded-xl text-xs flex items-center gap-1.5 transition-all shadow-sm">
                        <span class="material-symbols-outlined text-sm">save</span>
                        <span>Guardar Ficha Completa</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: Antecedentes Sociales -->
    <div id="modal-antecedente-salud" class="modal-backdrop fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
        <div class="bg-surface w-full max-w-4xl rounded-2xl shadow-xl border border-borderColor max-h-[90vh] flex flex-col animate-fadeIn">

            <div class="p-5 border-b border-borderColor flex items-center justify-between bg-white rounded-t-2xl">
                <div class="flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-primary">analytics</span>
                    <div>
                        <h3 class="font-bold text-sm text-textDark">13. Formulario de Antecedentes Sociales</h3>
                        <p class="text-[10px] text-textSoft">Factores de formación, autonomía, participación y redes de apoyo</p>
                    </div>
                </div>
                <button onclick="closeModal('modal-antecedente-salud')" class="text-textSoft hover:text-textDark flex items-center transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="formAntecedentesSociales" class="flex flex-col flex-1 overflow-hidden m-0">

                <input type="hidden" id="sociol_paciente_id" name="paciente_id">

                <div class="p-6 overflow-y-auto space-y-6 bg-background/50 flex-1">

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                        <div class="bg-white p-4 rounded-xl border border-borderColor shadow-sm space-y-3">
                            <h3 class="text-xs font-bold text-primary uppercase tracking-wider border-b border-borderColor/50 pb-1.5">13.1. Formación e Información</h3>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px] gap-4">
                                    <span class="text-textDark font-medium">1. Información de la realidad social y cultural</span>
                                    <div class="flex gap-3 shrink-0">
                                        <label class="inline-flex items-center gap-1 cursor-pointer text-textDark"><input type="radio" name="formacion_realidad" value="1" class="accent-primary"> Sí</label>
                                        <label class="inline-flex items-center gap-1 cursor-pointer text-textDark"><input type="radio" name="formacion_realidad" value="0" class="accent-red-500"> No</label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px] gap-4">
                                    <span class="text-textDark font-medium">2. Información de derechos sociales y sistemas de protección sociales</span>
                                    <div class="flex gap-3 shrink-0">
                                        <label class="inline-flex items-center gap-1 cursor-pointer text-textDark"><input type="radio" name="formacion_derechos" value="1" class="accent-primary"> Sí</label>
                                        <label class="inline-flex items-center gap-1 cursor-pointer text-textDark"><input type="radio" name="formacion_derechos" value="0" class="accent-red-500"> No</label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px] gap-4">
                                    <span class="text-textDark font-medium">3. Información sobre servicios y recursos comunitarios</span>
                                    <div class="flex gap-3 shrink-0">
                                        <label class="inline-flex items-center gap-1 cursor-pointer text-textDark"><input type="radio" name="formacion_servicios" value="1" class="accent-primary"> Sí</label>
                                        <label class="inline-flex items-center gap-1 cursor-pointer text-textDark"><input type="radio" name="formacion_servicios" value="0" class="accent-red-500"> No</label>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px] gap-4">
                                    <span class="text-textDark font-medium">4. Manejo y utilización de Internet</span>
                                    <div class="flex gap-3 shrink-0">
                                        <label class="inline-flex items-center gap-1 cursor-pointer text-textDark"><input type="radio" name="formacion_internet" value="1" class="accent-primary"> Sí</label>
                                        <label class="inline-flex items-center gap-1 cursor-pointer text-textDark"><input type="radio" name="formacion_internet" value="0" class="accent-red-500"> No</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-borderColor shadow-sm space-y-4">
                            <h3 class="text-xs font-bold text-primary uppercase tracking-wider border-b border-borderColor/50 pb-1.5">13.2. Discapacidad e Incapacidad</h3>
                            <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                <span class="font-bold text-textDark">¿Posees algún grado de discapacidad?</span>
                                <div class="flex gap-4">
                                    <label class="inline-flex items-center gap-1 cursor-pointer"><input type="radio" name="discapacidad_tiene" value="1" id="disc_si" class="accent-primary"> 1. Sí</label>
                                    <label class="inline-flex items-center gap-1 cursor-pointer"><input type="radio" name="discapacidad_tiene" value="0" id="disc_no" checked class="accent-red-500"> 2. No</label>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-[11px]">
                                <div>
                                    <label class="block text-textSoft mb-1 font-medium">Grado u observación</label>
                                    <input type="text" name="discapacidad_grado" placeholder="Ej. 33%" disabled id="input_disc_grado" class="w-full bg-background border border-borderColor rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary disabled:opacity-50 transition-opacity">
                                </div>
                                <div>
                                    <label class="block text-textSoft mb-1 font-medium">Nivel de Dependencia</label>
                                    <input type="text" name="discapacidad_dependencia" placeholder="Ej. Severa o Moderada" disabled id="input_disc_dep" class="w-full bg-background border border-borderColor rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary disabled:opacity-50 transition-opacity">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div class="bg-white p-4 rounded-xl border border-borderColor shadow-sm space-y-3">
                            <h3 class="text-xs font-bold text-primary uppercase tracking-wider border-b border-borderColor/50 pb-1.5">13.3. Organización de la vida diaria</h3>
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                    <span class="text-textDark font-medium">1. Higiene</span>
                                    <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="vida_higiene" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="vida_higiene" value="0"> No</label></div>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                    <span class="text-textDark font-medium">2. Alimentación</span>
                                    <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="vida_alimentacion" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="vida_alimentacion" value="0"> No</label></div>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                    <span class="text-textDark font-medium">3. Tareas domésticas</span>
                                    <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="vida_tareas" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="vida_tareas" value="0"> No</label></div>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                    <span class="text-textDark font-medium">4. Administración económica</span>
                                    <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="vida_administracion" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="vida_administracion" value="0"> No</label></div>
                                </div>
                                <div class="p-2 bg-background rounded-lg text-[11px] space-y-2 border border-dashed border-borderColor/60">
                                    <div class="flex items-center justify-between">
                                        <span class="text-textDark font-bold">5. Otros, detallar</span>
                                        <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="vida_otros" value="1" id="vida_otros_si"> Sí</label><label class="cursor-pointer"><input type="radio" name="vida_otros" value="0" id="vida_otros_no" checked> No</label></div>
                                    </div>
                                    <input type="text" name="vida_otros_detalle" placeholder="Especifique otros aspectos de vida diaria..." disabled id="input_vida_otros" class="w-full bg-white border border-borderColor rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary disabled:opacity-50">
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl border border-borderColor shadow-sm space-y-3">
                            <h3 class="text-xs font-bold text-primary uppercase tracking-wider border-b border-borderColor/50 pb-1.5">13.4. Ejercicio de la participación social</h3>
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                    <span class="text-textDark font-medium">1. Actividades de relaciones sociales (antigüedad > 1 año)</span>
                                    <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="part_antiguedad" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="part_antiguedad" value="0"> No</label></div>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                    <span class="text-textDark font-medium">2. Voluntariado Social</span>
                                    <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="part_voluntariado" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="part_voluntariado" value="0"> No</label></div>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                    <span class="text-textDark font-medium">3. Recreación</span>
                                    <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="part_recreacion" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="part_recreacion" value="0"> No</label></div>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                    <span class="text-textDark font-medium">4. Asociacionismo</span>
                                    <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="part_asociacionismo" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="part_asociacionismo" value="0"> No</label></div>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                    <span class="text-textDark font-medium">5. Participación en espacios públicos</span>
                                    <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="part_espacios" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="part_espacios" value="0"> No</label></div>
                                </div>
                                <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                    <span class="text-textDark font-medium">6. De Delegados</span>
                                    <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="part_delegados" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="part_delegados" value="0"> No</label></div>
                                </div>
                                <div class="p-2 bg-background rounded-lg text-[11px] space-y-2 border border-dashed border-borderColor/60">
                                    <div class="flex items-center justify-between">
                                        <span class="text-textDark font-bold">7. Otros, detallar</span>
                                        <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="part_otros" value="1" id="part_otros_si"> Sí</label><label class="cursor-pointer"><input type="radio" name="part_otros" value="0" id="part_otros_no" checked> No</label></div>
                                    </div>
                                    <input type="text" name="part_otros_detalle" placeholder="Especifique participación..." disabled id="input_part_otros" class="w-full bg-white border border-borderColor rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary disabled:opacity-50">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-borderColor shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-primary uppercase tracking-wider border-b border-borderColor/50 pb-1.5">13.5 Relaciones, vínculos y recepción de apoyo social para la convivencia</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                <span class="text-textDark font-medium">1. Relaciones y vínculos afectivos familiares</span>
                                <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="apoyo_afectivos" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="apoyo_afectivos" value="0"> No</label></div>
                            </div>
                            <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                <span class="text-textDark font-medium">2. Relaciones sociales y vecinales</span>
                                <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="apoyo_vecinales" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="apoyo_vecinales" value="0"> No</label></div>
                            </div>
                            <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                <span class="text-textDark font-medium">3. Referencia histórica, proceso de socialización</span>
                                <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="apoyo_historica" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="apoyo_historica" value="0"> No</label></div>
                            </div>
                            <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                <span class="text-textDark font-medium">4. Redes primarias/secundarias proveedoras de apoyo</span>
                                <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="apoyo_primarias" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="apoyo_primarias" value="0"> No</label></div>
                            </div>
                            <div class="flex items-center justify-between p-2 bg-background rounded-lg text-[11px]">
                                <span class="text-textDark font-medium">5. Vínculo con redes institucionales</span>
                                <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="apoyo_institucionales" value="1"> Sí</label><label class="cursor-pointer"><input type="radio" name="apoyo_institucionales" value="0"> No</label></div>
                            </div>
                            <div class="p-2 bg-background rounded-lg text-[11px] space-y-2 border border-dashed border-borderColor/60">
                                <div class="flex items-center justify-between">
                                    <span class="text-textDark font-bold">6. Otros, detallar</span>
                                    <div class="flex gap-3"><label class="cursor-pointer"><input type="radio" name="apoyo_otros" value="1" id="apoyo_otros_si"> Sí</label><label class="cursor-pointer"><input type="radio" name="apoyo_otros" value="0" id="apoyo_otros_no" checked> No</label></div>
                                </div>
                                <input type="text" name="apoyo_otros_detalle" placeholder="Especifique apoyos..." disabled id="input_apoyo_otros" class="w-full bg-white border border-borderColor rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary disabled:opacity-50">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="p-4 bg-white border-t border-borderColor flex justify-end gap-2 rounded-b-2xl shadow-[0_-4px_12px_rgba(0,0,0,0.02)]">
                    <button type="button" onclick="closeModal('modal-antecedente-salud')" class="px-4 py-2 bg-surface hover:bg-background text-textSoft font-bold rounded-xl border border-borderColor text-xs transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-5 py-2 bg-primary hover:bg-primaryDark text-surface font-bold rounded-xl text-xs flex items-center gap-1.5 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-sm">save</span> Guardar Antecedentes
                    </button>
                </div>

            </form>
        </div>
    </div>


    <!-- MODAL 4: Informes Social -->
    <div id="modal-informe" class="modal-backdrop fixed inset-0 bg-black/50 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
        <div class="bg-surface w-full max-w-4xl rounded-2xl shadow-xl border border-borderColor max-h-[90vh] flex flex-col animate-fadeIn">

            <div class="p-5 border-b border-borderColor flex items-center justify-between bg-white rounded-t-2xl">
                <div class="flex items-center gap-2.5">
                    <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-xl">history_edu</span>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-bold text-sm text-textDark">Informes Sociales</h3>
                            <span class="inline-block bg-primary/10 text-primary text-[9px] uppercase tracking-wider font-bold px-2 py-0.5 rounded" id="txtModoFormulario">
                                Modo: Nuevo Registro
                            </span>
                        </div>
                        <p class="text-[10px] text-textSoft">Historial cronológico, evaluación situacional y cierre oficial del Licenciado/a en Trabajo Social</p>
                    </div>
                </div>
                <button type="button" onclick="closeModal('modal-informe')" class="text-textSoft hover:text-textDark flex items-center transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form id="formInformeSocial" class="flex flex-col flex-1 overflow-hidden m-0">
                <input type="hidden" id="informe_paciente_id" name="paciente_id">

                <div class="p-6 overflow-y-auto space-y-5 bg-background/40 flex-1 text-[11px]">

                    <div class="bg-white p-4 rounded-xl border border-borderColor shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-primary uppercase tracking-wider border-b border-borderColor/50 pb-1.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">apartment</span> 1. Datos de Referencia e Institución
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-textDark font-medium mb-1">Institución Destino / Solicitante</label>
                                <input type="text" name="institucion" placeholder="Ej. Juzgado de la Niñez, Hospital..." class="w-full bg-background border border-borderColor rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary text-xs">
                            </div>
                            <div>
                                <label class="block text-textDark font-medium mb-1">Dirección de la Institución</label>
                                <input type="text" name="direccion_institucion" placeholder="Ej. Avda. Japón c/ Culmey" class="w-full bg-background border border-borderColor rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary text-xs">
                            </div>
                            <div>
                                <label class="block text-textDark font-medium mb-1">Médico / Profesional de Referencia</label>
                                <input type="text" name="medico_nombre_apellido" placeholder="Ej. Dr. Carlos Benítez" class="w-full bg-background border border-borderColor rounded-lg px-2.5 py-1.5 focus:outline-none focus:border-primary text-xs">
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-borderColor shadow-sm space-y-3">
                        <h3 class="text-xs font-bold text-primary uppercase tracking-wider border-b border-borderColor/50 pb-1.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">description</span> 2. Contenido Técnico Expositivo
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="block text-textDark font-bold">Motivo del Informe</label>
                                <textarea name="motivo_informe" rows="3" require placeholder="Describa la causa que origina la apertura de este informe..." class="w-full bg-background border border-borderColor rounded-lg p-2 focus:outline-none focus:border-primary resize-y min-h-[65px] text-xs"></textarea>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-textDark font-bold">Antecedentes del Caso</label>
                                <textarea name="antecedente_caso" rows="3" placeholder="Contexto histórico o intervenciones previas..." class="w-full bg-background border border-borderColor rounded-lg p-2 focus:outline-none focus:border-primary resize-y min-h-[65px] text-xs"></textarea>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-textDark font-bold">Composición del Cuadro Familiar</label>
                                <textarea name="cuadro_familiar" rows="3" placeholder="Detalle de los miembros estables que cohabitan..." class="w-full bg-background border border-borderColor rounded-lg p-2 focus:outline-none focus:border-primary resize-y min-h-[65px] text-xs"></textarea>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-textDark font-bold">Dinámica Familiar y Relacional</label>
                                <textarea name="dinamica_familiar" rows="3" placeholder="Vínculos, roles, comunicación y jefatura del hogar..." class="w-full bg-background border border-borderColor rounded-lg p-2 focus:outline-none focus:border-primary resize-y min-h-[65px] text-xs"></textarea>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-textDark font-bold">Situación Habitacional e Infraestructura</label>
                                <textarea name="situacion_condiciones_vida" rows="3" placeholder="Condiciones de habitabilidad de la vivienda, hacinamiento..." class="w-full bg-background border border-borderColor rounded-lg p-2 focus:outline-none focus:border-primary resize-y min-h-[65px] text-xs"></textarea>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-textDark font-bold">Recursos Económicos y Presupuesto</label>
                                <textarea name="recursos_economicos" rows="3" placeholder="Sustento familiar, asignaciones, pensiones..." class="w-full bg-background border border-borderColor rounded-lg p-2 focus:outline-none focus:border-primary resize-y min-h-[65px] text-xs"></textarea>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-textDark font-bold">Condición Laboral u Ocupación</label>
                                <textarea name="condicion_laboral" rows="3" placeholder="Estabilidad, informalidad, desempleo..." class="w-full bg-background border border-borderColor rounded-lg p-2 focus:outline-none focus:border-primary resize-y min-h-[65px] text-xs"></textarea>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-textDark font-bold">Cobertura Sanitaria y Social</label>
                                <textarea name="cobertura_sanitaria" rows="3" placeholder="Seguro médico, IPS, programas de salud pública..." class="w-full bg-background border border-borderColor rounded-lg p-2 focus:outline-none focus:border-primary resize-y min-h-[65px] text-xs"></textarea>
                            </div>
                        </div>
                        <div class="space-y-1 pt-1">
                            <label class="block text-textDark font-bold">Otros Datos Relevantes</label>
                            <textarea name="otros" rows="2" placeholder="Observaciones complementarias no contempladas..." class="w-full bg-background border border-borderColor rounded-lg p-2 focus:outline-none focus:border-primary resize-y text-xs"></textarea>
                        </div>
                    </div>

                    <div class="bg-white p-4 rounded-xl border border-borderColor shadow-sm space-y-4">
                        <h3 class="text-xs font-bold text-primary uppercase tracking-wider border-b border-borderColor/50 pb-1.5 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">gavel</span> 3. Diagnóstico e Interpretación Técnica
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="block text-red-600 font-bold flex items-center gap-1 text-[11px]">
                                    <span class="material-symbols-outlined text-sm">gpp_maybe</span> Factores de Riesgo Social
                                </label>
                                <textarea name="factores_riesgo" rows="3" placeholder="Vulnerabilidades detectadas, negligencias o carencias críticas..." class="w-full bg-background border border-red-200 rounded-lg p-2 focus:outline-none focus:border-red-500 resize-y text-xs"></textarea>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-green-600 font-bold flex items-center gap-1 text-[11px]">
                                    <span class="material-symbols-outlined text-sm">gpp_good</span> Factores de Protección / Fortalezas
                                </label>
                                <textarea name="factores_proteccion" rows="3" placeholder="Redes de apoyo operativas, recursos propios del grupo..." class="w-full bg-background border border-green-200 rounded-lg p-2 focus:outline-none focus:border-green-500 resize-y text-xs"></textarea>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-1">
                            <div class="space-y-1">
                                <label class="block text-textDark font-bold">Conclusión Profesional</label>
                                <textarea name="conclusion" rows="3" placeholder="Dictamen o síntesis del trabajador social..." class="w-full bg-background border border-borderColor rounded-lg p-2 focus:outline-none focus:border-primary resize-y text-xs"></textarea>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-textDark font-bold">Recomendaciones o Plan de Acción</label>
                                <textarea name="recomendacion" rows="3" placeholder="Sugerencias de derivación o pautas de intervención..." class="w-full bg-background border border-borderColor rounded-lg p-2 focus:outline-none focus:border-primary resize-y text-xs"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="p-4 bg-white border-t border-borderColor flex justify-end gap-2 rounded-b-2xl shadow-[0_-4px_12px_rgba(0,0,0,0.02)]">
                    <!--<button type="button" onclick="closeModal('modal-informe')" class="px-4 py-2 bg-surface hover:bg-background text-textSoft font-bold rounded-xl border border-borderColor text-xs transition-colors">
                        Cancelar
                    </button>
                    <button type="button" class="p-2 bg-surface hover:bg-background border border-borderColor text-textSoft hover:text-textDark rounded-xl transition-colors flex items-center" title="Imprimir PDF">
                        <span class="material-symbols-outlined text-sm">print</span>
                    </button>-->
                    <button type="submit" class="px-5 py-2 bg-primary hover:bg-primaryDark text-surface font-bold rounded-xl text-xs flex items-center gap-1.5 transition-colors shadow-sm">
                        <span class="material-symbols-outlined text-sm">history_edu</span> Guardar Registro
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script src="/assets/js/script.js" defer></script>
    <script src="/assets/js/pacientes.js" defer></script>


</body>


</html>