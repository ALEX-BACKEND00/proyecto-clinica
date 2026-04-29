<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="CMR Clínica Odontológica - Tu sonrisa, nuestra prioridad. Atención dental especializada con tecnología de vanguardia.">

    <title>{{ config('app.name', 'CMR Clínica Odontológica') }}</title>

    <!-- Google Fonts - Solo los pesos necesarios -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Estilos críticos inline para evitar render blocking */
        body {
            font-family: 'Inter', sans-serif;
        }

        .text-gradient {
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Solo animaciones esenciales */
        @keyframes pulse {
            0%, 100% { opacity: 0.2; }
            50% { opacity: 0.3; }
        }
        
        .animate-pulse-slow {
            animation: pulse 4s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-white text-gray-900">

    <!-- Navegación Principal - Simplificada -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20">

                <!-- Logo - Simplificado sin efectos pesados -->
                <a href="{{ url('/') }}" class="flex items-center gap-2 sm:gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo Clínica" class="h-10 sm:h-12 w-auto">
                    <div class="border-l-2 border-gray-200 pl-2 sm:pl-3">
                        <h1 class="text-xl sm:text-2xl font-extrabold text-gray-900">
                            <span class="text-teal-600">CMR</span>
                        </h1>
                        <p class="text-[10px] sm:text-xs text-gray-500 font-medium">Clínica Odontológica</p>
                    </div>
                </a>

                <!-- Botones de Autenticación - Simplificados -->
                <nav class="flex items-center gap-2 sm:gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="px-4 sm:px-6 py-2 sm:py-3 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-4 sm:px-5 py-2 text-gray-600 hover:text-teal-600 font-semibold text-sm transition-colors">
                                Iniciar Sesión
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="px-4 sm:px-6 py-2 sm:py-3 bg-teal-600 hover:bg-teal-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <!-- Contenido Principal -->
    <main>

        <!-- Hero Section - Simplificada -->
        <section class="relative min-h-screen flex items-center bg-gradient-to-br from-slate-50 via-teal-50/10 to-cyan-50/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 md:py-32">
                <div class="grid lg:grid-cols-2 gap-8 md:gap-12 items-center">

                    <!-- Texto -->
                    <div class="space-y-6">
                        <div class="inline-flex items-center px-3 py-1.5 bg-teal-100 text-teal-700 rounded-full text-xs sm:text-sm font-semibold">
                            <span class="w-1.5 h-1.5 bg-teal-600 rounded-full mr-2"></span>
                            Atención Odontológica de Excelencia
                        </div>

                        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold leading-tight">
                            Tu sonrisa,<br>
                            <span class="text-gradient">nuestra prioridad</span>
                        </h1>

                        <p class="text-base sm:text-lg text-gray-600 max-w-xl leading-relaxed">
                            CMR Clínica Odontológica combina tecnología de vanguardia con un equipo
                            de especialistas dedicados a brindarte la mejor experiencia dental.
                        </p>

                        <!-- Botones CTA - Simplificados -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('login') }}"
                                class="inline-flex items-center justify-center px-6 py-3 bg-teal-600 hover:bg-teal-700 text-white font-semibold rounded-lg transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Agendar Cita Gratuita
                            </a>

                            <a href="#servicios"
                                class="inline-flex items-center justify-center px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-lg border border-gray-200 transition-colors">
                                Nuestros Servicios
                            </a>
                        </div>

                        <!-- Estadísticas - Simplificadas -->
                        <div class="flex items-center gap-6 pt-4">
                            <div>
                                <div class="text-2xl font-bold text-teal-600">+1000</div>
                                <div class="text-xs text-gray-500">Pacientes Satisfechos</div>
                            </div>
                            <div class="h-8 w-px bg-gray-200"></div>
                            <div>
                                <div class="text-2xl font-bold text-teal-600">15+</div>
                                <div class="text-xs text-gray-500">Años de Experiencia</div>
                            </div>
                            <div class="h-8 w-px bg-gray-200"></div>
                            <div>
                                <div class="text-2xl font-bold text-teal-600">4.3★</div>
                                <div class="text-xs text-gray-500">Calificación</div>
                            </div>
                        </div>
                    </div>

                    <!-- Imagen - Simplificada sin elementos flotantes pesados -->
                    <div class="relative mt-8 lg:mt-0">
                        <div class="bg-gradient-to-br from-teal-100 to-cyan-100 rounded-2xl p-6 shadow-xl">
                            <div class="aspect-square bg-white rounded-xl overflow-hidden">
                                <img src="{{ asset('images/cuerpopagina.png') }}" alt="Clínica Dental"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Servicios - Optimizados -->
        <section id="servicios" class="py-16 md:py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                        Nuestros Servicios
                    </h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Ofrecemos un enfoque integral para el cuidado de tu sonrisa.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                        <div class="w-12 h-12 bg-teal-600 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Odontología General</h3>
                        <p class="text-gray-600 text-sm">
                            Limpiezas, revisiones, tratamientos preventivos y cuidado dental integral.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                        <div class="w-12 h-12 bg-cyan-600 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Estética Dental</h3>
                        <p class="text-gray-600 text-sm">
                            Blanqueamiento profesional, carillas y diseño de sonrisa personalizado.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100">
                        <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Ortodoncia</h3>
                        <p class="text-gray-600 text-sm">
                            Alineación dental invisible y brackets tradicionales.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Final - Simplificado -->
        <section class="py-16 md:py-20 bg-teal-600">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white mb-4">
                    ¿Listo para transformar tu sonrisa?
                </h2>
                <p class="text-teal-100 mb-8 max-w-2xl mx-auto">
                    Agenda tu primera consulta gratuita y descubre por qué miles de pacientes confían en CMR.
                </p>

                @if (Route::has('login'))
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-8 py-3 bg-white hover:bg-gray-100 text-teal-600 font-bold rounded-lg transition-colors shadow-lg">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Agendar Mi Primera Cita
                    </a>
                @endif
            </div>
        </section>

        <!-- Footer - Simplificado -->
        <footer class="bg-gray-900 text-gray-400 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-8 mb-8">
                    <!-- Columna 1 -->
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Clínica" class="h-10 w-auto">
                            <div class="border-l border-gray-700 pl-3">
                                <span class="text-lg font-bold text-white">CMR</span>
                                <p class="text-[10px] text-teal-400">Clínica Odontológica</p>
                            </div>
                        </div>
                        <p class="text-sm leading-relaxed">
                            Clínica Odontológica especializada en el cuidado integral de tu sonrisa.
                        </p>
                    </div>

                    <!-- Columna 2 -->
                    <div>
                        <h4 class="text-white font-semibold mb-4">Contacto</h4>
                        <ul class="space-y-2 text-sm">
                            <li class="flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 text-teal-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-xs">Consultorio 201, Av 11E 5AN-32. Edificio Quito, Br. Santa Lucia, Cúcuta</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="text-xs">+57 3154179288</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span class="text-xs">contacto@cmr-dental.com</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Columna 3 -->
                    <div>
                        <h4 class="text-white font-semibold mb-4">Horario de Atención</h4>
                        <ul class="space-y-1 text-sm">
                            <li class="flex justify-between">
                                <span>Lunes - Viernes</span>
                            </li>
                            <li><span class="text-teal-400 text-xs">8:00 AM - 12:00 PM</span></li>
                            <li><span class="text-teal-400 text-xs">2:00 PM - 6:00 PM</span></li>
                            <li class="mt-2 flex justify-between">
                                <span>Sábado</span>
                            </li>
                            <li><span class="text-teal-400 text-xs">8:00 AM - 12:00 PM</span></li>
                            <li class="mt-2 flex justify-between">
                                <span>Domingo</span>
                                <span class="text-red-400 text-xs">Cerrado</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 pt-6 text-center text-xs">
                    <p>&copy; {{ date('Y') }} CMR Clínica Odontológica. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>
    </main>
</body>

</html>