<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-guinda-ceaa leading-tight font-title">
                Crear Nuevo Usuario
            </h2>
            <a href="{{ route('dashboard.usuarios') }}" class="text-xs text-slate-500 hover:text-slate-700 flex items-center space-x-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                <span>Volver al listado</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm mb-6">
                    <h3 class="text-xs font-bold text-red-800 uppercase tracking-wider">Errores al guardar:</h3>
                    <ul class="mt-1 list-disc list-inside text-xs text-red-700 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200">
                <form action="{{ route('dashboard.usuarios.guardar') }}" method="POST" class="space-y-6 text-xs">
                    @csrf

                    <div>
                        <label for="name" class="block font-bold text-slate-500 uppercase tracking-wider text-[10px] mb-1">Nombre Completo <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa py-2 text-xs">
                    </div>

                    <div>
                        <label for="email" class="block font-bold text-slate-500 uppercase tracking-wider text-[10px] mb-1">Correo Electrónico <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}" required class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa py-2 text-xs">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block font-bold text-slate-500 uppercase tracking-wider text-[10px] mb-1">Contraseña <span class="text-red-500">*</span></label>
                            <input type="password" name="password" id="password" required class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa py-2 text-xs">
                        </div>

                        <div>
                            <label for="password_confirmation" class="block font-bold text-slate-500 uppercase tracking-wider text-[10px] mb-1">Confirmar Contraseña <span class="text-red-500">*</span></label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa py-2 text-xs">
                        </div>
                    </div>

                    <div>
                        <label for="role" class="block font-bold text-slate-500 uppercase tracking-wider text-[10px] mb-1">Rol de Acceso <span class="text-red-500">*</span></label>
                        <select name="role" id="role" required class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa py-2 text-xs">
                            <option value="" disabled {{ old('role') ? '' : 'selected' }}>Selecciona un rol...</option>
                            <option value="laboratorio" {{ old('role') === 'laboratorio' ? 'selected' : '' }}>Laboratorio (Técnico / Programador)</option>
                            <option value="administracion" {{ old('role') === 'administracion' ? 'selected' : '' }}>Facturación (Gestión Fiscal)</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrador (Gestor total)</option>
                        </select>
                    </div>

                    <div class="pt-4 border-t border-slate-100 flex items-center justify-end space-x-3">
                        <a href="{{ route('dashboard.usuarios') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold uppercase rounded-xl transition">
                            Cancelar
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-guinda-ceaa hover:bg-guinda-ceaa-hover text-white text-xs font-bold uppercase rounded-xl shadow-sm transition">
                            Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
