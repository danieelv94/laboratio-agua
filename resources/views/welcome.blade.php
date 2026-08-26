<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laboratorio de Calidad del Agua | CEAA</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap">
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

        .nav-link {
            position: relative;
            color: #f1f5f9;
            /* text-slate-100 */
            transition: color 0.3s ease;
        }

        .nav-link:hover {
            color: #BC955B;
            /* dorado-ocre */
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #BC955B;
            /* dorado-ocre */
            transform-origin: bottom right;
            transition: transform 0.25s ease-out;
        }

        .nav-link:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Header / Navbar -->
    <header
        class="bg-guinda-ceaa/95 backdrop-blur-md sticky top-0 z-50 shadow-lg shadow-black/5 border-b border-dorado-ocre/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo"
                        class="h-12 sm:h-14 w-auto object-contain transition-transform duration-300 group-hover:scale-102"
                        style="filter: brightness(0) invert(1);">
                </a>

                <!-- Navigation Links -->
                <nav class="flex items-center space-x-6">
                    <a href="{{ route('solicitud.buscar') }}" class="nav-link text-sm font-semibold tracking-wide">
                        Consultar Folio
                    </a>
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="px-5 py-2.5 bg-gradient-to-r from-dorado-ocre to-amber-600 hover:from-amber-600 hover:to-dorado-ocre text-white text-sm font-bold rounded-xl shadow-md hover:shadow-lg transition duration-200">
                            Panel Personal
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 border border-white/20 hover:border-dorado-ocre bg-white/5 hover:bg-white/10 text-slate-200 hover:text-white text-sm font-semibold rounded-xl transition duration-200 shadow-sm">
                            Acceso Personal
                        </a>
                    @endauth
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section
        x-data="{
            activeSlide: 0,
            slides: [
                '{{ asset('images/banner1.jpeg') }}',
                '{{ asset('images/banner2.jpeg') }}',
                '{{ asset('images/banner3.jpeg') }}',
                '{{ asset('images/banner4.jpeg') }}'
            ],
            init() {
                setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                }, 6000);
            }
        }"
        class="relative min-h-[550px] flex items-center justify-center text-white py-24 px-4 overflow-hidden border-b-4 border-dorado-ocre"
    >
        <!-- Background Banner Carousel -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <template x-for="(slide, index) in slides" :key="index">
                <div
                    x-show="activeSlide === index"
                    x-transition:enter="transition-all ease-in-out duration-1000"
                    x-transition:enter-start="opacity-0 scale-105"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition-all ease-in-out duration-1000"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95"
                    class="absolute inset-0 bg-cover bg-center transition-all duration-1000"
                    :style="'background-image: url(' + slide + ')'"
                ></div>
            </template>
            <!-- Elegant Brand Gradient Overlay (Guinda & Dark Tone) -->
            <div class="absolute inset-0 bg-gradient-to-br from-guinda-ceaa/85 via-[#451020]/90 to-[#541426]/95 mix-blend-multiply"></div>
            <!-- Glassmorphism backdrop layer for depth and text legibility -->
            <div class="absolute inset-0 bg-black/20 backdrop-blur-[1px]"></div>
        </div>

        <!-- Abstract Water shapes background -->
        <div class="absolute bottom-0 left-0 right-0 h-40 sm:h-48 opacity-10 pointer-events-none z-10">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"
                preserveAspectRatio="none">
                <path fill="#ffffff" fill-opacity="1"
                    d="M0,192L48,197.3C96,203,192,213,288,197.3C384,181,480,139,576,144C672,149,768,203,864,229.3C960,256,1056,256,1152,229.3C1248,203,1344,149,1392,122.7L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>

        <div
            class="max-w-5xl mx-auto text-center relative z-20 flex flex-col items-center justify-center space-y-6 md:space-y-8 w-full">
            <span
                class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold bg-dorado-ocre/20 text-white border border-dorado-ocre/30 tracking-widest uppercase backdrop-blur-sm">
                Dirección de Calidad del Agua
            </span>

            <h1
                class="text-4xl sm:text-5xl md:text-6xl font-extrabold tracking-tight leading-tight font-title bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-100 to-dorado-ocre py-2 drop-shadow-md">
                Laboratorio de Análisis de Agua
            </h1>

            <p class="max-w-2xl mx-auto text-base sm:text-lg md:text-xl text-slate-100 font-light leading-relaxed drop-shadow-md">
                Evaluamos y certificamos la calidad de los recursos hídricos mediante rigurosos análisis físicos,
                químicos y bacteriológicos bajo las Normas Oficiales Mexicanas.
            </p>

            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 pt-4 w-full sm:w-auto">
                <a href="{{ route('solicitud.nueva') }}"
                    class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700 text-guinda-ceaa text-base font-bold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 text-center">
                    Solicitar Estudio de Agua
                </a>
                <a href="{{ route('solicitud.buscar') }}"
                    class="w-full sm:w-auto px-8 py-4 bg-white/10 hover:bg-white/15 text-white text-base font-semibold rounded-xl border border-white/20 hover:border-white/30 transition transform hover:-translate-y-0.5 text-center backdrop-blur-sm">
                    Consultar Folio
                </a>
            </div>

            <!-- Slide Indicators -->
            <div class="flex items-center justify-center space-x-3 pt-6 z-20">
                <template x-for="(slide, index) in slides" :key="index">
                    <button
                        @click="activeSlide = index"
                        class="w-3 h-3 rounded-full transition-all duration-300 focus:outline-none"
                        :class="activeSlide === index ? 'bg-dorado-ocre w-8 shadow-lg shadow-dorado-ocre/50' : 'bg-white/45 hover:bg-white/70'"
                        :aria-label="'Ir al banner ' + (index + 1)"
                    ></button>
                </template>
            </div>
        </div>
    </section>

    <!-- Services Overview -->
    <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <!-- Main Service Description Card -->
        <div class="text-center max-w-3xl mx-auto mb-16 space-y-4">
            <h2 class="text-3xl font-bold font-title text-guinda-ceaa">Nuestros Ensayos y Servicios</h2>
            <p class="text-slate-600 text-base">
                El Laboratorio de la CEAA ofrece una gama de ensayos integrales diseñados para garantizar la inocuidad y
                cumplimiento normativo del agua en municipios, dependencias gubernamentales e industrias.
            </p>
        </div>

        <!-- Service Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <!-- Fisico -->
            <div
                class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition duration-300 border border-slate-200/60 flex flex-col justify-between">
                <div>
                    <div
                        class="w-12 h-12 bg-arena-claro/25 rounded-xl flex items-center justify-center text-guinda-ceaa mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold font-title text-guinda-ceaa mb-3">Análisis Físico</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Evaluación de las características perceptibles del agua y sus condiciones básicas del entorno.
                    </p>
                    <ul class="text-xs text-slate-500 space-y-2 mb-6">
                        <li class="flex items-center"><span
                                class="w-1.5 h-1.5 bg-dorado-ocre rounded-full mr-2"></span>Turbidez y Color</li>
                        <li class="flex items-center"><span
                                class="w-1.5 h-1.5 bg-dorado-ocre rounded-full mr-2"></span>Sólidos disueltos totales
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Quimico -->
            <div
                class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition duration-300 border border-slate-200/60 flex flex-col justify-between">
                <div>
                    <div
                        class="w-12 h-12 bg-arena-claro/30 rounded-xl flex items-center justify-center text-guinda-ceaa mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold font-title text-guinda-ceaa mb-3">Análisis Químico</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Determinación de componentes orgánicos e inorgánicos disueltos, metales pesados y contaminantes
                        químicos.
                    </p>
                    <ul class="text-xs text-slate-500 space-y-2 mb-6">
                        <li class="flex items-center"><span
                                class="w-1.5 h-1.5 bg-dorado-ocre rounded-full mr-2"></span>Potencial de Hidrógeno (pH)
                        </li>
                        <li class="flex items-center"><span
                                class="w-1.5 h-1.5 bg-dorado-ocre rounded-full mr-2"></span>Metales Pesados y Dureza
                        </li>
                        <li class="flex items-center"><span
                                class="w-1.5 h-1.5 bg-dorado-ocre rounded-full mr-2"></span>Cloruros, Sulfatos y
                            Nitritos</li>
                    </ul>
                </div>
            </div>

            <!-- Bacteriologico -->
            <div
                class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-md transition duration-300 border border-slate-200/60 flex flex-col justify-between">
                <div>
                    <div
                        class="w-12 h-12 bg-arena-claro/20 rounded-xl flex items-center justify-center text-guinda-ceaa mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold font-title text-guinda-ceaa mb-3">Análisis Bacteriológico</h3>
                    <p class="text-slate-600 text-sm leading-relaxed mb-4">
                        Detección y cuantificación de patógenos y microorganismos indicadores de contaminación fecal.
                    </p>
                    <ul class="text-xs text-slate-500 space-y-2 mb-6">
                        <li class="flex items-center"><span
                                class="w-1.5 h-1.5 bg-dorado-ocre rounded-full mr-2"></span>Coliformes Totales y E. coli
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Compliance & Regulatory Banner -->
        <div
            class="bg-guinda-ceaa text-white rounded-3xl p-8 md:p-12 shadow-md flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="space-y-4 max-w-xl">
                <h3 class="text-2xl font-bold font-title">Garantía Normativa Oficial</h3>
                <p class="text-slate-200 text-sm leading-relaxed">
                    Nuestros análisis respaldan el cumplimiento de las normativas oficiales vigentes en México para agua
                    de descarga, reuso y consumo humano:
                </p>
                <div class="grid grid-cols-2 gap-2 text-xs text-slate-300 font-medium">
                    <div class="flex items-center"><span
                            class="w-1.5 h-1.5 bg-dorado-ocre rounded-full mr-2"></span>NOM-001-SEMARNAT-2021</div>
                    <div class="flex items-center"><span
                            class="w-1.5 h-1.5 bg-dorado-ocre rounded-full mr-2"></span>NOM-002-ECOL-1996</div>
                    <div class="flex items-center"><span
                            class="w-1.5 h-1.5 bg-dorado-ocre rounded-full mr-2"></span>NOM-003-ECOL-1997</div>
                    <div class="flex items-center"><span
                            class="w-1.5 h-1.5 bg-dorado-ocre rounded-full mr-2"></span>NOM-127-SSA1-2021</div>
                </div>
            </div>
            <div class="w-full md:w-auto flex-shrink-0">
                <div class="bg-white/10 p-6 rounded-2xl border border-white/20 text-center space-y-2">
                    <div class="text-3xl font-extrabold font-title text-dorado-ocre">$7,698.02 <span
                            class="text-xs text-white">MXN</span></div>
                    <div class="text-xs text-slate-200 font-medium uppercase tracking-wider">Cuota de recuperación fija
                    </div>
                    <div class="text-[10px] text-slate-300">(Incluye toma de muestra y reporte oficial)</div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 px-4 border-t border-slate-800">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="space-y-3">
                <span class="text-white font-bold font-title text-lg tracking-wider">CEAA HIDALGO</span>
                <p class="text-xs leading-relaxed text-slate-500">
                    Comisión Estatal del Agua y Alcantarillado.<br>
                    Gobierno del Estado de Hidalgo.
                </p>
            </div>
            <div class="space-y-2 text-xs">
                <h4 class="text-white font-semibold font-title uppercase tracking-wider mb-2">Contacto del Laboratorio
                </h4>
                <p>Dirección de Calidad del Agua</p>
                <p class="text-slate-300">Correo: <a href="mailto:ceaa.calidaddelagua@hidalgo.gob.mx"
                        class="hover:text-dorado-ocre transition underline">ceaa.calidaddelagua@hidalgo.gob.mx</a></p>
                <p>Dirección: <a href="https://maps.app.goo.gl/2xpq9Nm455BS2mz46"
                        class="hover:text-dorado-ocre transition underline">Camino Real de La Plata 336, Zona Plateada,
                        42084
                        Pachuca de Soto, Hgo.</a></p>
            </div>
            <div class="space-y-2 text-xs">
                <h4 class="text-white font-semibold font-title uppercase tracking-wider mb-2">Servicios en Línea</h4>
                <nav class="flex flex-col space-y-1.5">
                    <a href="{{ route('solicitud.nueva') }}" class="hover:text-white transition">Nueva Solicitud de
                        Análisis</a>
                    <a href="{{ route('solicitud.buscar') }}" class="hover:text-white transition">Consultar Folio /
                        Pago</a>
                </nav>
            </div>
        </div>
        <div class="max-w-7xl mx-auto mt-8 pt-8 border-t border-slate-800 text-center text-[10px] text-slate-600">
            &copy; {{ date('Y') }} Comisión Estatal del Agua y Alcantarillado - CEAA. Todos los derechos reservados.
        </div>
    </footer>

</body>

</html>