<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle de Solicitud | CEAA</title>
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=2" type="image/png">
    <link rel="icon" href="{{ asset('favicon.png') }}?v=2" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, .font-title {
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header class="bg-guinda-ceaa text-white py-4 shadow-md border-b border-yellow-600/30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 sm:h-14 w-auto object-contain transition-transform duration-300 group-hover:scale-102"
                        style="filter: brightness(0) invert(1);">
                </a>
            <a href="{{ route('home') }}" class="text-xs text-slate-300 hover:text-white flex items-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Volver al Inicio</span>
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-4xl w-full mx-auto px-4 py-12 space-y-8">

        @if(session('success'))
            <div class="bg-arena-claro/15 border-l-4 border-guinda-ceaa p-4 rounded-xl shadow-sm text-sm text-guinda-ceaa font-semibold flex items-center space-x-2">
                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm text-sm text-red-800 font-semibold space-y-1">
                <div class="flex items-center space-x-2">
                    <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>
                    <span>Hubo un problema:</span>
                </div>
                <ul class="list-disc list-inside pl-5 text-xs text-red-700 font-normal">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Reference Prominent Header -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Folio de Referencia</span>
                <h1 class="text-3xl font-extrabold text-guinda-ceaa tracking-tight font-title">{{ $studyRequest->referencia_bancaria }}</h1>
                <p class="text-xs text-slate-500">Solicitante: <span class="font-semibold text-slate-700">{{ $studyRequest->solicitante }}</span></p>
            </div>
            
            <!-- Current Status Badge -->
            <div class="flex-shrink-0">
                @php
                    $colors = [
                        'pendiente' => ['bg-slate-100', 'text-slate-700', trim($studyRequest->comprobante_pago) ? 'Pago en Revisión' : 'Pendiente de Pago'],
                        'pago_verificado' => ['bg-arena-claro/25', 'text-guinda-ceaa', 'Pago Verificado'],
                        'muestreo_programado' => ['bg-arena-claro/20', 'text-guinda-ceaa', 'Muestreo Programado'],
                        'en_analisis' => ['bg-arena-claro/20', 'text-purple-800', 'En Análisis (Laboratorio)'],
                        'completado' => ['bg-arena-claro/30', 'text-guinda-ceaa', 'Completado - Resultados Listos'],
                        'rechazado' => ['bg-red-100', 'text-red-800', 'Rechazado/Cancelado'],
                    ];
                    $currentStatus = $colors[$studyRequest->status] ?? ['bg-slate-100', 'text-slate-700', $studyRequest->status];
                @endphp
                <span class="inline-flex items-center px-4 py-2 rounded-full text-xs font-bold {{ $currentStatus[0] }} {{ $currentStatus[1] }} border border-current/10 uppercase tracking-wider">
                    {{ $currentStatus[2] }}
                </span>
            </div>
        </div>

        <!-- Tracking Visual Timeline -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
            <h2 class="text-lg font-bold font-title text-guinda-ceaa">Progreso de su Trámite</h2>
            
            @php
                $statusOrder = ['pendiente', 'pago_verificado', 'muestreo_programado', 'en_analisis', 'completado'];
                $currentIndex = array_search($studyRequest->status, $statusOrder);
                // If rejected, it sits outside
                $isRejected = $studyRequest->status === 'rechazado';
            @endphp

            @if($isRejected)
                <div class="bg-red-50 border border-red-200 text-red-800 rounded-2xl p-4 text-xs font-medium space-y-2">
                    <p>Esta solicitud ha sido rechazada o cancelada por el personal de la CEAA. Por favor, póngase en contacto con la Dirección de Calidad del Agua para solventar y poder continuar con el servicio. </p>
                    @if($studyRequest->comentarios_staff)
                        <div class="bg-white p-3.5 rounded-xl border border-red-100 text-slate-700 font-normal leading-relaxed text-[11px]">
                            <strong class="text-red-800 block uppercase text-[9px] tracking-wider mb-1">Motivo del Rechazo:</strong>
                            {{ $studyRequest->comentarios_staff }}
                        </div>
                    @endif
                </div>
            @else
                <div class="relative flex flex-col md:flex-row justify-between items-start md:items-center gap-6 md:gap-2">
                    <!-- Line connector for desktop -->
                    <div class="hidden md:block absolute left-8 right-8 top-1/2 -translate-y-1/2 h-1 bg-slate-200 -z-0"></div>
                    
                    @foreach([
                        ['pendiente', 'Registro y Pago', 'Pendiente de depósito'],
                        ['pago_verificado', 'Pago Aprobado', 'Comprobante recibido'],
                        ['muestreo_programado', 'Programación', 'Toma de muestras'],
                        ['en_analisis', 'En Ensayo', 'Fase de laboratorio'],
                        ['completado', 'Finalizado', 'Resultados disponibles']
                    ] as $index => $step)
                        @php
                            $stepStatus = $step[0];
                            $isDone = $currentIndex >= $index;
                            $isCurrent = $studyRequest->status === $stepStatus;
                            $description = $step[2];
                            if ($stepStatus === 'pendiente' && trim($studyRequest->comprobante_pago)) {
                                $description = 'Pago en revisión';
                            }
                        @endphp
                        <div class="relative z-10 flex flex-row md:flex-col items-center md:text-center space-x-4 md:space-x-0 md:space-y-2 w-full md:w-1/5">
                            <div class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs border-2 transition
                                {{ $isDone ? 'bg-guinda-ceaa border-emerald-600 text-white shadow-md' : 'bg-white border-slate-300 text-slate-400' }}
                                {{ $isCurrent ? 'ring-4 ring-arena-claro/50 scale-110' : '' }}">
                                @if($isDone && !$isCurrent)
                                    &check;
                                @else
                                    {{ $index + 1 }}
                                @endif
                            </div>
                            <div>
                                <h3 class="text-xs font-bold text-slate-800 md:text-[11px] uppercase tracking-wide">{{ $step[1] }}</h3>
                                <p class="text-[10px] text-slate-400 leading-normal">{{ $description }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Appointment / Response Details from Staff -->
        @if($studyRequest->fecha_muestreo || $studyRequest->comentarios_staff || ($studyRequest->status === 'completado' && $studyRequest->archivo_resultados))
            <div class="bg-arena-claro/10/40 border border-dorado-ocre/20 rounded-3xl p-6 sm:p-8 space-y-6">
                <h2 class="text-lg font-bold font-title text-guinda-ceaa">Notificaciones de la CEAA</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($studyRequest->fecha_muestreo)
                        <div class="bg-white p-4 rounded-xl border border-dorado-ocre/30 shadow-sm space-y-1">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Visita de Toma de Muestras</span>
                            <span class="text-sm font-extrabold text-amber-950 block">
                                {{ $studyRequest->fecha_muestreo->format('d/m/Y') }} a las {{ $studyRequest->fecha_muestreo->format('H:i') }} hrs.
                            </span>
                            <span class="text-[10px] text-slate-500">Personal de la CEAA acudirá a la dirección indicada. Favor de brindar acceso.</span>
                        </div>
                    @endif

                    @if($studyRequest->status === 'completado' && $studyRequest->archivo_resultados)
                        @if(!$studyRequest->encuesta_respondida)
                            <div class="bg-[#BC955B] text-white p-5 rounded-2xl shadow-md md:col-span-2 space-y-4">
                                <div class="flex items-center space-x-3">
                                    <svg class="w-8 h-8 text-white flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    <div>
                                        <h3 class="font-bold text-sm">Encuesta de Satisfacción Obligatoria</h3>
                                        <p class="text-[11px] text-amber-50">Para poder descargar su Certificado Oficial de Resultados, le solicitamos responder brevemente esta encuesta sobre el servicio brindado por el Laboratorio CEAA.</p>
                                    </div>
                                </div>
                                
                                <div class="bg-white text-slate-800 p-5 rounded-xl shadow-inner border border-amber-200/50 space-y-6">
                                    <h4 class="text-xs font-bold text-guinda-ceaa uppercase tracking-wider border-b pb-2">Evaluación del Servicio:</h4>
                                    
                                    <form action="{{ route('solicitud.encuesta', $studyRequest->referencia_bancaria) }}" method="POST" class="space-y-4">
                                        @csrf
                                        @php
                                            $preguntas = [
                                                1 => 'Facilidad para acceder al servicio:',
                                                2 => '¿Se le atendió en el tiempo prometido?',
                                                3 => '¿Se cumplieron los requerimientos técnicos del servicio?',
                                                4 => '¿Usted recibió un trato amable del personal que lo atendió?',
                                                5 => '¿Cómo considera la competencia del personal inspector que lo atendió?',
                                                6 => '¿Cómo evaluaría la calidad del trabajo realizado durante la inspección?',
                                                7 => '¿Los métodos de inspección utilizados son adecuados a sus necesidades?',
                                                8 => '¿Cómo calificaría la calidad de la atención recibida?',
                                                9 => 'En general el servicio recibido por el Laboratorio CEAA fue:',
                                                10 => '¿Nos recomendaría?'
                                            ];
                                            $opciones = [
                                                5 => 'Excelente (5)',
                                                4 => 'Bueno (4)',
                                                3 => 'Regular (3)',
                                                2 => 'Malo (2)',
                                                1 => 'Muy malo (1)'
                                            ];
                                        @endphp

                                        <div class="space-y-3.5 max-h-96 overflow-y-auto pr-2">
                                            @foreach($preguntas as $num => $preg)
                                                <div class="p-3 rounded-xl border border-slate-100 space-y-2 bg-slate-50/50">
                                                     <span class="text-xs font-bold text-slate-700 block leading-normal">{{ $num }}. {{ $preg }} <span class="text-red-500">*</span></span>
                                                     <div class="flex flex-wrap gap-x-4 gap-y-2">
                                                         @foreach($opciones as $val => $label)
                                                             <label class="flex items-center space-x-1.5 cursor-pointer text-xs text-slate-600 hover:text-slate-800">
                                                                 <input type="radio" name="encuesta_p{{ $num }}" value="{{ $val }}" required class="text-guinda-ceaa focus:ring-guinda-ceaa border-slate-300">
                                                                 <span>{{ $label }}</span>
                                                             </label>
                                                         @endforeach
                                                     </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-2">
                                             <div class="space-y-1">
                                                 <label for="encuesta_mejoras" class="block text-xs font-bold text-slate-700 uppercase tracking-wide">¿Qué recomendaría para mejorarnos?</label>
                                                 <textarea name="encuesta_mejoras" id="encuesta_mejoras" rows="3" placeholder="Sugerencias de mejora..." class="w-full text-xs rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa py-2 px-3"></textarea>
                                             </div>
                                             <div class="space-y-1">
                                                 <label for="encuesta_comentarios" class="block text-xs font-bold text-slate-700 uppercase tracking-wide">Comentarios adicionales:</label>
                                                 <textarea name="encuesta_comentarios" id="encuesta_comentarios" rows="3" placeholder="Otros comentarios..." class="w-full text-xs rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa py-2 px-3"></textarea>
                                             </div>
                                        </div>

                                        <div class="flex justify-end pt-3">
                                             <button type="submit" class="px-6 py-3 bg-guinda-ceaa hover:bg-guinda-ceaa-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow transition">
                                                 Enviar Encuesta y Activar Descarga
                                             </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="bg-guinda-ceaa text-white p-5 rounded-2xl shadow-md md:col-span-2 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="space-y-1">
                                    <span class="text-[10px] font-bold text-emerald-200 uppercase tracking-wider block">Certificado de Ensayos Listo</span>
                                    <span class="text-xs text-white leading-tight block">El certificado oficial de resultados está firmado digitalmente. Gracias por contestar nuestra encuesta.</span>
                                </div>
                                <div class="flex items-center space-x-3 flex-shrink-0">
                                    <span class="text-[10px] text-emerald-200 font-bold bg-white/10 px-2.5 py-1 rounded-full">Encuesta completada &check;</span>
                                    <a href="{{ asset('storage/' . $studyRequest->archivo_resultados) }}" target="_blank" class="px-5 py-3 bg-white hover:bg-slate-50 text-guinda-ceaa text-xs font-bold uppercase tracking-wider rounded-xl shadow transition flex items-center space-x-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        <span>Descargar PDF</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>

                @if($studyRequest->comentarios_staff)
                    <div class="space-y-2">
                        <h4 class="text-xs font-bold text-guinda-ceaa uppercase tracking-wider">Comentarios del Personal Administrativo:</h4>
                        <div class="bg-white p-4 rounded-xl border border-dorado-ocre/20 text-xs text-slate-700 leading-relaxed whitespace-pre-line shadow-sm">
                            {{ $studyRequest->comentarios_staff }}
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Banking and Payment Guide -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Bank Details Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-lg font-bold font-title text-guinda-ceaa">Datos Bancarios para el Depósito</h2>
                    <p class="text-xs text-slate-500">Realice el pago de la cuota de recuperación con los siguientes datos.</p>
                </div>

                <div class="space-y-3.5 text-xs text-slate-700">
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400">Banco:</span>
                        <strong class="text-slate-800 font-medium">Banamex</strong>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400">Nombre de Cuenta:</span>
                        <strong class="text-slate-800 font-medium">Comisión Estatal del Agua y Alcantarillado</strong>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400">Cuenta Bancaria:</span>
                        <strong class="text-slate-800 font-semibold tracking-wide">700 421 73 434</strong>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-slate-400">CLABE Bancaria:</span>
                        <strong class="text-slate-800 font-semibold tracking-wide">00 22 90 700 421 73 43 48</strong>
                    </div>
                    <div class="flex justify-between py-1 border-b border-slate-50">
                        <span class="text-guinda-ceaa font-semibold">Referencia Bancaria:</span>
                        <strong class="bg-slate-100 px-2 py-0.5 rounded text-guinda-ceaa font-bold tracking-wider">{{ $studyRequest->referencia_bancaria }}</strong>
                    </div>
                    <div class="flex justify-between items-center py-2 bg-arena-claro/10 px-3 rounded-lg border border-dorado-ocre/20 mt-4">
                        <span class="text-guinda-ceaa font-semibold">Importe Neto ({{ $studyRequest->cantidad_muestras }} {{ $studyRequest->cantidad_muestras === 1 ? 'análisis' : 'análisis' }}):</span>
                        <span class="text-base font-extrabold text-guinda-ceaa">${{ number_format($studyRequest->importe, 2) }} <span class="text-[10px] font-semibold">MXN</span></span>
                    </div>
                </div>
            </div>

            <!-- Steps After Payment -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-6">
                <div class="border-b border-slate-100 pb-3">
                    <h2 class="text-lg font-bold font-title text-guinda-ceaa">Instrucciones de Seguimiento</h2>
                    <p class="text-xs text-slate-500">¿Qué debe hacer después de realizar el depósito?</p>
                </div>

                <ol class="space-y-4 text-xs text-slate-600 list-decimal list-inside pl-1 leading-relaxed">
                    <li class="pl-2">
                        <!--<strong class="text-slate-800">Enviar Voucher:</strong> Remita copia digitalizada o fotografía del comprobante de pago al correo oficial: <a href="mailto:ceaa.calidaddelagua@hidalgo.gob.mx" class="text-guinda-ceaa font-semibold hover:underline">ceaa.calidaddelagua@hidalgo.gob.mx</a>.-->
                        <strong class="text-slate-800">Enviar Voucher:</strong> Remita copia digitalizada o fotografía del comprobante de pago a través de esta plataforma.
                    </li>
                    <li class="pl-2">
                        <strong class="text-slate-800">Toma de Muestra:</strong> Personal técnico de la CEAA validará su pago y se pondrá en contacto para concretar la fecha y hora de la visita física del muestreo.
                    </li>
                    <li class="pl-2">
                        <strong class="text-slate-800">Resultados y Certificado:</strong> Una vez concluidos los análisis en el laboratorio, podrá consultar y descargar su certificado oficial de resultados firmado digitalmente desde esta misma plataforma.
                    </li>
                </ol>

                @if(!trim($studyRequest->comprobante_pago) || $studyRequest->status === 'rechazado')
                    <div class="mt-6 pt-5 border-t border-slate-100 space-y-3">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-guinda-ceaa">
                            {{ $studyRequest->status === 'rechazado' ? 'Reenviar Comprobante de Pago' : 'Subir Comprobante de Pago' }}
                        </h3>
                        <p class="text-[11px] text-slate-500 leading-normal">
                            {{ $studyRequest->status === 'rechazado' ? 'Su comprobante anterior fue rechazado. Por favor, suba un nuevo comprobante corregido para reanudar el trámite.' : 'Una vez realizado su depósito, suba su comprobante digital en formato PDF o imagen para agilizar la validación.' }}
                        </p>
                        
                        <form action="{{ route('solicitud.comprobante', $studyRequest->referencia_bancaria) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <div class="space-y-2">
                                <input type="file" name="comprobante_pago" id="comprobante_pago" required 
                                    onchange="checkFileSize(this)"
                                    class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-guinda-ceaa file:text-white hover:file:bg-guinda-ceaa-hover cursor-pointer" accept=".pdf,.jpg,.jpeg,.png">
                                <button type="submit" class="w-full py-2 bg-dorado-ocre hover:bg-[#a67f46] text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow transition">
                                    Enviar Comprobante
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="mt-6 pt-5 border-t border-slate-100 bg-arena-claro/10 p-4 rounded-2xl border border-dorado-ocre/20 flex items-start space-x-3">
                        <svg class="w-5 h-5 text-guinda-ceaa mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="space-y-1">
                            @if($studyRequest->status === 'pendiente')
                                <span class="text-xs font-bold text-guinda-ceaa block">Comprobante de Pago en Revisión</span>
                                <span class="text-[10px] text-slate-600 block leading-normal">Su comprobante ha sido recibido y está en proceso de validación. Una vez aprobado, en esta misma plataforma se mostrará la fecha de programación de su muestreo.</span>
                            @else
                                <span class="text-xs font-bold text-guinda-ceaa block">Pago Verificado</span>
                                <span class="text-[10px] text-slate-600 block leading-normal">El pago de su depósito ha sido validado con éxito. En esta misma plataforma se mostrará la fecha de programación de la visita para la toma de muestras.</span>
                            @endif
                            <a href="{{ asset('storage/' . $studyRequest->comprobante_pago) }}" target="_blank" class="inline-flex items-center text-[10px] text-guinda-ceaa font-bold hover:underline space-x-1 mt-1">
                                <span>Ver Archivo Cargado</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if($studyRequest->rfc)
            <!-- Invoice Download Section (only if requested and available) -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200 space-y-4">
                <div class="border-b border-slate-100 pb-3 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold font-title text-guinda-ceaa">Factura Electrónica (CFDI)</h2>
                        <p class="text-xs text-slate-500">Comprobante fiscal digital solicitado.</p>
                    </div>
                    @if($studyRequest->archivo_factura)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-arena-claro/25 text-guinda-ceaa">
                            Factura Emitida
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-500">
                            Pendiente de Emisión
                        </span>
                    @endif
                </div>

                @if($studyRequest->archivo_factura)
                    <div class="bg-arena-claro/10 p-4 rounded-2xl border border-dorado-ocre/20 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-guinda-ceaa mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            <div class="space-y-1">
                                <span class="text-xs font-bold text-slate-800 block">Descargar Comprobantes Fiscales</span>
                                <span class="text-[10px] text-slate-600 block leading-normal">Su factura electrónica está lista en formato ZIP (contiene los archivos PDF y XML correspondientes).</span>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $studyRequest->archivo_factura) }}" target="_blank" class="px-5 py-2.5 bg-guinda-ceaa hover:bg-guinda-ceaa-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition whitespace-nowrap text-center">
                            Descargar Factura (ZIP)
                        </a>
                    </div>
                @else
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 flex items-start space-x-3">
                        <svg class="w-5 h-5 text-slate-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <div class="space-y-1">
                            <span class="text-xs font-bold text-slate-500 block">Factura en Proceso</span>
                            <span class="text-[10px] text-slate-500 block leading-normal">El personal del área de administración está procesando la emisión de su factura con los datos fiscales proporcionados. Podrá descargarla en esta sección en cuanto sea cargada.</span>
                        </div>
                    </div>
                @endif
            </div>
        @endif

        <!-- Detailed Request Data Accordion -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-slate-200">
            <h3 class="text-sm font-bold uppercase tracking-wider text-guinda-ceaa border-b border-slate-100 pb-2 mb-4">Resumen de Datos Enviados</h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div>
                    <span class="text-slate-400 block">Representante Legal:</span>
                    <span class="font-medium text-slate-800">{{ $studyRequest->representante }} ({{ $studyRequest->puesto_departamento }})</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Contacto:</span>
                    <span class="font-medium text-slate-800">{{ $studyRequest->email }} @if($studyRequest->telefono) | {{ $studyRequest->telefono }} @endif</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Dirección de Muestreo:</span>
                    <span class="font-medium text-slate-800 leading-normal">{{ $studyRequest->direccion }}</span>
                </div>
                <div>
                    <span class="text-slate-400 block">Punto(s) de Muestreo:</span>
                    <span class="font-medium text-slate-800">
                        {{ implode(', ', $studyRequest->puntos_muestreo) }}
                        @if($studyRequest->punto_muestreo_especificar)
                            ({{ $studyRequest->punto_muestreo_especificar }})
                        @endif
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 block">Tipo(s) de Muestra:</span>
                    <span class="font-medium text-slate-800">{{ implode(', ', $studyRequest->tipos_muestra) }}</span>
                </div>
                <div class="sm:col-span-2">
                    <span class="text-slate-400 block">Normas Solicitadas:</span>
                    <span class="font-medium text-slate-800 block leading-relaxed">
                        @foreach($studyRequest->normativas as $norma)
                            @if($norma === 'NOM-001-SEMARNAT-2021')
                                &bull; NOM-001-SEMARNAT-2021 (Descargas en cuerpos nacionales)<br>
                            @elseif($norma === 'NOM-002-ECOL-1996')
                                &bull; NOM-002-ECOL-1996 (Descargas en alcantarillado municipal)<br>
                            @elseif($norma === 'NOM-003-ECOL-1997')
                                &bull; NOM-003-ECOL-1997 (Aguas residuales tratadas para reuso)<br>
                            @elseif($norma === 'NOM-127-SSA1-2021')
                                &bull; NOM-127-SSA1-2021 (Calidad de agua para consumo humano)<br>
                            @else
                                &bull; {{ $norma }} @if($studyRequest->normativa_especificar) ({{ $studyRequest->normativa_especificar }}) @endif <br>
                            @endif
                        @endforeach
                    </span>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-500 py-6 px-4 text-center text-xs border-t border-slate-800">
        &copy; {{ date('Y') }} Comisión Estatal del Agua y Alcantarillado - CEAA. Hidalgo.
    </footer>

    <script>
        function checkFileSize(input) {
            if (input.files && input.files[0]) {
                const maxSize = 5 * 1024 * 1024; // 5 MB
                if (input.files[0].size > maxSize) {
                    alert('El archivo seleccionado excede el tamaño máximo permitido de 5 MB. Por favor, seleccione un archivo más pequeño.');
                    input.value = ''; // Clear selection
                }
            }
        }
    </script>
</body>
</html>
