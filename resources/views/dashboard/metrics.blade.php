<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-xl text-guinda-ceaa leading-tight font-title">
                Métricas e Indicadores del Laboratorio
            </h2>
            <div class="text-xs font-semibold text-slate-500">
                Dirección de Calidad del Agua (CEAA)
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Banner: Total Recaudado -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="p-4 bg-emerald-500/10 rounded-2xl text-emerald-600">
                        <!-- Cash Icon -->
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Total Recaudado por Servicios</div>
                        <div class="text-3xl font-black text-emerald-600 mt-1">${{ number_format($totalCollected, 2) }} <span class="text-xs font-normal text-slate-400">MXN</span></div>
                    </div>
                </div>
                <div class="text-xs text-slate-400 bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 self-start sm:self-auto">
                    Calculado a partir de solicitudes con pago verificado o completadas.
                </div>
            </div>

            <!-- Cards Grid (KPIs) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Card 1: Promedio de Encuestas -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center space-x-4">
                    <div class="p-4 bg-dorado-ocre/10 rounded-2xl text-dorado-ocre">
                        <!-- Star Icon -->
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Satisfacción
                            Promedio</div>
                        <div class="text-2xl font-black text-guinda-ceaa mt-0.5">{{ number_format($overallAverage, 2) }}
                            <span class="text-sm font-normal text-slate-400">/ 5</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Encuestas Contestadas -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center space-x-4">
                    <div class="p-4 bg-guinda-ceaa/10 rounded-2xl text-guinda-ceaa">
                        <!-- Checklist Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Encuestas
                            Respondidas</div>
                        <div class="text-2xl font-black text-slate-800 mt-0.5">{{ $totalSurveys }}</div>
                    </div>
                </div>

                <!-- Card 3: Muestras Analizadas -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center space-x-4">
                    <div class="p-4 bg-emerald-500/10 rounded-2xl text-emerald-600">
                        <!-- Beaker/Laboratory Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Muestras Analizadas
                        </div>
                        <div class="text-2xl font-black text-slate-800 mt-0.5">{{ $totalSamples }}</div>
                    </div>
                </div>

                <!-- Card 4: Solicitudes Completadas -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm flex items-center space-x-4">
                    <div class="p-4 bg-blue-500/10 rounded-2xl text-blue-600">
                        <!-- Check Circle Icon -->
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Estudios Completados
                        </div>
                        <div class="text-2xl font-black text-slate-800 mt-0.5">{{ $statusCounts['completado'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section (Grid) -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                <!-- Chart 1: Satisfacción por Pregunta -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b pb-3 border-slate-100">
                        <h3 class="font-bold text-sm text-slate-800 tracking-tight font-title">Evaluación Detallada por
                            Pregunta</h3>
                        <span
                            class="text-[10px] bg-arena-claro/15 text-guinda-ceaa font-extrabold px-2 py-0.5 rounded-full uppercase tracking-wider">Escala
                            1 al 5</span>
                    </div>
                    <div class="h-80 relative flex items-center justify-center">
                        @if($totalSurveys > 0)
                            <canvas id="surveyQuestionsChart"></canvas>
                        @else
                            <p class="text-xs text-slate-400 italic">No hay suficientes datos de encuestas para mostrar este
                                gráfico.</p>
                        @endif
                    </div>
                </div>

                <!-- Chart 2: Tipos de Muestra -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b pb-3 border-slate-100">
                        <h3 class="font-bold text-sm text-slate-800 tracking-tight font-title">Distribución de Tipos de
                            Muestra</h3>
                        <span
                            class="text-[10px] bg-slate-50 text-slate-500 font-extrabold px-2 py-0.5 rounded-full uppercase tracking-wider">Muestras
                            Activas</span>
                    </div>
                    <div class="h-80 relative flex items-center justify-center">
                        @if(count($sampleTypeCounts) > 0)
                            <canvas id="sampleTypesChart"></canvas>
                        @else
                            <p class="text-xs text-slate-400 italic">No hay suficientes datos de muestras para mostrar este
                                gráfico.</p>
                        @endif
                    </div>
                </div>

                <!-- Chart 3: Normativas Aplicadas -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b pb-3 border-slate-100">
                        <h3 class="font-bold text-sm text-slate-800 tracking-tight font-title">Normativas Solicitadas
                        </h3>
                        <span
                            class="text-[10px] bg-slate-50 text-slate-500 font-bold px-2 py-0.5 rounded-full uppercase">Frecuencia</span>
                    </div>
                    <div class="h-80 relative flex items-center justify-center">
                        @if(count($normativaCounts) > 0)
                            <canvas id="normativesChart"></canvas>
                        @else
                            <p class="text-xs text-slate-400 italic">No hay suficientes datos de normativas para mostrar
                                este gráfico.</p>
                        @endif
                    </div>
                </div>

                <!-- Chart 4: Evolución Mensual -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b pb-3 border-slate-100">
                        <h3 class="font-bold text-sm text-slate-800 tracking-tight font-title">Estudios Completados por
                            Mes</h3>
                        <span
                            class="text-[10px] bg-emerald-50 text-emerald-600 font-bold px-2 py-0.5 rounded-full uppercase">Histórico</span>
                    </div>
                    <div class="h-80 relative flex items-center justify-center">
                        @if(count($monthlyCounts) > 0)
                            <canvas id="monthlyChart"></canvas>
                        @else
                            <p class="text-xs text-slate-400 italic">Aún no hay estudios completados registrados en el
                                sistema.</p>
                        @endif
                    </div>
                </div>

            </div>

            <!-- List of Questions Reference -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-sm">
                <h3
                    class="font-bold text-sm text-slate-800 tracking-tight border-b pb-3 border-slate-100 mb-4 font-title">
                    Referencia de Preguntas Evaluadas</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-2 text-xs text-slate-600">
                    <div><span class="font-bold text-guinda-ceaa">1.</span> Facilidad para acceder al servicio</div>
                    <div><span class="font-bold text-guinda-ceaa">2.</span> Cumplimiento del tiempo prometido</div>
                    <div><span class="font-bold text-guinda-ceaa">3.</span> Cumplimiento de requerimientos técnicos
                    </div>
                    <div><span class="font-bold text-guinda-ceaa">4.</span> Trato amable del personal</div>
                    <div><span class="font-bold text-guinda-ceaa">5.</span> Competencia del inspector técnico</div>
                    <div><span class="font-bold text-guinda-ceaa">6.</span> Calidad del trabajo en la inspección</div>
                    <div><span class="font-bold text-guinda-ceaa">7.</span> Adecuación de métodos de inspección</div>
                    <div><span class="font-bold text-guinda-ceaa">8.</span> Calidad de la atención en general</div>
                    <div><span class="font-bold text-guinda-ceaa">9.</span> Calidad del servicio en general</div>
                    <div><span class="font-bold text-guinda-ceaa">10.</span> Probabilidad de recomendación</div>
                </div>
            </div>

            <!-- Recent Feedback section -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-sm text-slate-800 tracking-tight font-title">Comentarios y Recomendaciones
                        Recientes</h3>
                    <span class="text-[10px] text-slate-400 font-semibold">Últimas 15 encuestas con comentarios</span>
                </div>

                <div class="divide-y divide-slate-100 max-h-[500px] overflow-y-auto font-sans">
                    @forelse($recentFeedback as $feedback)
                        <div class="p-6 hover:bg-slate-50/50 transition space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 text-xs">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('dashboard.solicitud', $feedback->id) }}"
                                        class="font-bold text-guinda-ceaa hover:underline tracking-wide">
                                        {{ $feedback->referencia_bancaria }}
                                    </a>
                                    <span class="text-slate-300">&bull;</span>
                                    <span class="font-semibold text-slate-700">{{ $feedback->solicitante }}</span>
                                </div>
                                <div class="flex items-center space-x-3 text-slate-400">
                                    <span>{{ $feedback->updated_at->format('d/m/Y') }}</span>
                                    <span class="text-slate-300">&bull;</span>
                                    <div class="flex items-center space-x-1 font-bold text-guinda-ceaa">
                                        <svg class="w-4 h-4 text-dorado-ocre fill-current" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                        <span>{{ number_format($feedback->encuesta_promedio, 2) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs">
                                @if($feedback->encuesta_mejoras)
                                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                                        <span
                                            class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 font-title">Recomendación
                                            para mejorar:</span>
                                        <p class="text-slate-600 italic">"{{ $feedback->encuesta_mejoras }}"</p>
                                    </div>
                                @endif
                                @if($feedback->encuesta_comentarios)
                                    <div class="bg-slate-50 p-3.5 rounded-2xl border border-slate-100">
                                        <span
                                            class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1 font-title">Comentario
                                            adicional:</span>
                                        <p class="text-slate-600 italic">"{{ $feedback->encuesta_comentarios }}"</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-xs text-slate-400 italic">
                            No se han recibido comentarios ni sugerencias en las encuestas de satisfacción.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>

    <!-- ChartJS Scripts -->
    @if($totalSurveys > 0 || count($sampleTypeCounts) > 0 || count($normativaCounts) > 0 || count($monthlyCounts) > 0)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // 1. Chart Survey Questions
                @if($totalSurveys > 0)
                    const ctxSurvey = document.getElementById('surveyQuestionsChart').getContext('2d');
                    new Chart(ctxSurvey, {
                        type: 'bar',
                        data: {
                            labels: ['P1', 'P2', 'P3', 'P4', 'P5', 'P6', 'P7', 'P8', 'P9', 'P10'],
                            datasets: [{
                                label: 'Calificación Promedio',
                                data: [
                                                                        {{ $surveyAverages->p1 ?? 0 }},
                                                                        {{ $surveyAverages->p2 ?? 0 }},
                                                                        {{ $surveyAverages->p3 ?? 0 }},
                                                                        {{ $surveyAverages->p4 ?? 0 }},
                                                                        {{ $surveyAverages->p5 ?? 0 }},
                                                                        {{ $surveyAverages->p6 ?? 0 }},
                                                                        {{ $surveyAverages->p7 ?? 0 }},
                                                                        {{ $surveyAverages->p8 ?? 0 }},
                                                                        {{ $surveyAverages->p9 ?? 0 }},
                                    {{ $surveyAverages->p10 ?? 0 }}
                                ],
                                backgroundColor: 'rgba(188, 149, 91, 0.75)', // dorado-ocre
                                borderColor: 'rgba(188, 149, 91, 1)',
                                borderWidth: 1.5,
                                borderRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: { display: false }
                            },
                            scales: {
                                y: {
                                    min: 1,
                                    max: 5,
                                    ticks: { stepSize: 1 }
                                }
                            }
                        }
                    });
                @endif

                    // 2. Chart Sample Types
                    @if(count($sampleTypeCounts) > 0)
                        const ctxSamples = document.getElementById('sampleTypesChart').getContext('2d');
                        new Chart(ctxSamples, {
                            type: 'doughnut',
                            data: {
                                labels: {!! json_encode(array_keys($sampleTypeCounts)) !!},
                                datasets: [{
                                    data: {!! json_encode(array_values($sampleTypeCounts)) !!},
                                    backgroundColor: [
                                        '#691B31', // Guinda CEAA
                                        '#BC955B', // dorado-ocre
                                        '#DDC9A3', // arena-claro
                                        '#0D9488', // Teal
                                        '#3B82F6'  // Blue
                                    ],
                                    borderWidth: 2,
                                    borderColor: '#ffffff'
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                        labels: {
                                            boxWidth: 12,
                                            font: { size: 11 }
                                        }
                                    }
                                }
                            }
                        });
                    @endif

                    // 3. Chart Normatives
                    @if(count($normativaCounts) > 0)
                        const ctxNorms = document.getElementById('normativesChart').getContext('2d');
                        new Chart(ctxNorms, {
                            type: 'bar',
                            indexAxis: 'y',
                            data: {
                                labels: {!! json_encode(array_keys($normativaCounts)) !!},
                                datasets: [{
                                    label: 'Solicitudes',
                                    data: {!! json_encode(array_values($normativaCounts)) !!},
                                    backgroundColor: 'rgba(105, 27, 49, 0.8)', // guinda-ceaa
                                    borderColor: 'rgba(105, 27, 49, 1)',
                                    borderWidth: 1.5,
                                    borderRadius: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false }
                                },
                                scales: {
                                    x: {
                                        ticks: { precision: 0 }
                                    }
                                }
                            }
                        });
                    @endif

                    // 4. Chart Monthly completed
                    @if(count($monthlyCounts) > 0)
                        const ctxMonthly = document.getElementById('monthlyChart').getContext('2d');
                        new Chart(ctxMonthly, {
                            type: 'line',
                            data: {
                                labels: {!! json_encode(array_keys($monthlyCounts)) !!},
                                datasets: [{
                                    label: 'Estudios Completados',
                                    data: {!! json_encode(array_values($monthlyCounts)) !!},
                                    borderColor: '#691B31', // guinda-ceaa
                                    backgroundColor: 'rgba(105, 27, 49, 0.05)',
                                    fill: true,
                                    tension: 0.35,
                                    borderWidth: 3,
                                    pointBackgroundColor: '#BC955B', // dorado-ocre
                                    pointRadius: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false }
                                },
                                scales: {
                                    y: {
                                        ticks: { precision: 0 },
                                        min: 0
                                    }
                                }
                            }
                        });
                    @endif
                                });
        </script>
    @endif
</x-app-layout>