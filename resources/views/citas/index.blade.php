<x-app-layout>

<div class="p-8">

<h1 class="text-3xl font-bold mb-6">Agenda de Citas</h1>

<form method="GET" class="mb-6 flex gap-3">

<input type="date" name="fecha"
value="{{ $fecha }}"
class="border rounded-lg px-4 py-2">

<button class="bg-gray-800 text-white px-4 py-2 rounded-lg">
Filtrar
</button>

<a href="{{ route('citas.index') }}"
class="bg-gray-300 px-4 py-2 rounded-lg">
Limpiar
</a>

</form>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
{{ session('success') }}
</div>
@endif

<a href="{{ route('citas.create') }}"
class="bg-cyan-600 text-white px-5 py-3 rounded-lg">
Nueva Cita
</a>

<div class="bg-white shadow rounded-2xl mt-6 overflow-hidden">

<table class="w-full">

<tr class="bg-gray-100">
<th class="p-4 text-left">Paciente</th>
<th>Fecha</th>
<th>Hora</th>
<th>Estado</th>
<th>Acciones</th>
</tr>

@foreach($citas as $cita)

<tr class="border-t">

<td class="p-4">
{{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}
</td>

<td>{{ $cita->fecha }}</td>
<td>{{ $cita->hora }}</td>

<td>

@if($cita->estado == 'pendiente')
<span class="text-yellow-600 font-semibold">Pendiente</span>
@endif

@if($cita->estado == 'confirmada')
<span class="text-blue-600 font-semibold">Confirmada</span>
@endif

@if($cita->estado == 'completada')
<span class="text-green-600 font-semibold">Completada</span>
@endif

@if($cita->estado == 'cancelada')
<span class="text-red-600 font-semibold">Cancelada</span>
@endif

</td>

<td>

<a href="{{ route('citas.edit',$cita) }}"
class="text-blue-600 font-semibold">
Editar
</a>

<form action="{{ route('citas.destroy',$cita) }}"
method="POST" class="inline">

@csrf
@method('DELETE')

<button class="text-red-600 ml-3">
Eliminar
</button>

</form>

</td>

</tr>

@endforeach

</table>

</div>

<div class="mt-6">
{{ $citas->links() }}
</div>

</div>

</x-app-layout>