<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Consultar Folio | CEAA</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
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
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="bg-guinda-ceaa text-white py-4 shadow-md border-b border-yellow-600/30 w-full">
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
    <main class="flex-grow flex items-center justify-center px-4 py-16">
        <div class="max-w-md w-full bg-white rounded-3xl shadow-sm border border-slate-200 p-8 space-y-6">

            <div class="text-center space-y-2">
                <div
                    class="w-12 h-12 bg-arena-claro/15 rounded-full flex items-center justify-center text-guinda-ceaa mx-auto border border-dorado-ocre/25">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold font-title text-guinda-ceaa">Consulta de Trámite</h1>
                <p class="text-xs text-slate-500">Ingrese su folio o referencia bancaria asignada al registrar su
                    solicitud.</p>
            </div>

            @if ($errors->any())
                <div
                    class="bg-red-50 border-l-4 border-red-500 p-3.5 rounded-xl text-xs text-red-700 font-semibold shadow-inner">
                    {{ $errors->first('referencia_bancaria') }}
                </div>
            @endif

            <form action="{{ route('solicitud.buscar.procesar') }}" method="POST" class="space-y-4">
                @csrf

                <div class="space-y-1.5">
                    <label for="referencia_bancaria"
                        class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest">Folio o Referencia
                        Bancaria</label>
                    <input type="text" name="referencia_bancaria" id="referencia_bancaria"
                        value="{{ old('referencia_bancaria') }}" placeholder="Ej. CEAA-2026-ABCDE"
                        class="w-full rounded-xl border-slate-300 shadow-sm focus:border-guinda-ceaa focus:ring-guinda-ceaa text-sm py-3 px-4 font-semibold tracking-wider text-center placeholder:font-normal placeholder:tracking-normal"
                        required>
                </div>

                <button type="submit"
                    class="w-full py-3 bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700 text-guinda-ceaa text-sm font-bold rounded-xl shadow-md hover:shadow-lg transition">
                    Buscar Solicitud
                </button>
            </form>

            <div class="text-[10px] text-slate-400 text-center leading-relaxed border-t border-slate-100 pt-4">
                ¿Olvidó su folio o tiene problemas con el sistema? <br>
                Comuníquese al correo <a href="mailto:ceaa.calidaddelagua@hidalgo.gob.mx"
                    class="text-guinda-ceaa font-semibold hover:underline">ceaa.calidaddelagua@hidalgo.gob.mx</a>.
            </div>

        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-500 py-6 px-4 text-center text-xs border-t border-slate-800 w-full">
        &copy; {{ date('Y') }} Comisión Estatal del Agua y Alcantarillado - CEAA. Hidalgo.
    </footer>

</body>

</html>