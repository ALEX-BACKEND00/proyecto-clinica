<x-app-layout>

<div class="p-8 space-y-8">

    {{-- CABECERA --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <h1 class="text-3xl font-bold text-gray-800">
                Gestión de Pacientes
            </h1>

            <p class="text-gray-500 mt-2">
                Administración general de pacientes registrados
            </p>
        </div>

        <a href="{{ route('pacientes.create') }}"
        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow">
            Nuevo Paciente
        </a>

    </div>

    {{-- ALERTA --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-xl">
        {{ session('success') }}
    </div>
    @endif

    {{-- FILTRO --}}
    <div class="bg-white shadow rounded-2xl p-6">

        <form method="GET"
        action="{{ route('pacientes.index') }}"
        class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <input type="text"
            name="buscar"
            value="{{ $buscar }}"
            placeholder="Buscar paciente..."
            class="border rounded-xl px-4 py-3">

            <button
            class="bg-cyan-600 hover:bg-cyan-700 text-white rounded-xl px-6 py-3">
                Buscar
            </button>

            <a href="{{ route('pacientes.index') }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl px-6 py-3 text-center">
                Limpiar
            </a>

        </form>

    </div>

    {{-- TABLA --}}
    <div class="bg-white shadow rounded-2xl overflow-hidden">

        <div class="p-6 border-b">
            <h2 class="text-xl font-bold text-gray-800">
                Listado de Pacientes
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-4 text-left">Paciente</th>
                        <th class="text-left">Documento</th>
                        <th class="text-left">Teléfono</th>
                        <th class="text-left">Acciones</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($pacientes as $paciente)

                <tr class="border-t hover:bg-gray-50">

                    <td class="p-4">
                        <div class="font-semibold text-gray-800">
                            {{ $paciente->nombres }} {{ $paciente->apellidos }}
                        </div>
                    </td>

                    <td>{{ $paciente->documento }}</td>

                    <td>{{ $paciente->telefono }}</td>

                    <td class="p-4">

                        <div class="flex flex-wrap gap-2">

                            <a href="{{ route('pacientes.edit', $paciente->id) }}"
                            class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-semibold">
                                Editar
                            </a>

                            <a href="{{ route('pacientes.odontograma', $paciente->id) }}"
                            class="bg-purple-100 text-purple-700 px-3 py-1 rounded-lg text-sm font-semibold">
                                Odontograma
                            </a>

                            <a href="{{ route('pacientes.historia', $paciente->id) }}"
                            class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-lg text-sm font-semibold">
                                Ficha Clínica
                            </a>

                            <form action="{{ route('pacientes.destroy',$paciente->id) }}"
                            method="POST"
                            class="inline"
                            onsubmit="return confirm('¿Eliminar paciente?')">

                                @csrf
                                @method('DELETE')

                                <button
                                class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-semibold">
                                    Eliminar
                                </button>

                            </form>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">
                        No hay pacientes registrados.
                    </td>
                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- PAGINACION --}}
    <div>
        {{ $pacientes->links() }}
    </div>

</div>

</x-app-layout>