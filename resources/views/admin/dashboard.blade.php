<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>

<body class="bg-gray-950 text-white min-h-screen">

<div class="flex">

    <!-- Sidebar -->
    <aside class="w-72 min-h-screen bg-slate-900 border-r border-slate-800 p-6">

        <h1 class="text-2xl font-bold text-cyan-400 mb-10">
            Clínica Dental
        </h1>

        <nav class="space-y-3">

            <a href="#" class="block px-4 py-3 rounded-lg bg-slate-800 hover:bg-cyan-600 transition">
                Dashboard
            </a>

            <a href="#" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition">
                Pacientes
            </a>

            <a href="#" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition">
                Citas
            </a>

            <a href="#" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition">
                Historiales
            </a>

            <a href="#" class="block px-4 py-3 rounded-lg hover:bg-slate-800 transition">
                Reportes
            </a>

        </nav>

    </aside>

    <!-- Main -->
    <main class="flex-1 p-8">

        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold">Panel Administrativo</h2>

            <span class="bg-cyan-500 text-black px-4 py-2 rounded-lg font-semibold">
                Admin
            </span>
        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

            <div class="bg-slate-900 p-6 rounded-2xl shadow">
                <p class="text-gray-400">Pacientes</p>
                <h3 class="text-3xl font-bold mt-2">124</h3>
            </div>

            <div class="bg-slate-900 p-6 rounded-2xl shadow">
                <p class="text-gray-400">Citas Hoy</p>
                <h3 class="text-3xl font-bold mt-2">18</h3>
            </div>

            <div class="bg-slate-900 p-6 rounded-2xl shadow">
                <p class="text-gray-400">Ingresos</p>
                <h3 class="text-3xl font-bold mt-2">$850</h3>
            </div>

            <div class="bg-slate-900 p-6 rounded-2xl shadow">
                <p class="text-gray-400">Pendientes</p>
                <h3 class="text-3xl font-bold mt-2">6</h3>
            </div>

        </div>

    </main>

</div>

</body>
</html>