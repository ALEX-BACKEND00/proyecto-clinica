@php
    // Detectamos el rol una sola vez para limpiar el código inferior
    $isAdmin = auth()->user()->rol === 'admin';
    
    // Configuramos las clases maestras según el rol
    $bodyClass = $isAdmin ? 'bg-slate-950 text-slate-200' : 'bg-slate-50 text-slate-800';
    $headerClass = $isAdmin ? 'bg-slate-900 border-slate-800' : 'bg-white border-slate-200';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'CMR Clínica') }}</title>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="antialiased {{ $bodyClass }} transition-colors duration-500">

    <div class="min-h-screen">
        
        {{-- Navegación: Pasamos el rol para que el componente también cambie internamente --}}
        @include('layouts.navigation', ['isAdmin' => $isAdmin])

        {{-- Encabezado Dinámico --}}
        @isset($header)
            <header class="{{ $headerClass }} border-b shadow-sm transition-colors duration-500">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Contenido Principal --}}
        <main class="py-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $slot }}
            </div>
        </main>

    </div>

</body>
</html>