<x-app-layout>

    <div class="p-8 space-y-8">

        {{-- CABECERA --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    {{ auth()->user()->role === 'admin' ? 'Agenda de Citas' : 'Mis Citas' }}
                </h1>

                <p class="text-gray-500 mt-2">
{{ auth()->user()->role === 'admin'
? 'Gestión general de citas odontológicas'
: 'Consulta y seguimiento de tus citas odontológicas' }}
</p>
            </div>

            @if(auth()->user()->role === 'admin' || $puedeCrearCita)

<a href="{{ route('citas.create') }}"
class="bg-cyan-600 hover:bg-cyan-700 text-white px-6 py-3 rounded-xl shadow">
    Nueva Cita
</a>

@endif

        </div>

        {{-- ALERTA --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-xl">
                {{ session('success') }}
            </div>
        @endif

        {{-- FILTRO --}}
        <div class="bg-white shadow rounded-2xl p-6">

            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <input type="date" name="fecha" value="{{ $fecha }}" class="border rounded-xl px-4 py-3">

                <button class="bg-gray-800 hover:bg-black text-white rounded-xl px-6 py-3">

                    Filtrar

                </button>

                <a href="{{ route('citas.index') }}"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl px-6 py-3 text-center">

                    Limpiar

                </a>

            </form>

        </div>

        {{-- TABLA --}}
        <div class="bg-white shadow rounded-2xl overflow-hidden">

            <div class="p-6 border-b">

                <h2 class="text-xl font-bold text-gray-800">
{{ auth()->user()->role === 'admin'
? 'Listado de Citas'
: 'Mis Próximas Citas' }}
</h2>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-100 text-gray-700">

                        <tr>
                            <th class="p-4 text-left">
{{ auth()->user()->role === 'admin' ? 'Paciente' : 'Consulta' }}
</th>
                            <th class="text-left">Fecha</th>
                            <th class="text-left">Hora</th>
                            <th class="text-left">Estado</th>
                            @if(auth()->user()->role === 'admin')
<th class="text-left">Acciones</th>
@endif
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($citas as $cita)
                            <tr class="border-t hover:bg-gray-50">

                                <td class="p-4 font-semibold text-gray-800">

@if(auth()->user()->role === 'admin')

    {{ $cita->paciente->nombres }}
    {{ $cita->paciente->apellidos }}

@else

    Cita Odontológica

@endif

</td>

                                <td>
                                    {{ $cita->fecha }}
                                </td>

                                <td>
                                    {{ $cita->hora }}
                                </td>

                                <td>

                                    @if ($cita->estado == 'pendiente')
                                        <span
                                            class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                                            Pendiente
                                        </span>
                                    @elseif($cita->estado == 'confirmada')
                                        <span
                                            class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">
                                            Confirmada
                                        </span>
                                    @elseif($cita->estado == 'completada')
                                        <span
                                            class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                                            Completada
                                        </span>
                                    @else
                                        <span
                                            class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-sm font-semibold">
                                            Cancelada
                                        </span>
                                    @endif

                                </td>

                                @if(auth()->user()->role === 'admin')

<td class="p-4">

    <div class="flex flex-wrap gap-2">
        
        @if(!($cita->estado === 'completada' && $cita->edicion_post_completada == 1))
<a href="{{ route('citas.edit', $cita) }}"
class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-semibold">
    Editar
</a>
@endif

        <a href="/pacientes/{{ $cita->paciente_id }}/historia"
        class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-lg text-sm font-semibold">
            Historia
        </a>

        <form action="{{ route('citas.destroy', $cita) }}"
        method="POST"
        onsubmit="return confirm('¿Eliminar cita?')">

            @csrf
            @method('DELETE')

            <button
            class="bg-red-100 text-red-700 px-3 py-1 rounded-lg text-sm font-semibold">
                Eliminar
            </button>

        </form>

    </div>

</td>

@endif

                            </tr>

                        @empty

                            <tr>

                                <td colspan="{{ auth()->user()->role === 'admin' ? 5 : 4 }}"
class="p-8 text-center text-gray-500">

    No hay citas registradas.

</td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- PAGINACION --}}
        <div>
            {{ $citas->links() }}
        </div>

    </div>

</x-app-layout>
