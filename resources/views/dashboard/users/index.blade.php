<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-guinda-ceaa leading-tight font-title">
                Gestión de Usuarios
            </h2>
            <a href="{{ route('dashboard.usuarios.crear') }}" class="px-4 py-2 bg-guinda-ceaa hover:bg-guinda-ceaa-hover text-white text-xs font-bold uppercase tracking-wider rounded-xl shadow-sm transition">
                + Crear Usuario
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

            @if($errors->has('suspension'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm text-sm text-red-700 font-semibold">
                    {{ $errors->first('suspension') }}
                </div>
            @endif

            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500">Usuarios Registrados</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[10px] font-bold uppercase tracking-wider text-slate-400 bg-slate-50/20">
                                <th class="py-4 px-6">Nombre</th>
                                <th class="py-4 px-6">Correo Electrónico</th>
                                <th class="py-4 px-6">Rol</th>
                                <th class="py-4 px-6 text-center">Estado</th>
                                <th class="py-4 px-6 text-right">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-xs">
                            @foreach($users as $user)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-4 px-6 font-semibold text-slate-800">{{ $user->name }}</td>
                                    <td class="py-4 px-6 text-slate-600 font-mono">{{ $user->email }}</td>
                                    <td class="py-4 px-6">
                                        @if($user->role === 'admin')
                                            <span class="bg-guinda-ceaa/10 text-guinda-ceaa px-2.5 py-1 rounded-md font-semibold text-[10px] uppercase">Administrador</span>
                                        @elseif($user->role === 'laboratorio')
                                            <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-md font-semibold text-[10px] uppercase">Laboratorio</span>
                                        @elseif($user->role === 'administracion')
                                            <span class="bg-[#BC955B]/10 text-guinda-ceaa px-2.5 py-1 rounded-md font-semibold text-[10px] uppercase">Facturación</span>
                                        @else
                                            <span class="bg-slate-100 text-slate-700 px-2.5 py-1 rounded-md font-semibold text-[10px] uppercase">{{ $user->role }}</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        @if($user->suspended)
                                            <span class="bg-red-50 text-red-700 px-2.5 py-1 rounded-full font-bold text-[9px] uppercase tracking-wider">Suspendido</span>
                                        @else
                                            <span class="bg-emerald-50 text-emerald-700 px-2.5 py-1 rounded-full font-bold text-[9px] uppercase tracking-wider">Activo</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-right space-x-2">
                                        <a href="{{ route('dashboard.usuarios.editar', $user->id) }}" class="text-xs font-bold text-slate-500 hover:text-guinda-ceaa hover:underline">
                                            Editar
                                        </a>

                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('dashboard.usuarios.suspender', $user->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" class="text-xs font-bold {{ $user->suspended ? 'text-emerald-600 hover:text-emerald-700' : 'text-red-600 hover:text-red-700' }} hover:underline cursor-pointer bg-transparent border-0 p-0">
                                                    {{ $user->suspended ? 'Reactivar' : 'Suspender' }}
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs font-bold text-slate-300 cursor-not-allowed" title="No puedes suspender tu propia cuenta">
                                                Suspender
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($users->hasPages())
                    <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
