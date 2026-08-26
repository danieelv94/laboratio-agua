<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Solicitud de Análisis - CEAA</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=2" type="image/png">
    <link rel="icon" href="{{ asset('favicon.png') }}?v=2" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        h1,
        h2,
        h3,
        .font-title {
            font-family: 'Outfit', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="bg-guinda-ceaa text-white py-4 shadow-md border-b border-yellow-600/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                <img src="{{ asset('images/logo.png') }}" alt="Logo"
                    class="h-12 sm:h-14 w-auto object-contain transition-transform duration-300 group-hover:scale-102"
                    style="filter: brightness(0) invert(1);">
            </a>
            <a href="{{ route('home') }}" class="text-xs text-slate-300 hover:text-white flex items-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Volver al Inicio</span>
            </a>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-grow max-w-4xl w-full mx-auto px-4 py-12">

        <!-- Header Text -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-extrabold text-guinda-ceaa tracking-tight font-title">Acuerdo de Servicio</h1>
            <p class="text-slate-600 mt-2 text-sm">Solicitud de Análisis Físico, Químico y Bacteriológico de Agua</p>
            <div class="text-[10px] text-slate-400 mt-1 uppercase font-semibold">Formato: FA-SG-LCH2O/06 | Dirección de
                Calidad del Agua</div>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl mb-8 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 h-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-semibold text-red-800">Se encontraron errores en el formulario:</h3>
                        <ul class="mt-2 list-disc list-inside text-xs text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <div x-data="studyRequestForm()" class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">

            <!-- Progress Bar / Tabs -->
            <div class="bg-slate-50 border-b border-slate-100 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center space-x-2 text-xs font-semibold text-slate-400">
                    <span :class="step >= 1 ? 'text-guinda-ceaa' : ''">1. Datos Solicitante</span>
                    <span>&rarr;</span>
                    <span :class="step >= 2 ? 'text-guinda-ceaa' : ''">2. Muestra y Normas</span>
                    <span>&rarr;</span>
                    <span :class="step >= 3 ? 'text-guinda-ceaa' : ''">3. Facturación</span>
                    <span>&rarr;</span>
                    <span :class="step >= 4 ? 'text-guinda-ceaa' : ''">4. Confirmación</span>
                </div>
                <div class="text-xs font-bold text-amber-600 bg-arena-claro/10 px-2.5 py-1 rounded-full">
                    Paso <span x-text="step"></span> de 4
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('solicitud.guardar') }}" method="POST" class="p-8 space-y-8">
                @csrf

                <!-- STEP 1: DATOS DEL SOLICITANTE -->
                <div x-show="step === 1" class="space-y-6">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-xl font-bold font-title text-guinda-ceaa">Datos del Solicitante</h2>
                        <p class="text-xs text-slate-500">Información de la dependencia u organización que solicita el
                            estudio.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="solicitante"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Solicitante
                                <span class="text-red-500">*</span></label>
                            <input type="text" name="solicitante" id="solicitante" value="{{ old('solicitante') }}"
                                placeholder="Ej. Presidencia Municipal de Chilcuautla"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5"
                                required>
                        </div>

                        <div class="space-y-2">
                            <label for="representante"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Representante
                                Legal / Contacto <span class="text-red-500">*</span></label>
                            <input type="text" name="representante" id="representante"
                                value="{{ old('representante') }}" placeholder="Ej. Lic. Gabriela Escamilla López"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5"
                                required>
                        </div>

                        <div class="space-y-2">
                            <label for="puesto_departamento"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Puesto o
                                Departamento <span class="text-red-500">*</span></label>
                            <input type="text" name="puesto_departamento" id="puesto_departamento"
                                value="{{ old('puesto_departamento') }}" placeholder="Ej. Presidenta Municipal"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5"
                                required>
                        </div>

                        <div class="space-y-2">
                            <label for="email"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Correo
                                Electrónico <span class="text-red-500">*</span></label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                placeholder="Ej. contacto@municipio.gob.mx"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5"
                                required>
                        </div>

                        <div class="space-y-2">
                            <label for="telefono"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Teléfono de
                                Contacto <span class="text-slate-400 font-normal lowercase">(opcional)</span></label>
                            <input type="text" name="telefono" id="telefono" value="{{ old('telefono') }}"
                                placeholder="Ej. 7711234567"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5">
                        </div>
                    </div>
                </div>

                <!-- STEP 2: DATOS DE LA MUESTRA -->
                <div x-show="step === 2" class="space-y-6">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-xl font-bold font-title text-guinda-ceaa">Datos de la Muestra</h2>
                        <p class="text-xs text-slate-500">Especifique el origen de la muestra y el marco normativo
                            requerido.</p>
                    </div>

                    <!-- Cantidad de Muestras -->
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
                        <label for="cantidad_muestras"
                            class="block text-xs font-bold uppercase tracking-wider text-slate-500">Cantidad de Análisis
                            / Muestras <span class="text-red-500">*</span></label>
                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                            <input type="number" name="cantidad_muestras" id="cantidad_muestras" min="1" max="100"
                                x-model.number="cantidadMuestras"
                                class="w-32 rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5 font-bold text-center">
                            <span class="text-xs text-slate-500">
                                El costo de recuperación por cada análisis es de <strong>$7,698.02</strong>. <br
                                    class="hidden sm:block">
                                Costo total estimado: <strong class="text-guinda-ceaa font-bold"
                                    x-text="new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(cantidadMuestras * 7698.02)"></strong>
                            </span>
                        </div>
                    </div>

                    <!-- Punto de Muestreo checkboxes -->
                    <div class="space-y-3">
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Punto de
                            Muestreo <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach(['MANANTIAL', 'TANQUE', 'NORIA', 'POZO', 'CARCAMO', 'Entrada Planta de Tratamiento (Cruda)', 'Salida Planta de tratamiento (Tratada)', 'OTRO'] as $punto)
                                <label
                                    class="flex items-center space-x-3 bg-slate-50 hover:bg-slate-50/80 p-3 rounded-xl border border-slate-200/80 cursor-pointer transition">
                                    <input type="checkbox" name="puntos_muestreo[]" value="{{ $punto }}"
                                        x-model="puntosMuestreo" @change="handlePuntoMuestreoChange()"
                                        class="rounded border-slate-300 text-guinda-ceaa focus:ring-emerald-500">
                                    <span class="text-xs font-medium text-slate-700 leading-tight">{{ $punto }}</span>
                                </label>
                            @endforeach
                        </div>

                        <!-- Punto de muestreo especificar -->
                        <div x-show="puntosMuestreo.includes('OTRO')" x-cloak class="mt-3 space-y-2" x-transition>
                            <label for="punto_muestreo_especificar"
                                class="block text-xs font-semibold uppercase tracking-wider text-guinda-ceaa">Especificar
                                Punto de Muestreo <span class="text-red-500">*</span></label>
                            <input type="text" name="punto_muestreo_especificar" id="punto_muestreo_especificar"
                                value="{{ old('punto_muestreo_especificar') }}"
                                :required="puntosMuestreo.includes('OTRO')"
                                placeholder="Ej. Red de distribución de la colonia centro"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5">
                        </div>
                    </div>

                    <!-- Tipo de Muestra checkboxes -->
                    <div class="space-y-3"
                        :class="puntosMuestreo.length === 0 ? 'opacity-50 pointer-events-none select-none' : ''"
                        x-transition>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Tipo de
                            Muestra <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            @foreach(['AGUA POTABLE', 'AGUA RESIDUAL', 'AGUA TRATADA'] as $tipo)
                                <label
                                    class="flex items-center space-x-3 bg-slate-50 hover:bg-slate-50/80 p-3 rounded-xl border border-slate-200/80 cursor-pointer transition"
                                    :class="(puntosMuestreo.length === 0 || ('{{ $tipo }}' === 'AGUA POTABLE' && isAguaPotableDisabled())) ? 'opacity-50 cursor-not-allowed' : ''">
                                    <input type="checkbox" name="tipos_muestra[]" value="{{ $tipo }}" x-model="tiposMuestra"
                                        @change="handleTipoMuestraChange()"
                                        :disabled="puntosMuestreo.length === 0 || ('{{ $tipo }}' === 'AGUA POTABLE' && isAguaPotableDisabled())"
                                        class="rounded border-slate-300 text-guinda-ceaa focus:ring-emerald-500">
                                    <span class="text-xs font-medium text-slate-700">{{ $tipo }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <!-- Normativas checkboxes -->
                    <div class="space-y-3"
                        :class="tiposMuestra.length === 0 ? 'opacity-50 pointer-events-none select-none' : ''"
                        x-transition>
                        <label class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Normativa
                            Aplicable (Normas a cumplir) <span class="text-red-500">*</span></label>
                        <div class="space-y-2.5">
                            @foreach([
                                    'NOM-001-SEMARNAT-2021' => 'NOM-001-SEMARNAT-2021 "Límites permisibles de contaminantes en las descargas de aguas residuales en cuerpos receptores propiedad de la nación."',
                                    'NOM-002-ECOL-1996' => 'NOM-002-ECOL-1996 "Límites máximos permisibles de contaminantes en las descargas de aguas residuales a los sistemas de alcantarillado urbano o municipal."',
                                    'NOM-003-ECOL-1997' => 'NOM-003-ECOL-1997 "Límites máximos permisibles de contaminantes para las aguas residuales tratadas que se reusen en servicios al público."',
                                    'NOM-127-SSA1-2021' => 'NOM-127-SSA1-2021 "Agua para uso y consumo humano. Límites permisibles de la calidad del agua."',
                                    'OTRA' => 'OTRA NORMATIVA O ESPECIFICACIÓN PERSONALIZADA'
                                ] as $key => $label)
                                <label
                                    class="flex items-start space-x-3 bg-slate-50 hover:bg-slate-50/80 p-3 rounded-xl border border-slate-200/80 cursor-pointer transition"
                                    :class="(tiposMuestra.length === 0 || ('{{ $key }}' === 'NOM-127-SSA1-2021' ? isNom127Disabled() : isOnlyPotable())) ? 'opacity-50 cursor-not-allowed' : ''">
                                    <input type="checkbox" name="normativas[]" value="{{ $key }}" x-model="normativas"
                                        :disabled="tiposMuestra.length === 0 || ('{{ $key }}' === 'NOM-127-SSA1-2021' ? isNom127Disabled() : isOnlyPotable())"
                                        class="mt-0.5 rounded border-slate-300 text-guinda-ceaa focus:ring-emerald-500">
                                    <span class="text-xs font-medium text-slate-700 leading-normal">{{ $label }}</span>
                                </label>
                            @endforeach
                        </div>

                        <!-- Normativa especificar -->
                        <div x-show="normativas.includes('OTRA')" x-cloak class="mt-3 space-y-2" x-transition>
                            <label for="normativa_especificar"
                                class="block text-xs font-semibold uppercase tracking-wider text-guinda-ceaa">Especificar
                                Normativa <span class="text-red-500">*</span></label>
                            <input type="text" name="normativa_especificar" id="normativa_especificar"
                                value="{{ old('normativa_especificar') }}"
                                :required="normativas.includes('OTRA')"
                                placeholder="Ej. Norma estatal o requerimiento específico del cliente"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5">
                        </div>
                    </div>

                    <!-- Dirección Física del Muestreo -->
                    <div class="space-y-2 mt-4">
                        <label for="direccion"
                            class="block text-xs font-semibold uppercase tracking-wider text-slate-500 font-title">Dirección Física del Muestreo (Completa) <span class="text-red-500">*</span></label>
                        <textarea name="direccion" id="direccion" rows="3"
                            placeholder="Calle, Número, Colonia, Municipio, Código Postal, Estado (Dirección exacta donde se realizará la toma de muestra)"
                            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm"
                            required>{{ old('direccion') }}</textarea>
                    </div>

                    <!-- Invoicing Requirement Toggle -->
                    <div class="mt-6 pt-5 border-t border-slate-100 bg-slate-50 p-5 rounded-2xl border border-slate-200">
                        <span class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">¿Requiere Factura Electrónica? <span class="text-red-500">*</span></span>
                        <p class="text-xs text-slate-500 mb-4 font-normal">Indique si requiere comprobante fiscal digital (CFDI) para este trámite. De ser así, se habilitará el paso de Facturación para ingresar sus datos fiscales de forma obligatoria.</p>
                        
                        <div class="flex items-center space-x-6">
                            <label class="flex items-center space-x-2.5 cursor-pointer">
                                <input type="radio" name="requiere_factura_radio" :value="true" x-model="requiereFactura" class="text-guinda-ceaa focus:ring-guinda-ceaa">
                                <span class="text-xs font-semibold text-slate-700">Sí, requiero factura</span>
                            </label>
                            <label class="flex items-center space-x-2.5 cursor-pointer">
                                <input type="radio" name="requiere_factura_radio" :value="false" x-model="requiereFactura" class="text-guinda-ceaa focus:ring-guinda-ceaa">
                                <span class="text-xs font-semibold text-slate-700">No requiero factura</span>
                            </label>
                        </div>
                    </div>

                    <input type="hidden" name="requiere_factura" :value="isFacturaRequired() ? 1 : 0">
                </div>

                <!-- STEP 3: INFORMACIÓN DE FACTURACIÓN (OPCIONAL) -->
                <div x-show="step === 3" class="space-y-6">
                    <div class="border-b border-slate-100 pb-3">
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-bold font-title text-guinda-ceaa">Información para Facturación</h2>
                            <span
                                 class="text-xs font-bold text-guinda-ceaa bg-arena-claro/25 px-2.5 py-0.5 rounded-full uppercase tracking-wider" x-show="isFacturaRequired()" x-cloak>Requerido</span>
                             <span
                                 class="text-xs font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded" x-show="!isFacturaRequired()" x-cloak>Opcional</span>
                        </div>
                        <p class="text-xs text-slate-500">Complete si requiere comprobante fiscal digital por internet
                            (CFDI).</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label for="rfc"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-500 font-title">RFC <span class="text-red-500">*</span></label>
                            <input type="text" name="rfc" id="rfc" value="{{ old('rfc') }}"
                                placeholder="RFC de la Razón Social"
                                minlength="12" maxlength="13"
                                :required="isFacturaRequired()"
                                :disabled="!isFacturaRequired()"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5">
                        </div>

                        <div class="space-y-2">
                            <label for="razon_social"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-500 font-title">Nombre o Razón Social <span class="text-red-500">*</span></label>
                            <input type="text" name="razon_social" id="razon_social" value="{{ old('razon_social') }}"
                                placeholder="Denominación o Razón Social"
                                :required="isFacturaRequired()"
                                :disabled="!isFacturaRequired()"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5">
                        </div>

                        <div class="space-y-2">
                            <label for="uso_cfdi"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-500 font-title">Uso de CFDI <span class="text-red-500">*</span></label>
                            <select name="uso_cfdi" id="uso_cfdi"
                                :required="isFacturaRequired()"
                                :disabled="!isFacturaRequired()"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5">
                                <option value="">Seleccione una opción...</option>
                                <option value="G03" {{ old('uso_cfdi') == 'G03' ? 'selected' : '' }}>G03 - Gastos en general</option>
                                <option value="G01" {{ old('uso_cfdi') == 'G01' ? 'selected' : '' }}>G01 - Adquisición de mercancías</option>
                                <option value="I08" {{ old('uso_cfdi') == 'I08' ? 'selected' : '' }}>I08 - Otra maquinaria y equipo</option>
                                <option value="S01" {{ old('uso_cfdi') == 'S01' ? 'selected' : '' }}>S01 - Sin efectos fiscales</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="metodo_pago"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-500 font-title">Método de Pago <span class="text-red-500">*</span></label>
                            <select name="metodo_pago" id="metodo_pago"
                                :required="isFacturaRequired()"
                                :disabled="!isFacturaRequired()"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5">
                                <option value="">Seleccione una opción...</option>
                                <option value="PUE" {{ old('metodo_pago') == 'PUE' ? 'selected' : '' }}>PUE - Pago en una sola exhibición</option>
                                <option value="PPD" {{ old('metodo_pago') == 'PPD' ? 'selected' : '' }}>PPD - Pago en parcialidades o diferido</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="forma_pago"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-500 font-title">Forma de Pago <span class="text-red-500">*</span></label>
                            <select name="forma_pago" id="forma_pago"
                                :required="isFacturaRequired()"
                                :disabled="!isFacturaRequired()"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5">
                                <option value="">Seleccione una opción...</option>
                                <option value="Transferencia electrónica de fondos" {{ old('forma_pago') == 'Transferencia electrónica de fondos' ? 'selected' : '' }}>Transferencia electrónica de fondos</option>
                                <option value="Depósito" {{ old('forma_pago') == 'Depósito' ? 'selected' : '' }}>Depósito</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label for="ultimos_cuatro_digitos"
                                class="block text-xs font-semibold uppercase tracking-wider text-slate-500 font-title">Últimos 4 dígitos de Cuenta <span class="text-slate-400 font-normal lowercase">(opcional)</span></label>
                            <input type="text" name="ultimos_cuatro_digitos" id="ultimos_cuatro_digitos"
                                value="{{ old('ultimos_cuatro_digitos') }}" placeholder="Ej. 1234" 
                                minlength="4" maxlength="4" pattern="[0-9]{4}" title="Debe contener exactamente 4 números"
                                :disabled="!isFacturaRequired()"
                                class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-2.5">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="direccion_fiscal"
                            class="block text-xs font-semibold uppercase tracking-wider text-slate-500 font-title">Dirección Fiscal Completa <span class="text-red-500">*</span></label>
                        <textarea name="direccion_fiscal" id="direccion_fiscal" rows="2"
                            placeholder="Calle, Número, Colonia, Código Postal, etc."
                            :required="isFacturaRequired()"
                            :disabled="!isFacturaRequired()"
                            class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm">{{ old('direccion_fiscal') }}</textarea>
                    </div>
                </div>

                <!-- STEP 4: RESUMEN Y ACEPTACIÓN -->
                <div x-show="step === 4" class="space-y-6">
                    <div class="border-b border-slate-100 pb-3">
                        <h2 class="text-xl font-bold font-title text-guinda-ceaa">Confirmación y Términos</h2>
                        <p class="text-xs text-slate-500">Por favor, revise la cuota de recuperación y acepte los
                            términos y condiciones antes de enviar.</p>
                    </div>

                    <!-- Fee Summary Card -->
                    <div class="bg-arena-claro/10 rounded-2xl border border-dorado-ocre/30 p-6 space-y-4">
                        <h3 class="text-sm font-bold text-guinda-ceaa uppercase tracking-wider">Cuota de Recuperación
                        </h3>
                        <div
                            class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-t border-dorado-ocre/25 pt-3 gap-2">
                            <div>
                                <span class="text-xs font-semibold text-slate-600 block">Concepto:</span>
                                <span class="text-sm font-bold text-slate-800 block">Análisis fisicoquímico
                                    bacteriológico de agua (Con toma de muestra)</span>
                                <span class="text-xs text-slate-500">Cantidad: <strong
                                        x-text="cantidadMuestras"></strong> análisis ($7,698.02 c/u)</span>
                            </div>
                            <div class="text-right sm:border-l sm:border-dorado-ocre/25 sm:pl-6 flex-shrink-0">
                                <span class="text-xs font-semibold text-slate-600 block">Total a pagar:</span>
                                <span class="text-2xl font-extrabold text-guinda-ceaa"><span
                                        x-text="new Intl.NumberFormat('es-MX', { style: 'currency', currency: 'MXN' }).format(cantidadMuestras * 7698.02)"></span>
                                    <span class="text-xs font-semibold">MXN</span></span>
                            </div>
                        </div>
                    </div>

                    <!-- Policy Accordions/Boxes -->
                    <div
                        class="space-y-4 text-xs text-slate-600 leading-relaxed max-h-60 overflow-y-auto bg-slate-50 p-5 rounded-2xl border border-slate-200">
                        <div class="space-y-2">
                            <h4 class="font-bold text-slate-800 uppercase text-[10px] tracking-wider">Acuerdo de
                                Confidencialidad</h4>
                            <p>
                                Cada que se lleva a cabo cualquier servicio por parte del Laboratorio CEAA, el
                                Laboratorio CEAA es responsable de la gestión de toda la información obtenida o creada
                                durante la realización de actividades de ensayos.
                            </p>
                            <p>
                                En caso de ser necesario, la Dirección de Calidad informará al cliente con anticipación
                                acerca de la información que el Laboratorio CEAA pretenda poner al alcance del público,
                                cuando así se requiera. Excepto la información que el propio cliente pone a disposición
                                del público; en caso contrario, la información que se hará pública deberá ser acordada
                                entre el Laboratorio CEAA y el cliente.
                            </p>
                        </div>
                        <div class="space-y-2 pt-2 border-t border-slate-200">
                            <h4 class="font-bold text-slate-800 uppercase text-[10px] tracking-wider">Tratamiento de
                                Quejas y Reclamaciones</h4>
                            <p>
                                El Laboratorio CEAA cuenta con el Procedimiento de reclamaciones
                                <strong>PC-SG-LCH2O/2</strong> para resolver las reclamaciones que se produzcan
                                derivadas de las actividades de ensayo.
                            </p>
                            <p>
                                Cuando se recibe alguna reclamación, la Dirección de Calidad es responsable de
                                recibirla, acusar recibo, registrarla, investigarla y notificar a la parte reclamante de
                                manera formal la resolución de esta en un periodo no mayor a 10 días hábiles. Las
                                reclamaciones serán resueltas de manera imparcial por personal que no estuvo involucrado
                                en la actividad que dio origen a la misma.
                            </p>
                        </div>
                    </div>

                    <!-- Acceptance checkbox -->
                    <label
                        class="flex items-start space-x-3 bg-arena-claro/10/40 p-4 rounded-xl border border-dorado-ocre/20 cursor-pointer transition">
                        <input type="checkbox" name="acepto_terminos" value="1"
                            class="mt-0.5 rounded border-slate-300 text-guinda-ceaa focus:ring-emerald-500" required>
                        <span class="text-xs text-slate-700 leading-relaxed">
                            <strong class="text-slate-800">Acepto los términos y condiciones:</strong> Declaro bajo
                            protesta de decir verdad que los datos proporcionados son correctos, confirmo mi solicitud
                            de análisis de agua de acuerdo al importe cotizado de $7,698.02 pesos, y acepto las
                            políticas de confidencialidad y tratamiento de quejas expresadas por la CEAA.
                        </span>
                    </label>
                </div>

                <!-- Navigation Buttons inside Form -->
                <div class="flex items-center justify-between pt-6 border-t border-slate-100">
                    <button type="button" x-show="step > 1" @click="prevStep()"
                        class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold rounded-xl transition"
                        x-cloak>
                        Anterior
                    </button>
                    <div x-show="step === 1" class="text-slate-400 text-xs">
                        Campos con (*) son requeridos
                    </div>

                    <button type="button" x-show="step < 4" @click="nextStep()"
                        class="ml-auto px-6 py-2.5 bg-guinda-ceaa hover:bg-guinda-ceaa-hover text-white text-sm font-semibold rounded-xl transition shadow-md">
                        Siguiente
                    </button>

                    <button type="submit" x-show="step === 4"
                        class="ml-auto px-8 py-3 bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700 text-guinda-ceaa text-sm font-bold rounded-xl shadow-lg transition"
                        x-cloak>
                        Enviar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-500 py-6 px-4 text-center text-xs mt-12 border-t border-slate-800">
        &copy; {{ date('Y') }} Comisión Estatal del Agua y Alcantarillado - CEAA. Hidalgo.
    </footer>

    <script>
        function studyRequestForm() {
            return {
                step: 1,
                puntosMuestreo: {!! json_encode(old('puntos_muestreo', [])) !!},
                tiposMuestra: {!! json_encode(old('tipos_muestra', [])) !!},
                normativas: {!! json_encode(old('normativas', [])) !!},
                cantidadMuestras: {{ old('cantidad_muestras', 1) }},
                requiereFactura: {{ old('requiere_factura', 0) == 1 ? 'true' : 'false' }},
                init() {
                    this.$watch('requiereFactura', value => {
                        if (!this.isFacturaRequired()) {
                            const fields = ['rfc', 'razon_social', 'direccion_fiscal', 'uso_cfdi', 'metodo_pago', 'forma_pago', 'ultimos_cuatro_digitos'];
                            fields.forEach(id => {
                                const el = document.getElementById(id);
                                if (el) {
                                    el.value = '';
                                    el.setCustomValidity('');
                                }
                            });
                        }
                    });
                },
                isFacturaRequired() {
                    return this.requiereFactura === true || this.requiereFactura === 'true' || this.requiereFactura === 1 || this.requiereFactura === '1';
                },
                isOnlyPotable() {
                    return this.tiposMuestra.includes('AGUA POTABLE') && !this.tiposMuestra.includes('AGUA RESIDUAL') && !this.tiposMuestra.includes('AGUA TRATADA');
                },
                isNom127Disabled() {
                    return (this.puntosMuestreo.includes('Entrada Planta de Tratamiento (Cruda)') || this.puntosMuestreo.includes('Salida Planta de tratamiento (Tratada)')) && !this.tiposMuestra.includes('AGUA POTABLE');
                },
                isAguaPotableDisabled() {
                    const hasPtar = this.puntosMuestreo.includes('Entrada Planta de Tratamiento (Cruda)') || this.puntosMuestreo.includes('Salida Planta de tratamiento (Tratada)');
                    const hasOther = this.puntosMuestreo.some(p => p !== 'Entrada Planta de Tratamiento (Cruda)' && p !== 'Salida Planta de tratamiento (Tratada)');
                    return hasPtar && !hasOther;
                },
                handleTipoMuestraChange() {
                    if (this.tiposMuestra.length === 0) {
                        this.normativas = [];
                    }
                    if (this.isOnlyPotable()) {
                        if (!this.normativas.includes('NOM-127-SSA1-2021')) {
                            this.normativas.push('NOM-127-SSA1-2021');
                        }
                        this.normativas = this.normativas.filter(n => n === 'NOM-127-SSA1-2021');
                    } else {
                        this.handlePuntoMuestreoChange();
                    }
                },
                handlePuntoMuestreoChange() {
                    if (this.puntosMuestreo.length === 0) {
                        this.tiposMuestra = [];
                        this.normativas = [];
                    }
                    if (this.isAguaPotableDisabled()) {
                        this.tiposMuestra = this.tiposMuestra.filter(t => t !== 'AGUA POTABLE');
                        this.handleTipoMuestraChange();
                    }
                    if (this.isNom127Disabled()) {
                        this.normativas = this.normativas.filter(n => n !== 'NOM-127-SSA1-2021');
                    }
                },
                nextStep() {
                    if (this.validateStep(this.step)) {
                        if (this.step === 2 && !this.isFacturaRequired()) {
                            this.step = 4;
                        } else {
                            this.step++;
                        }
                    }
                },
                prevStep() {
                    if (this.step === 4 && !this.isFacturaRequired()) {
                        this.step = 2;
                    } else {
                        this.step--;
                    }
                },
                validateStep(stepNum) {
                    const stepEl = document.querySelector(`[x-show='step === ${stepNum}']`);
                    if (!stepEl) return true;

                    // Paso 2: Validar checkboxes de selección obligatorios y dirección
                    if (stepNum === 2) {
                        if (this.puntosMuestreo.length === 0) {
                            const firstCheckbox = stepEl.querySelector('input[name="puntos_muestreo[]"]');
                            if (firstCheckbox) {
                                firstCheckbox.setCustomValidity('Debe seleccionar al menos un punto de muestreo.');
                                firstCheckbox.reportValidity();
                                firstCheckbox.addEventListener('change', () => firstCheckbox.setCustomValidity(''), { once: true });
                            }
                            return false;
                        }
                        if (this.tiposMuestra.length === 0) {
                            const firstCheckbox = stepEl.querySelector('input[name="tipos_muestra[]"]');
                            if (firstCheckbox) {
                                firstCheckbox.setCustomValidity('Debe seleccionar al menos un tipo de muestra.');
                                firstCheckbox.reportValidity();
                                firstCheckbox.addEventListener('change', () => firstCheckbox.setCustomValidity(''), { once: true });
                            }
                            return false;
                        }
                        if (this.normativas.length === 0) {
                            const firstCheckbox = stepEl.querySelector('input[name="normativas[]"]');
                            if (firstCheckbox) {
                                firstCheckbox.setCustomValidity('Debe seleccionar al menos una normativa aplicable.');
                                firstCheckbox.reportValidity();
                                firstCheckbox.addEventListener('change', () => firstCheckbox.setCustomValidity(''), { once: true });
                            }
                            return false;
                        }
                        const dirInput = document.getElementById('direccion');
                        if (dirInput && !dirInput.value.trim()) {
                            dirInput.setCustomValidity('La dirección física del muestreo es obligatoria.');
                            dirInput.reportValidity();
                            dirInput.addEventListener('input', () => dirInput.setCustomValidity(''), { once: true });
                            return false;
                        }
                    }

                    // Paso 3: Validaciones de Facturación
                    if (stepNum === 3) {
                        if (this.isFacturaRequired()) {
                            const rfcInput = document.getElementById('rfc');
                            const rfcVal = rfcInput ? rfcInput.value.trim() : '';

                            const razonInput = document.getElementById('razon_social');
                            const razonSocialVal = razonInput ? razonInput.value.trim() : '';

                            const usoInput = document.getElementById('uso_cfdi');
                            const usoCfdiVal = usoInput ? usoInput.value : '';

                            const metodoInput = document.getElementById('metodo_pago');
                            const metodoPagoVal = metodoInput ? metodoInput.value : '';

                            const formaInput = document.getElementById('forma_pago');
                            const formaPagoVal = formaInput ? formaInput.value : '';

                            const direccionInput = document.getElementById('direccion_fiscal');
                            const direccionFiscalVal = direccionInput ? direccionInput.value.trim() : '';

                            if (!rfcVal) {
                                rfcInput.setCustomValidity('El RFC es obligatorio.');
                                rfcInput.reportValidity();
                                rfcInput.addEventListener('input', () => rfcInput.setCustomValidity(''), { once: true });
                                return false;
                            }
                            if (!razonSocialVal) {
                                razonInput.setCustomValidity('La Razón Social es obligatoria.');
                                razonInput.reportValidity();
                                razonInput.addEventListener('input', () => razonInput.setCustomValidity(''), { once: true });
                                return false;
                            }
                            if (!usoCfdiVal) {
                                usoInput.setCustomValidity('El Uso de CFDI es obligatorio.');
                                usoInput.reportValidity();
                                usoInput.addEventListener('change', () => usoInput.setCustomValidity(''), { once: true });
                                return false;
                            }
                            if (!metodoPagoVal) {
                                metodoInput.setCustomValidity('El Método de Pago es obligatorio.');
                                metodoInput.reportValidity();
                                metodoInput.addEventListener('change', () => metodoInput.setCustomValidity(''), { once: true });
                                return false;
                            }
                            if (!formaPagoVal) {
                                formaInput.setCustomValidity('La Forma de Pago es obligatoria.');
                                formaInput.reportValidity();
                                formaInput.addEventListener('change', () => formaInput.setCustomValidity(''), { once: true });
                                return false;
                            }
                            if (!direccionFiscalVal) {
                                direccionInput.setCustomValidity('La Dirección Fiscal es obligatoria.');
                                direccionInput.reportValidity();
                                direccionInput.addEventListener('input', () => direccionInput.setCustomValidity(''), { once: true });
                                return false;
                            }
                        }
                    }

                    // Validar todos los controles HTML5 visibles en este paso
                    const inputs = Array.from(stepEl.querySelectorAll('input, select, textarea'))
                                        .filter(input => input.offsetParent !== null);
                    let firstInvalid = null;
                    for (const input of inputs) {
                        if (!input.checkValidity()) {
                            firstInvalid = input;
                            break;
                        }
                    }

                    if (firstInvalid) {
                        firstInvalid.reportValidity();
                        return false;
                    }

                    return true;
                }
            };
        }
    </script>

</body>

</html>