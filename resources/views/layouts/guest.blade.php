<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'CMR Clínica Odontológica') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }
        </style>
    </head>
    <body class="antialiased text-slate-800 bg-slate-50">
        
        <div class="flex min-h-screen">
            
            <!-- Panel Izquierdo: Branding (Oculto en móviles) -->
            <div class="relative hidden w-1/2 lg:flex items-center justify-center bg-teal-900 overflow-hidden">
                <!-- Fondo con gradiente oscuro corporativo -->
                <div class="absolute inset-0 bg-gradient-to-br from-teal-900 via-teal-800 to-slate-900"></div>
                
                <!-- Formas geométricas sutiles para elegancia -->
                <div class="absolute -top-32 -left-32 w-96 h-96 rounded-full bg-teal-700/20 blur-3xl"></div>
                <div class="absolute bottom-0 right-0 w-80 h-80 rounded-full bg-cyan-900/40 blur-3xl"></div>

                <!-- Contenido de Branding -->
                <div class="relative z-10 px-12 max-w-lg">
                    <a href="/" class="inline-flex items-center justify-center p-3 mb-12 bg-white/95 rounded-2xl shadow-lg backdrop-blur-sm transition-transform hover:scale-105">
    <img src="{{ asset('images/logo.png') }}" alt="Logo CMR" class="h-12 sm:h-14 w-auto">
    <!-- Si quieres mantener el texto "CMR" junto al logo, puedes añadirlo aquí -->
    <div class="border-l-2 border-slate-200 pl-3 ml-3">
        <h1 class="text-2xl font-extrabold tracking-tight text-slate-800">
            <span class="text-teal-600">CMR</span>
        </h1>
    </div>
</a>
                    
                    <h2 class="text-4xl font-bold text-white mb-6 leading-tight">
                        El arte de una <br><span class="text-cyan-400">sonrisa perfecta.</span>
                    </h2>
                    <p class="text-teal-100/80 text-lg leading-relaxed mb-8">
                        Únete a nuestra plataforma digital. Gestiona tus citas, accede a tu historial clínico y recibe atención personalizada con los mejores especialistas de la ciudad.
                    </p>

                    <!-- Elemento de confianza (Opcional) -->
                    <div class="flex items-center gap-4 border-t border-teal-700/50 pt-8">
                        <div class="flex -space-x-3">
                            <div class="w-10 h-10 rounded-full bg-slate-300 border-2 border-teal-800 flex items-center justify-center text-xs font-bold">👤</div>
                            <div class="w-10 h-10 rounded-full bg-slate-400 border-2 border-teal-800 flex items-center justify-center text-xs font-bold">👤</div>
                            <div class="w-10 h-10 rounded-full bg-slate-200 border-2 border-teal-800 flex items-center justify-center text-xs font-bold">👤</div>
                        </div>
                        <span class="text-sm font-medium text-teal-200">Miles de pacientes confían en nosotros</span>
                    </div>
                </div>
            </div>

            <!-- Panel Derecho: Área del Formulario -->
            <div class="flex flex-col justify-center w-full lg:w-1/2 px-6 py-12 sm:px-12 bg-slate-50">
                <div class="w-full max-w-md mx-auto">
                    
                    <!-- Logo para versión móvil (Solo visible en pantallas pequeñas) -->
                    <div class="lg:hidden mb-10 flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo CMR" class="h-12 w-auto">
                        <div class="border-l-2 border-slate-300 pl-3">
                            <h1 class="text-2xl font-extrabold text-slate-800">
                                <span class="text-teal-600">CMR</span>
                            </h1>
                        </div>
                    </div>

                    <!-- Aquí se inyecta la vista de registro o login -->
                    {{ $slot }}

                </div>
            </div>

        </div>
    </body>
</html>