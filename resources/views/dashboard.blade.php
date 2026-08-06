<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <h2 class="font-semibold text-xl text-guinda-ceaa leading-tight font-title">
                Bandeja de Solicitudes - Calidad del Agua
            </h2>
            <div class="text-xs font-semibold text-slate-500">
                Dirección de Calidad del Agua (CEAA)
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="bg-arena-claro/15 border-l-4 border-guinda-ceaa p-4 rounded-xl shadow-sm text-sm text-guinda-ceaa font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Filters & Search Bar Card -->
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                <form action="{{ route('dashboard') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end justify-between">
                    
                    <!-- Search input -->
                    <div class="w-full md:w-1/3 space-y-1.5">
                        <label for="search" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Buscar Solicitud</label>
                        <div class="relative">
                            <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Solicitante, representante o folio..." class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-xs py-2 pl-3 pr-10">
                            @if(request('search'))
                                <a href="{{ route('dashboard', request()->except('search')) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 font-bold">&times;</a>
                            @endif
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div class="w-full md:w-1/4 space-y-1.5">
                        <label for="status" class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest font-title">Filtrar por Estado</label>
                        <select name="status" id="status" onchange="this.form.submit()" class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-xs py-2">
                            <option value="">Todos los Estados</option>
                            <option value="pendiente" {{ request('status') === 'pendiente' ? 'selected' : '' }}>Pendiente de Pago</option>
                            <option value="pago_verificado" {{ request('status') === 'pago_verificado' ? 'selected' : '' }}>Pago Verificado</option>
                            <option value="muestreo_programado" {{ request('status') === 'muestreo_programado' ? 'selected' : '' }}>Muestreo Programado</option>
                            <option value="en_analisis" {{ request('status') === 'en_analisis' ? 'selected' : '' }}>En Análisis</option>
                            <option value="completado" {{ request('status') === 'completado' ? 'selected' : '' }}>Completado</option>
                            <option value="rechazado" {{ request('status') === 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                        </select>
                    </div>

                    <!-- Clear Filters Button -->
                    <div class="w-full md:w-auto flex gap-2">
                        @if(request('status') || request('search'))
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl transition">
                                Limpiar Filtros
                            </a>
                        @endif
                        <button type="submit" class="px-5 py-2 bg-guinda-ceaa hover:bg-guinda-ceaa-hover text-white text-xs font-semibold rounded-xl shadow-sm transition">
                            Buscar
                        </button>
                    </div>
                </form>
            </div>

            <!-- Requests Table Card -->
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Referencia / Folio</th>
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Solicitante</th>
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Fecha Registro</th>
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Estado</th>
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Fecha Muestreo</th>
                                <th scope="col" class="px-6 py-4 text-left text-[10px] font-bold text-slate-400 uppercase tracking-widest">Resultados</th>
                                <th scope="col" class="px-6 py-4 class-right text-[10px] font-bold text-slate-400 uppercase tracking-widest">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse($requests as $req)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="whitespace-nowrap px-6 py-4 text-xs font-bold text-guinda-ceaa">
                                        <a href="{{ route('dashboard.solicitud', $req->id) }}" class="hover:underline tracking-wide">{{ $req->referencia_bancaria }}</a>
                                        @if($req->comprobante_pago)
                                            <span class="block text-[9px] text-[#BC955B] font-extrabold uppercase mt-0.5 tracking-wider font-sans">
                                                &bull; Comprobante Cargado
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs">
                                        <div class="font-semibold text-slate-800">{{ $req->solicitante }}</div>
                                        <div class="text-[10px] text-slate-400 flex items-center space-x-1.5 mt-0.5">
                                            <span>{{ $req->representante }}</span>
                                            <span>&bull;</span>
                                            <span class="font-semibold text-guinda-ceaa">{{ $req->cantidad_muestras }} {{ $req->cantidad_muestras === 1 ? 'muestra' : 'muestras' }}</span>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-xs text-slate-500">
                                        {{ $req->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-xs">
                                        @php
                                            $badges = [
                                                'pendiente' => ['bg-slate-100', 'text-slate-700', 'Pendiente Pago'],
                                                'pago_verificado' => ['bg-arena-claro/25', 'text-guinda-ceaa', 'Pago Aprobado'],
                                                'muestreo_programado' => ['bg-arena-claro/20', 'text-guinda-ceaa', 'Muestreo Prog.'],
                                                'en_analisis' => ['bg-arena-claro/20', 'text-purple-850', 'En Análisis'],
                                                'completado' => ['bg-arena-claro/30', 'text-guinda-ceaa', 'Completado'],
                                                'rechazado' => ['bg-red-100', 'text-red-850', 'Rechazado'],
                                            ];
                                            $badge = $badges[$req->status] ?? ['bg-slate-100', 'text-slate-700', $req->status];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $badge[0] }} {{ $badge[1] }}">
                                            {{ $badge[2] }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-xs text-slate-500">
                                        @if($req->fecha_muestreo)
                                            <span class="font-semibold text-slate-700">{{ $req->fecha_muestreo->format('d/m/Y H:i') }}</span>
                                        @else
                                            <span class="text-slate-400 italic">No programada</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-xs">
                                        @if($req->archivo_resultados)
                                            <a href="{{ asset('storage/' . $req->archivo_resultados) }}" target="_blank" class="text-guinda-ceaa hover:text-guinda-ceaa font-bold inline-flex items-center space-x-1">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <span>PDF</span>
                                            </a>
                                        @else
                                            <span class="text-slate-300">-</span>
                                        @endif
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-xs font-semibold">
                                        <a href="{{ route('dashboard.solicitud', $req->id) }}" class="text-guinda-ceaa hover:text-guinda-ceaa transition">Gestionar</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-8 text-center text-xs text-slate-400">
                                        No se encontraron solicitudes registradas en la bandeja.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination links -->
                @if($requests->hasPages())
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                        {{ $requests->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
