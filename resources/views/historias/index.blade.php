{{-- resources/views/historias/index.blade.php --}}

<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        {{-- Encabezado --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Mi Historia Clínica
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Consulta tus registros odontológicos y evolución clínica.
            </p>
        </div>

        {{-- Alertas --}}
        @if(session('error'))
            <div class="mb-4 bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-200 text-green-700 px-4 py-3 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- Resumen --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">

            <div class="bg-white rounded-2xl shadow p-5">
                <p class="text-sm text-gray-500">Total Registros</p>
                <p class="text-2xl font-bold text-gray-800 mt-2">
                    {{ $historias->total() }}
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-5">
                <p class="text-sm text-gray-500">Última Atención</p>
                <p class="text-lg font-semibold text-gray-800 mt-2">
                    @if($historias->count())
                        {{ \Carbon\Carbon::parse($historias->first()->fecha)->format('d/m/Y') }}
                    @else
                        Sin registros
                    @endif
                </p>
            </div>

            <div class="bg-white rounded-2xl shadow p-5">
                <p class="text-sm text-gray-500">Paciente</p>
                <p class="text-lg font-semibold text-gray-800 mt-2">
                    {{ $paciente->nombres }} {{ $paciente->apellidos }}
                </p>
            </div>

        </div>

        {{-- Tabla --}}
        <div class="bg-white rounded-2xl shadow overflow-hidden">

            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold text-gray-800">
                    Historial de Consultas
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">

                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-4 py-3 text-left">Fecha</th>
                            <th class="px-4 py-3 text-left">Odontólogo</th>
                            <th class="px-4 py-3 text-left">Motivo</th>
                            <th class="px-4 py-3 text-left">Diagnóstico</th>
                            <th class="px-4 py-3 text-left">Tratamiento</th>
                            <th class="px-4 py-3 text-left">Próximo Control</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">

                        @forelse($historias as $historia)
                            <tr class="hover:bg-gray-50">

                                <td class="px-4 py-3">
                                    {{ \Carbon\Carbon::parse($historia->fecha)->format('d/m/Y') }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $historia->odontologo ?? 'No registrado' }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $historia->motivo_consulta }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $historia->diagnostico }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $historia->tratamiento }}
                                </td>

                                <td class="px-4 py-3">
                                    @if($historia->proximo_control)
                                        {{ \Carbon\Carbon::parse($historia->proximo_control)->format('d/m/Y') }}
                                    @else
                                        —
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                                    No tienes registros clínicos disponibles.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

        {{-- Paginación --}}
        <div class="mt-6">
            {{ $historias->links() }}
        </div>

    </div>
</x-app-layout>