<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-guinda-ceaa leading-tight font-title">
                Gestionar Solicitud: {{ $studyRequest->referencia_bancaria }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-xs text-slate-500 hover:text-slate-700 flex items-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Volver a la bandeja</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-arena-claro/15 border-l-4 border-guinda-ceaa p-4 rounded-xl shadow-sm text-sm text-guinda-ceaa font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
                    <div class="flex">
                        <div class="ml-3">
                            <h3 class="text-xs font-bold text-red-800 uppercase tracking-wider">Errores al actualizar:</h3>
                            <ul class="mt-1 list-disc list-inside text-xs text-red-700 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left 2 Columns: Request Details -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Solicitante -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-guinda-ceaa border-b border-slate-100 pb-2 mb-4">Datos del Solicitante</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div>
                                <span class="text-slate-400 block">Solicitante (Ayuntamiento/Organismo):</span>
                                <span class="font-bold text-slate-800 text-sm">{{ $studyRequest->solicitante }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Representante Legal:</span>
                                <span class="font-semibold text-slate-800 text-sm">{{ $studyRequest->representante }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Puesto o Departamento:</span>
                                <span class="font-medium text-slate-700">{{ $studyRequest->puesto_departamento }}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block">Información de Contacto:</span>
                                <span class="font-semibold text-slate-700">{{ $studyRequest->email }} @if($studyRequest->telefono) | {{ $studyRequest->telefono }} @endif</span>
                            </div>
                            <div class="sm:col-span-2">
                                <span class="text-slate-400 block">Dirección:</span>
                                <span class="font-medium text-slate-700 leading-normal">{{ $studyRequest->direccion }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Muestra y Normas -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-guinda-ceaa border-b border-slate-100 pb-2 mb-4">Datos de la Muestra e Inspección</h3>
                        <div class="space-y-4 text-xs">
                            <div>
                                <span class="text-slate-400 block font-semibold mb-1">Puntos de Muestreo:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($studyRequest->puntos_muestreo as $punto)
                                        <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md font-semibold">{{ $punto }}</span>
                                    @endforeach
                                    @if($studyRequest->punto_muestreo_especificar)
                                        <span class="bg-arena-claro/10 border border-amber-200 text-guinda-ceaa px-2.5 py-1 rounded-md font-semibold">Esp: {{ $studyRequest->punto_muestreo_especificar }}</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <span class="text-slate-400 block font-semibold mb-1">Tipo de Muestra:</span>
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach($studyRequest->tipos_muestra as $tipo)
                                        <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md font-semibold">{{ $tipo }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <span class="text-slate-400 block font-semibold mb-2">Normativa Solicitada (Normas a cumplir):</span>
                                <ul class="space-y-1.5 list-disc list-inside text-slate-700 font-medium">
                                    @foreach($studyRequest->normativas as $norma)
                                        <li>
                                            @if($norma === 'NOM-001-SEMARNAT-2021')
                                                NOM-001-SEMARNAT-2021 "Límites permisibles de contaminantes en las descargas de aguas residuales en cuerpos receptores propiedad de la nación."
                                            @elseif($norma === 'NOM-002-ECOL-1996')
                                                NOM-002-ECOL-1996 "Límites máximos permisibles de contaminantes en las descargas de aguas residuales a los sistemas de alcantarillado urbano o municipal."
                                            @elseif($norma === 'NOM-003-ECOL-1997')
                                                NOM-003-ECOL-1997 "Límites máximos permisibles de contaminantes para las aguas residuales tratadas que se reusen en servicios al público."
                                            @elseif($norma === 'NOM-127-SSA1-2021')
                                                NOM-127-SSA1-2021 "Agua para uso y consumo humano. Límites permisibles de la calidad del agua."
                                            @else
                                                {{ $norma }} @if($studyRequest->normativa_especificar) ({{ $studyRequest->normativa_especificar }}) @endif
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            
                            <div class="border-t border-slate-100 pt-4 mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <span class="text-slate-400 block font-semibold">Cantidad de Análisis / Muestras:</span>
                                    <span class="font-bold text-slate-800 text-sm">{{ $studyRequest->cantidad_muestras }} {{ $studyRequest->cantidad_muestras === 1 ? 'análisis' : 'análisis' }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block font-semibold">Importe Neto de Recuperación:</span>
                                    <span class="font-bold text-guinda-ceaa text-sm">${{ number_format($studyRequest->importe, 2) }} MXN</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(in_array(Auth::user()->role, ['admin', 'administracion']))
                    <!-- Facturación -->
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-guinda-ceaa border-b border-slate-100 pb-2 mb-4">Información de Facturación</h3>
                        @if($studyRequest->rfc)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                                <div>
                                    <span class="text-slate-400 block">RFC:</span>
                                    <span class="font-bold text-slate-800">{{ $studyRequest->rfc }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Razón Social:</span>
                                    <span class="font-semibold text-slate-800">{{ $studyRequest->razon_social }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Uso de CFDI:</span>
                                    <span class="font-medium text-slate-700">{{ $studyRequest->uso_cfdi }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Método de Pago:</span>
                                    <span class="font-medium text-slate-700">{{ $studyRequest->metodo_pago }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Forma de Pago:</span>
                                    <span class="font-medium text-slate-700">{{ $studyRequest->forma_pago }}</span>
                                </div>
                                <div>
                                    <span class="text-slate-400 block">Últimos 4 dígitos Cuenta:</span>
                                    <span class="font-medium text-slate-700 font-mono">{{ $studyRequest->ultimos_cuatro_digitos ?: 'N/A' }}</span>
                                </div>
                                <div class="sm:col-span-2">
                                    <span class="text-slate-400 block">Dirección Fiscal:</span>
                                    <span class="font-medium text-slate-700 leading-normal">{{ $studyRequest->direccion_fiscal }}</span>
                                </div>

                                @if($studyRequest->archivo_factura)
                                    <div class="sm:col-span-2 mt-2 p-3 bg-arena-claro/10 border border-dorado-ocre/20 rounded-xl flex items-center justify-between">
                                        <div class="flex items-center space-x-2 text-xs">
                                            <svg class="w-5 h-5 text-guinda-ceaa flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            <span class="font-semibold text-slate-800 font-title">Factura cargada (ZIP)</span>
                                        </div>
                                        <a href="{{ asset('storage/' . $studyRequest->archivo_factura) }}" target="_blank" class="px-3 py-1 bg-guinda-ceaa hover:bg-guinda-ceaa-hover text-white text-[10px] font-bold uppercase tracking-wider rounded-lg transition shadow-sm">
                                            Descargar
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <form action="{{ route('dashboard.solicitud.factura', $studyRequest->id) }}" method="POST" enctype="multipart/form-data" class="mt-6 pt-5 border-t border-slate-100 space-y-3">
                                @csrf
                                <label for="archivo_factura" class="block text-xs font-semibold uppercase tracking-wider text-slate-500">Adjuntar/Actualizar ZIP de Factura</label>
                                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
                                    <input type="file" name="archivo_factura" id="archivo_factura" required accept=".zip" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-guinda-ceaa file:text-white hover:file:bg-guinda-ceaa-hover cursor-pointer border border-slate-200 rounded-xl p-1">
                                    <button type="submit" class="px-5 py-2.5 bg-dorado-ocre hover:bg-[#a67f46] text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition whitespace-nowrap">
                                        Subir ZIP
                                    </button>
                                </div>
                            </form>
                        @else
                            <p class="text-xs text-slate-400 italic">El solicitante no requirió factura para este trámite.</p>
                        @endif
                    </div>
                    @endif

                    <!-- Encuesta de Satisfacción -->
                    @if($studyRequest->encuesta_respondida)
                        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 space-y-4">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-guinda-ceaa border-b border-slate-100 pb-2 flex items-center justify-between font-title">
                                <span>Encuesta de Satisfacción del Usuario</span>
                                <span class="text-xs font-bold bg-[#BC955B]/10 text-guinda-ceaa px-3 py-1 rounded-full font-sans">Promedio: {{ number_format($studyRequest->encuesta_promedio, 2) }} / 5.00</span>
                            </h3>
                            
                            @php
                                $preguntas = [
                                    1 => 'Facilidad para acceder al servicio.',
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
                            @endphp

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-[11px]">
                                @foreach($preguntas as $num => $preg)
                                    @php
                                        $score = $studyRequest->{"encuesta_p{$num}"};
                                        $label = match($score) {
                                            5 => 'Excelente (5)',
                                            4 => 'Bueno (4)',
                                            3 => 'Regular (3)',
                                            2 => 'Malo (2)',
                                            1 => 'Muy malo (1)',
                                            default => 'N/A'
                                        };
                                    @endphp
                                    <div class="py-2.5 px-3.5 rounded-xl border border-slate-100 bg-slate-50/50 flex justify-between items-center gap-2">
                                        <span class="text-slate-600 font-medium leading-tight max-w-[70%]">{{ $num }}. {{ $preg }}</span>
                                        <span class="font-bold text-guinda-ceaa whitespace-nowrap">{{ $label }}</span>
                                    </div>
                                @endforeach

                                <div class="sm:col-span-2 space-y-3 pt-3 border-t border-slate-100">
                                    <div>
                                        <span class="text-slate-400 block font-bold uppercase text-[9px] tracking-wider">¿Qué recomendaría para mejorarnos?</span>
                                        <p class="font-medium text-slate-800 bg-slate-50 p-3.5 rounded-xl border border-slate-200/80 mt-1 leading-relaxed">{{ $studyRequest->encuesta_mejoras ?: 'Sin respuesta.' }}</p>
                                    </div>
                                    <div class="pt-1">
                                        <span class="text-slate-400 block font-bold uppercase text-[9px] tracking-wider">Comentarios adicionales:</span>
                                        <p class="font-medium text-slate-800 bg-slate-50 p-3.5 rounded-xl border border-slate-200/80 mt-1 leading-relaxed">{{ $studyRequest->encuesta_comentarios ?: 'Sin respuesta.' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Administrative Portal Actions -->
                <div class="space-y-6">
                    
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 space-y-6">
                        <div class="border-b border-slate-100 pb-3">
                            <h3 class="text-sm font-bold uppercase tracking-wider text-guinda-ceaa font-title">Panel de Gestión CEAA</h3>
                            <p class="text-[10px] text-slate-500">Avance secuencial del estado del trámite y programación técnica.</p>
                        </div>

                        <div class="space-y-4">
                            <!-- Visual step indicator -->
                            <div class="flex items-center justify-between text-[10px] uppercase font-bold text-slate-400 bg-slate-50 p-3 rounded-2xl border border-slate-200/50">
                                @php
                                    $stepOrder = ['pendiente' => 1, 'pago_verificado' => 2, 'muestreo_programado' => 3, 'en_analisis' => 4, 'completado' => 5, 'rechazado' => 0];
                                    $currentStepNum = $stepOrder[$studyRequest->status] ?? 1;
                                @endphp
                                @if($studyRequest->status === 'rechazado')
                                    <span class="text-red-600 font-extrabold">&times; SOLICITUD RECHAZADA</span>
                                @else
                                    <span class="{{ $currentStepNum >= 1 ? 'text-guinda-ceaa' : '' }}">1. Pago</span>
                                    <span class="text-slate-300">&rarr;</span>
                                    <span class="{{ $currentStepNum >= 2 ? 'text-guinda-ceaa' : '' }}">2. Agenda</span>
                                    <span class="text-slate-300">&rarr;</span>
                                    <span class="{{ $currentStepNum >= 3 ? 'text-guinda-ceaa' : '' }}">3. Visita</span>
                                    <span class="text-slate-300">&rarr;</span>
                                    <span class="{{ $currentStepNum >= 4 ? 'text-guinda-ceaa' : '' }}">4. Lab</span>
                                    <span class="text-slate-300">&rarr;</span>
                                    <span class="{{ $currentStepNum >= 5 ? 'text-guinda-ceaa' : '' }}">5. Fin</span>
                                @endif
                            </div>

                            @if(in_array(Auth::user()->role, ['admin', 'laboratorio']))
                            <form x-data="{ showRejection: false }" action="{{ route('dashboard.solicitud.actualizar', $studyRequest->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                                @csrf

                                <!-- Comprobante de Pago Subido (only show if pendiente or pago_verificado) -->
                                @if(in_array($studyRequest->status, ['pendiente', 'pago_verificado']))
                                    @if($studyRequest->comprobante_pago)
                                        <div class="bg-[#BC955B]/10 p-3.5 rounded-xl border border-dorado-ocre/20 space-y-2">
                                            <div class="flex items-center space-x-2">
                                                <svg class="text-guinda-ceaa flex-shrink-0" width="20" height="20" style="width: 20px; height: 20px; min-width: 20px; min-height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                <span class="font-bold text-guinda-ceaa uppercase tracking-wider text-[9px]">Comprobante de Pago Cargado</span>
                                            </div>
                                            <p class="text-[10px] text-slate-600 leading-normal">El solicitante cargó su recibo de pago digital para su verificación por parte del staff.</p>
                                            <a href="{{ asset('storage/' . $studyRequest->comprobante_pago) }}" target="_blank" class="inline-flex items-center text-[10px] font-bold text-guinda-ceaa hover:underline space-x-0.5">
                                                <span>Ver Comprobante</span>
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                            </a>
                                        </div>
                                    @else
                                        <div class="bg-slate-50 p-3.5 rounded-xl border border-slate-200 text-center">
                                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Sin Comprobante de Pago</span>
                                            <p class="text-[10px] text-slate-500 leading-normal mt-1">El solicitante aún no ha cargado su comprobante de pago en el portal público.</p>
                                        </div>
                                    @endif
                                @endif

                                <!-- Paso 1: PENDIENTE DE PAGO -->
                                @if($studyRequest->status === 'pendiente')
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                                        <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px]">Paso 1: Validar Pago</h4>
                                        
                                        <div x-show="!showRejection" class="space-y-3">
                                            <p class="text-[10px] text-slate-500">Revise el comprobante bancario cargado. Una vez confirmado que el depósito es correcto, presione validar para avanzar.</p>
                                            
                                            @if($studyRequest->comprobante_pago)
                                                <button type="submit" onclick="document.getElementById('status-input').value='pago_verificado';" class="w-full py-2 bg-guinda-ceaa hover:bg-guinda-ceaa-hover text-white text-xs font-bold uppercase rounded-lg shadow-sm transition cursor-pointer flex items-center justify-center space-x-1.5">
                                                    <svg class="text-white flex-shrink-0" width="16" height="16" style="width: 16px; height: 16px; min-width: 16px; min-height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                                    <span>Validar Pago y Avanzar</span>
                                                </button>
                                            @else
                                                <button type="button" disabled class="w-full py-2 bg-slate-200 text-slate-400 text-xs font-bold uppercase rounded-lg cursor-not-allowed border border-slate-300 flex items-center justify-center space-x-1.5">
                                                    <svg class="text-slate-400 flex-shrink-0" width="16" height="16" style="width: 16px; height: 16px; min-width: 16px; min-height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                    <span>Validar Pago (Bloqueado)</span>
                                                </button>
                                                <span class="block text-[9px] text-red-600 font-semibold leading-normal text-center mt-1 font-sans">* Requiere que el solicitante cargue primero el comprobante.</span>
                                            @endif
                                            
                                            <button type="button" @click="showRejection = true" class="w-full py-1 text-red-700 hover:text-red-800 text-[10px] font-bold text-center block mt-1 hover:underline cursor-pointer bg-transparent border-0">
                                                Rechazar Solicitud
                                            </button>
                                        </div>

                                        <div x-show="showRejection" x-cloak class="space-y-3" x-transition>
                                            <label for="motivo_rechazo" class="block font-bold text-red-700 uppercase tracking-wider text-[9px]">Motivo del Rechazo <span class="text-red-500">*</span></label>
                                            <textarea name="comentarios_staff" id="motivo_rechazo" rows="3" placeholder="Escriba detalladamente la razón del rechazo de la solicitud..." :required="showRejection" :disabled="!showRejection" class="w-full rounded-lg border-red-300 shadow-sm focus:border-red-500 focus:ring-red-500 text-xs py-1.5 bg-white"></textarea>
                                            
                                            <div class="flex space-x-2">
                                                <button type="submit" onclick="document.getElementById('status-input').value='rechazado';" class="flex-1 py-2 bg-red-600 hover:bg-red-700 text-white text-[10px] font-bold uppercase rounded-lg shadow-sm transition cursor-pointer">
                                                    Confirmar Rechazo
                                                </button>
                                                <button type="button" @click="showRejection = false" class="py-2 px-3 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold uppercase rounded-lg transition cursor-pointer">
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Paso 2: PAGO VERIFICADO (Agendar Muestreo) -->
                                @if($studyRequest->status === 'pago_verificado')
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                                        <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px]">Paso 2: Programar Muestreo</h4>
                                        <p class="text-[10px] text-slate-500">El pago está validado. Ingrese la fecha y hora programada para acudir a realizar la toma de muestras física.</p>
                                        
                                        <div class="space-y-1">
                                            <label for="fecha_muestreo" class="block font-bold text-slate-500 uppercase tracking-wider text-[9px]">Fecha y Hora de la Visita</label>
                                            <input type="text" name="fecha_muestreo" id="fecha_muestreo" placeholder="Seleccione fecha y hora..." readonly class="w-full rounded-lg border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa py-1.5 text-xs bg-white cursor-pointer">
                                        </div>

                                        <button type="submit" onclick="document.getElementById('status-input').value='muestreo_programado';" class="w-full py-2 bg-guinda-ceaa hover:bg-guinda-ceaa-hover text-white text-xs font-bold uppercase rounded-lg shadow-sm transition cursor-pointer">
                                            Programar Visita de Muestreo
                                        </button>
                                    </div>
                                @endif

                                <!-- Paso 3: MUESTREO PROGRAMADO (Notificar realizado) -->
                                @if($studyRequest->status === 'muestreo_programado')
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                                        <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px]">Paso 3: Notificar Muestreo Realizado</h4>
                                        <p class="text-[10px] text-slate-500">Visita programada para: <strong class="text-slate-800">{{ $studyRequest->fecha_muestreo->format('d/m/Y H:i') }}</strong>. Una vez realizada la visita de campo, presione el botón para indicar que las muestras están en el laboratorio.</p>
                                        
                                        <!-- Hidden date input to preserve value when submiting from this step -->
                                        <input type="hidden" name="fecha_muestreo" value="{{ $studyRequest->fecha_muestreo->format('Y-m-d\TH:i') }}">

                                        <button type="submit" onclick="document.getElementById('status-input').value='en_analisis';" class="w-full py-2 bg-guinda-ceaa hover:bg-guinda-ceaa-hover text-white text-xs font-bold uppercase rounded-lg shadow-sm transition cursor-pointer">
                                            Muestreo Realizado &rarr; En Análisis
                                        </button>
                                        
                                        <button type="submit" onclick="document.getElementById('status-input').value='pago_verificado';" class="w-full py-1 text-slate-500 hover:text-slate-700 text-[10px] font-bold text-center block mt-1 hover:underline cursor-pointer bg-transparent border-0">
                                            Reprogramar / Volver a agenda
                                        </button>
                                    </div>
                                @endif

                                <!-- Paso 4: EN ANÁLISIS (Cargar resultados) -->
                                @if($studyRequest->status === 'en_analisis')
                                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-3">
                                        <h4 class="font-bold text-slate-700 uppercase tracking-wider text-[10px]">Paso 4: Cargar Certificado y Concluir</h4>
                                        <p class="text-[10px] text-slate-500">El estudio está en fase de laboratorio. Suba el Certificado de Resultados Oficial en formato PDF para dar respuesta definitiva al trámite.</p>
                                        
                                        <div class="space-y-1">
                                            <label for="archivo_resultados" class="block font-bold text-slate-500 uppercase tracking-wider text-[9px]">Subir Archivo de Resultados (PDF)</label>
                                            <input type="file" name="archivo_resultados" id="archivo_resultados" accept=".pdf" class="w-full text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[10px] file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200">
                                        </div>

                                        <button type="submit" onclick="document.getElementById('status-input').value='completado';" class="w-full py-2 bg-guinda-ceaa hover:bg-guinda-ceaa-hover text-white text-xs font-bold uppercase rounded-lg shadow-sm transition cursor-pointer">
                                            Cargar Resultados y Concluir
                                        </button>
                                    </div>
                                @endif

                                <!-- Trámite Concluido -->
                                @if($studyRequest->status === 'completado')
                                    <div class="bg-arena-claro/10 p-4 rounded-xl border border-dorado-ocre/20 space-y-3 text-center">
                                        <div class="flex items-center justify-center space-x-1.5">
                                            <span class="w-2 h-2 bg-guinda-ceaa rounded-full animate-ping"></span>
                                            <h4 class="font-bold text-guinda-ceaa uppercase tracking-wider text-[10px]">Trámite Concluido</h4>
                                        </div>
                                        <p class="text-[10px] text-slate-600 leading-normal">El reporte de ensayos y los resultados están publicados oficialmente para el usuario.</p>
                                        
                                        @if($studyRequest->archivo_resultados)
                                            <div class="bg-white p-3 rounded-xl border border-slate-200 flex items-center justify-between text-left shadow-sm">
                                                <div class="flex items-center space-x-2 truncate">
                                                    <svg class="w-5 h-5 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                    <span class="font-bold text-[10px] text-slate-700 truncate uppercase">Resultados_Oficiales.pdf</span>
                                                </div>
                                                <a href="{{ asset('storage/' . $studyRequest->archivo_resultados) }}" target="_blank" class="text-[10px] font-extrabold text-guinda-ceaa hover:underline whitespace-nowrap ml-2 flex items-center space-x-0.5">
                                                    <span>Ver Documento</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                </a>
                                            </div>
                                        @endif

                                        <div class="pt-2 border-t border-slate-100 flex justify-between items-center text-[10px]">
                                            <span class="text-slate-400">Encuesta de Satisfacción:</span>
                                            @if($studyRequest->encuesta_respondida)
                                                <span class="text-emerald-700 font-extrabold uppercase text-[9px] flex items-center space-x-0.5">
                                                    <span>Respondida</span>
                                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                </span>
                                            @else
                                                <span class="text-slate-400 italic">Pendiente por el usuario</span>
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                <!-- Trámite Rechazado -->
                                @if($studyRequest->status === 'rechazado')
                                    <div class="bg-red-50 p-4 rounded-xl border border-red-200 space-y-3 text-center">
                                        <h4 class="font-bold text-red-800 uppercase tracking-wider text-[10px]">Solicitud Rechazada</h4>
                                        <p class="text-[10px] text-red-600">Este trámite ha sido rechazado o cancelado.</p>

                                        @if($studyRequest->comentarios_staff)
                                            <div class="bg-white p-3 rounded-xl border border-red-100 text-left text-xs space-y-1">
                                                <span class="font-bold text-red-800 text-[9px] uppercase tracking-wider block">Motivo del Rechazo:</span>
                                                <p class="text-[10px] text-slate-700 leading-normal whitespace-pre-line">{{ $studyRequest->comentarios_staff }}</p>
                                            </div>
                                        @endif
                                        
                                        <button type="submit" onclick="document.getElementById('status-input').value='pendiente';" class="w-full py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-[10px] font-bold uppercase rounded-lg transition cursor-pointer">
                                            Reabrir / Restaurar Solicitud
                                        </button>
                                    </div>
                                @endif

                                <!-- Single Hidden Status Input -->
                                <input type="hidden" name="status" id="status-input" value="{{ $studyRequest->status }}">

                                <!-- Comments Section (Available at all active states to write messages to the user) -->
                                @if($studyRequest->status !== 'rechazado')
                                    <div x-show="!showRejection" x-cloak class="space-y-1.5 pt-2 border-t border-slate-100" x-transition>
                                        <label for="comentarios_staff" class="block font-bold text-slate-500 uppercase tracking-wider text-[9px]">Comentarios / Observaciones al Solicitante</label>
                                        <textarea name="comentarios_staff" id="comentarios_staff" :disabled="showRejection" rows="3" placeholder="Comentarios adicionales que el ciudadano podrá ver al consultar su folio..." class="w-full rounded-lg border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-xs py-1.5">{{ $studyRequest->comentarios_staff }}</textarea>
                                        @if($studyRequest->status !== 'completado')
                                            <div class="flex justify-end">
                                                <button type="submit" onclick="document.getElementById('status-input').value='{{ $studyRequest->status }}';" class="text-[10px] font-bold text-guinda-ceaa hover:underline bg-transparent border-0 cursor-pointer flex items-center space-x-1">
                                                    <svg class="w-4 h-4 text-guinda-ceaa" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2v-9a2 2 0 00-2-2h-3m-1 4H8m0 0l3 3m-3-3l3-3"></path></svg>
                                                    <span>Guardar Solo Comentarios</span>
                                                </button>
                                            </div>
                                        @else
                                            <button type="submit" onclick="document.getElementById('status-input').value='completado';" class="w-full py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase rounded-lg transition cursor-pointer">
                                                Actualizar Comentarios
                                            </button>
                                        @endif
                                    </div>
                                @endif
                            </form>
                            @else
                                <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-center space-y-1.5 text-xs text-slate-500">
                                    <span class="font-bold text-slate-700 uppercase tracking-wider text-[10px] block">Acciones Técnicas Restringidas</span>
                                    <p class="leading-normal">Su rol de Administración está enfocado en la gestión fiscal del depósito y la emisión de facturas. Las tareas técnicas de laboratorio y agenda de visitas están restringidas.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- External Link card -->
                    <div class="bg-slate-50 rounded-3xl p-6 shadow-inner border border-slate-200/60 text-center space-y-3">
                        <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest block">Enlace de Consulta del Solicitante</span>
                        <p class="text-[10px] text-slate-500 leading-normal">
                            Este es el enlace público que tiene el solicitante para verificar su estado en tiempo real.
                        </p>
                        <a href="{{ route('solicitud.ver', $studyRequest->referencia_bancaria) }}" target="_blank" class="inline-flex items-center text-xs font-bold text-guinda-ceaa hover:underline">
                                                            <span>Ver Página del Solicitante</span>
                                                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <!-- Flatpickr CSS & JS integration -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <style>
        .flatpickr-day.selected, 
        .flatpickr-day.startRange, 
        .flatpickr-day.endRange, 
        .flatpickr-day.selected.inRange, 
        .flatpickr-day.startRange.inRange, 
        .flatpickr-day.endRange.inRange, 
        .flatpickr-day.selected:focus, 
        .flatpickr-day.startRange:focus, 
        .flatpickr-day.endRange:focus, 
        .flatpickr-day.selected:hover, 
        .flatpickr-day.startRange:hover, 
        .flatpickr-day.endRange:hover, 
        .flatpickr-day.prevMonthDay.selected, 
        .flatpickr-day.nextMonthDay.selected {
            background: #800020 !important; /* Guinda CEAA */
            border-color: #800020 !important;
            color: #fff !important;
        }
        .flatpickr-months .flatpickr-month {
            color: #800020 !important;
            fill: #800020 !important;
        }
        .flatpickr-current-month .numInputWrapper span.arrowUp:after {
            border-bottom-color: #800020 !important;
        }
        .flatpickr-current-month .numInputWrapper span.arrowDown:after {
            border-top-color: #800020 !important;
        }
        .flatpickr-months .flatpickr-prev-month:hover svg, 
        .flatpickr-months .flatpickr-next-month:hover svg {
            fill: #800020 !important;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const occupiedDates = @json($occupiedDates ?? []);

            flatpickr("#fecha_muestreo", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                locale: "es",
                minDate: "today",
                disable: occupiedDates
            });
        });
    </script>
</x-app-layout>
