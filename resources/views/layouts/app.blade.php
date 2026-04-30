@php
    // Aseguramos que la variable sea exactamente 'role' como en tu BD
    $isAdmin = auth()->user()->role === 'admin';
    
    // Si es admin: Fondo oscuro. Si es paciente: Fondo claro
    $bodyClass = $isAdmin ? 'bg-slate-950 text-slate-200' : 'bg-slate-50 text-slate-800';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CMR Clínica') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="antialiased {{ $bodyClass }} transition-colors duration-500">

    <!-- AQUI ESTABA EL ERROR: Eliminamos las clases dark: predeterminadas de este div -->
    <div class="min-h-screen flex flex-col">
        
        {{-- Navegación --}}
        @include('layouts.navigation')

        {{-- Encabezado Dinámico --}}
        @isset($header)
            <header class="{{ $isAdmin ? 'bg-slate-950' : 'bg-slate-50' }} transition-colors duration-500 pt-2 pb-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Contenido Principal --}}
        <main class="flex-grow py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

    </div>

</body>
</html>