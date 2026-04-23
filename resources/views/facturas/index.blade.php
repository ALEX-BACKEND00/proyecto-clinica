<x-app-layout>

<div class="p-8 space-y-8">

{{-- CABECERA --}}
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

    <div>

        <h1 class="text-3xl font-bold text-gray-800">
            {{ auth()->user()->role === 'admin' ? 'Facturación' : 'Mis Facturas' }}
        </h1>

        <p class="text-gray-500 mt-2">
            {{ auth()->user()->role === 'admin'
            ? 'Gestión financiera de la clínica'
            : 'Consulta tus pagos y facturas odontológicas' }}
        </p>

    </div>

    @if(auth()->user()->role === 'admin')

    <a href="{{ route('facturas.create') }}"
    class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-xl shadow">

        Nueva Factura

    </a>

    @endif

</div>

{{-- ALERTA --}}
@if(session('success'))

<div class="bg-green-100 border border-green-200 text-green-700 px-5 py-4 rounded-xl">
    {{ session('success') }}
</div>

@endif

{{-- TABLA --}}
<div class="bg-white shadow rounded-2xl overflow-hidden">

    <div class="p-6 border-b">

        <h2 class="text-xl font-bold text-gray-800">
            {{ auth()->user()->role === 'admin'
            ? 'Listado de Facturas'
            : 'Mis Facturas Pendientes y Pagadas' }}
        </h2>

    </div>

    <div class="overflow-x-auto">

        <table class="w-full">

            <thead class="bg-gray-100 text-gray-700">

                <tr>

                    <th class="p-4 text-left">
                        {{ auth()->user()->role === 'admin' ? 'Paciente' : 'Servicio' }}
                    </th>

                    <th class="text-left">Total</th>
                    <th class="text-left">Estado</th>
                    <th class="text-left">Fecha</th>

                    @if(auth()->user()->role === 'admin')
                    <th class="text-left">Acciones</th>
                    @endif

                </tr>

            </thead>

            <tbody>

            @forelse($facturas as $factura)

            <tr class="border-t hover:bg-gray-50">

                <td class="p-4 font-semibold text-gray-800">

                    @if(auth()->user()->role === 'admin')

                        {{ $factura->paciente->nombres }}
                        {{ $factura->paciente->apellidos }}

                    @else

                        Atención Odontológica

                    @endif

                </td>

                <td>
                    $ {{ number_format($factura->total,2) }}
                </td>

                <td>

                    @if($factura->estado == 'pagada')

                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-semibold">
                        Pagada
                    </span>

                    @else

                    <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-semibold">
                        Pendiente
                    </span>

                    @endif

                </td>

                <td>
                    {{ $factura->created_at->format('Y-m-d') }}
                </td>

                @if(auth()->user()->role === 'admin')

                <td class="p-4">

                    <div class="flex flex-wrap gap-2">

                        <a href="{{ route('facturas.edit',$factura) }}"
                        class="bg-blue-100 text-blue-700 px-3 py-1 rounded-lg text-sm font-semibold">

                            Editar

                        </a>

                        <form action="{{ route('facturas.destroy',$factura) }}"
                        method="POST"
                        onsubmit="return confirm('¿Eliminar factura?')">

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

                    No hay facturas registradas.

                </td>

            </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>

<div>
{{ $facturas->links() }}
</div>

</div>

</x-app-layout>