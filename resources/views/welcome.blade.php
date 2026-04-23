<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="CMR Clínica Odontológica - Tu sonrisa, nuestra prioridad. Atención dental especializada con tecnología de vanguardia.">

    <title>{{ config('app.name', 'CMR Clínica Odontológica') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .text-gradient {
            background: linear-gradient(135deg, #0d9488 0%, #06b6d4 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="bg-white text-gray-900">

    <!-- Navegación Principal -->
    <header class="fixed top-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">

                <!-- Logo -->
                <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl blur opacity-25 group-hover:opacity-50 transition-opacity duration-300">
                        </div>
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Clínica"
                            class="h-14 w-auto rounded-xl relative">
                    </div>
                    <div
                        class="border-l-2 border-gray-200 pl-3 group-hover:border-teal-500 transition-colors duration-300">
                        <h1 class="text-2xl font-extrabold text-gray-900 leading-tight tracking-tight">
                            <span
                                class="bg-gradient-to-r from-teal-600 to-cyan-600 bg-clip-text text-transparent">CMR</span>
                        </h1>
                        <p class="text-xs text-gray-500 font-medium tracking-wide uppercase">Clínica Odontológica</p>
                    </div>
                </a>

                <!-- Botones de Autenticación -->
                <nav class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="hidden sm:inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="px-6 py-3 text-gray-600 hover:text-teal-600 font-semibold transition-all duration-200 rounded-xl hover:bg-teal-50 hover:shadow-md">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                    </svg>
                                    Iniciar Sesión
                                </span>
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white text-sm font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
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
    <main class="pt-20">

        <!-- Hero Section -->
        <section
            class="relative min-h-screen flex items-center bg-gradient-to-br from-slate-50 via-teal-50/20 to-cyan-50/20 overflow-hidden">

            <!-- Elementos decorativos -->
            <div
                class="absolute top-20 right-0 w-96 h-96 bg-teal-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse">
            </div>
            <div class="absolute bottom-20 left-0 w-96 h-96 bg-cyan-200 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-pulse"
                style="animation-delay: 1s;"></div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
                <div class="grid lg:grid-cols-2 gap-16 items-center">

                    <!-- Texto -->
                    <div class="space-y-8">
                        <div
                            class="inline-flex items-center px-4 py-2 bg-teal-100 text-teal-800 rounded-full text-sm font-semibold">
                            <span class="w-2 h-2 bg-teal-600 rounded-full mr-2 animate-pulse"></span>
                            Atención Odontológica de Excelencia
                        </div>

                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold leading-tight">
                            Tu sonrisa,<br>
                            <span class="text-gradient">nuestra prioridad</span>
                        </h1>

                        <p class="text-lg text-gray-600 max-w-xl leading-relaxed">
                            CMR Clínica Odontológica combina tecnología de vanguardia con un equipo
                            de especialistas dedicados a brindarte la mejor experiencia dental.
                            Transformamos tu salud bucal con resultados excepcionales.
                        </p>

                        <!-- Botones CTA -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('login') }}"
                                class="relative z-10 inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-700 hover:to-cyan-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Agendar Cita Gratuita
                            </a>

                            <a href="#servicios"
                                class="inline-flex items-center justify-center px-8 py-4 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-200 shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Nuestros Servicios
                            </a>
                        </div>

                        <!-- Estadísticas -->
                        <div class="flex items-center gap-8 pt-4">
                            <div>
                                <div class="text-3xl font-bold text-teal-600">+1000</div>
                                <div class="text-sm text-gray-500">Pacientes Satisfechos</div>
                            </div>
                            <div class="h-12 w-px bg-gray-200"></div>
                            <div>
                                <div class="text-3xl font-bold text-teal-600">15+</div>
                                <div class="text-sm text-gray-500">Años de Experiencia</div>
                            </div>
                            <div class="h-12 w-px bg-gray-200"></div>
                            <div>
                                <div class="text-3xl font-bold text-teal-600">4.3★</div>
                                <div class="text-sm text-gray-500">Calificación Google</div>
                            </div>
                        </div>
                    </div>

                    <!-- Ilustración/Imagen -->
                    <div class="relative flex items-center justify-center">
                        <div class="relative w-full max-w-lg">
                            <!-- Card principal -->
                            <div class="bg-gradient-to-br from-teal-100 to-cyan-100 rounded-3xl p-10 shadow-2xl">
                                <div
                                    class="aspect-square bg-white rounded-2xl shadow-inner flex items-center justify-center overflow-hidden">
                                    <!-- Placeholder para imagen -->
                                    <div class="text-center p-12">
                                        <div class="absolute inset-0">
                                            <img src="{{ asset('images/cuerpopagina.png') }}" alt="Clínica Dental"
                                                class="w-full h-full object-cover">
                                        </div>
                                        <p class="text-gray-500 font-medium">Imagen de clínica dental moderna</p>
                                    </div>
                                </div>

                                <!-- Badge flotante -->
                                <div
                                    class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-5 min-w-[200px]">
                                    <div class="flex items-center gap-3">
                                        <div class="relative">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <div
                                                class="absolute -top-1 -right-1 w-4 h-4 bg-green-500 border-2 border-white rounded-full">
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-bold text-gray-900 text-sm">Cita Confirmada</div>
                                            <div class="text-xs text-gray-500 font-medium">Respuesta en menos de 24h
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Servicios -->
        <section id="servicios" class="py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20">
                    <h2 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4">
                        Nuestros Servicios
                    </h2>
                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Ofrecemos un enfoque integral para el cuidado de tu sonrisa con tratamientos de vanguardia.
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div
                        class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-teal-500 to-teal-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Odontología General</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Limpiezas, revisiones, tratamientos preventivos y cuidado dental integral para toda la
                            familia.
                        </p>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Estética Dental</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Blanqueamiento profesional, carillas y diseño de sonrisa para lograr la apariencia que
                            siempre soñaste.
                        </p>
                    </div>

                    <!-- Card 3 -->
                    <div
                        class="bg-white p-8 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Ortodoncia</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Alineación dental invisible y brackets tradicionales para una sonrisa perfectamente
                            alineada.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Final -->
        <section class="py-24 bg-gradient-to-r from-teal-600 to-cyan-600 relative overflow-hidden">
            <div class="absolute inset-0 opacity-10">
                <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -ml-32 -mt-32"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-white rounded-full -mr-32 -mb-32"></div>
            </div>

            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">
                    ¿Listo para transformar tu sonrisa?
                </h2>
                <p class="text-lg text-teal-100 mb-10 max-w-2xl mx-auto">
                    Agenda tu primera consulta gratuita y descubre por qué miles de pacientes confían en CMR para el
                    cuidado de su salud dental.
                </p>

                @if (Route::has('login'))
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center px-10 py-5 bg-white hover:bg-gray-100 text-teal-600 font-bold rounded-xl transition-all duration-200 shadow-2xl hover:shadow-2xl transform hover:-translate-y-1">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Agendar Mi Primera Cita
                    </a>
                @endif
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-400 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid md:grid-cols-3 gap-12 mb-12">
                    <!-- Columna 1: Logo y descripción -->
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="relative">
                                <div
                                    class="absolute -inset-1 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl blur opacity-40">
                                </div>
                                <div class="relative">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-xl blur opacity-25 group-hover:opacity-50 transition-opacity duration-300">
                        </div>
                        <img src="{{ asset('images/logo.png') }}" alt="Logo Clínica"
                            class="h-14 w-auto rounded-xl relative">
                    </div>
                            </div>
                            <div class="border-l-2 border-gray-700 pl-3">
                                <span class="text-xl font-bold text-white">CMR</span>
                                <p class="text-xs text-teal-400">Clínica Odontológica</p>
                            </div>
                        </div>
                        <p class="text-sm leading-relaxed">
                            Clínica Odontológica especializada en el cuidado integral de tu sonrisa.
                            Tecnología de vanguardia, calidez humana y resultados excepcionales.
                        </p>
                    </div>

                    <!-- Columna 2: Contacto -->
                    <div>
                        <h4 class="text-white font-semibold mb-4">Contacto</h4>
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-0.5 text-teal-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Consultorio 201, Av 11E 5AN-32. Edificio Quito, Br. Santa Lucia, Cúcuta, Norte de
                                    Santander</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-0.5 text-teal-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span>+57 3154179288</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 mr-3 mt-0.5 text-teal-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <span>contacto@cmr-dental.com</span>
                            </li>
                        </ul>
                    </div>

                    <!-- Columna 3: Horario -->
                    <div>
                        <h4 class="text-white font-semibold mb-4">Horario de Atención</h4>
                        <ul class="space-y-2 text-sm">
                            <li class="flex justify-between">
                                <span>Lunes - Viernes</span>


                            </li>
                            <li><span class="text-teal-400">8:00 AM - 12:00 PM</span></li>
                            <li><span class="text-teal-400">2:00 PM - 6:00 PM</span>
                            </li>
                            <li class="flex justify-between">
                                <span>Sábado</span>
                            <li><span class="text-teal-400">8:00 AM - 12:00 PM</span></li>
                            </li>
                            <li class="flex justify-between">
                                <span>Domingo</span>
                                <span class="text-red-400">Cerrado</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Copyright -->
                <div class="border-t border-gray-800 pt-8 text-center text-sm">
                    <p>&copy; {{ date('Y') }} CMR Clínica Odontológica. Todos los derechos reservados.</p>
                </div>
            </div>
        </footer>

    </main>

</body>

</html>