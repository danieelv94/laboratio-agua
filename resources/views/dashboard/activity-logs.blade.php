<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-guinda-ceaa leading-tight font-title">
            Bitácora de Actividades (Auditoría)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Historial de Acciones en la Plataforma</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[10px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50/20">
                                <th class="py-4 px-6">Fecha y Hora</th>
                                <th class="py-4 px-6">Usuario</th>
                                <th class="py-4 px-6">Acción</th>
                                <th class="py-4 px-6">Detalle / Descripción</th>
                                <th class="py-4 px-6 text-center">IP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @forelse($logs as $log)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 text-slate-500 whitespace-nowrap">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($log->user)
                                            <span class="font-semibold text-slate-800 block">{{ $log->user->name }}</span>
                                            <span class="text-[10px] text-slate-400 block">{{ $log->user->email }}</span>
                                        @else
                                            <span class="text-slate-400 italic">Sistema / Público</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $actionStyles = match($log->action) {
                                                'login' => 'bg-emerald-50 text-emerald-700',
                                                'logout' => 'bg-slate-100 text-slate-700',
                                                'user_created' => 'bg-blue-50 text-blue-700',
                                                'user_updated' => 'bg-amber-50 text-amber-700',
                                                'user_suspended' => 'bg-red-50 text-red-700',
                                                'user_reactivated' => 'bg-teal-50 text-teal-700',
                                                'study_request_updated' => 'bg-purple-50 text-purple-700',
                                                'invoice_uploaded' => 'bg-pink-50 text-pink-700',
                                                default => 'bg-slate-50 text-slate-600'
                                            };
                                        @endphp
                                        <span class="{{ $actionStyles }} px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider">
                                            {{ str_replace('_', ' ', $log->action) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-slate-600 max-w-xs leading-normal">
                                        {{ $log->description }}
                                    </td>
                                    <td class="py-4 px-6 text-center text-slate-400 font-mono text-[10px]">
                                        {{ $log->ip_address ?: 'N/A' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400 italic">
                                        No se han registrado actividades en la bitácora aún.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($logs->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $logs->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
