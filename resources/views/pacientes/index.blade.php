<x-app-layout>

<div class="p-8">

<h1 class="text-3xl font-bold mb-6">Gestión de Pacientes</h1>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
    {{ session('success') }}
</div>
@endif

<div class="flex flex-col md:flex-row gap-4 justify-between mb-6">

<form method="GET" action="{{ route('pacientes.index') }}">
    <input type="text" name="buscar"
    value="{{ $buscar }}"
    placeholder="Buscar paciente..."
    class="border rounded-lg px-4 py-2">
</form>

<a href="{{ route('pacientes.create') }}"
class="bg-green-600 text-white px-5 py-3 rounded-lg">
Nuevo Paciente
</a>

</div>

<div class="bg-white shadow rounded-2xl overflow-hidden">

<table class="w-full">

<tr class="bg-gray-100 text-left">
<th class="p-4">Nombre</th>
<th>Documento</th>
<th>Teléfono</th>
<th>Acciones</th>
</tr>

@foreach($pacientes as $paciente)
<tr class="border-t">

<td class="p-4">
{{ $paciente->nombres }} {{ $paciente->apellidos }}
</td>

<td>{{ $paciente->documento }}</td>

<td>{{ $paciente->telefono }}</td>

<td class="space-x-3">

<a href="{{ route('pacientes.edit',$paciente) }}"
class="text-blue-600 font-semibold">
Editar
</a>

<form action="{{ route('pacientes.destroy',$paciente) }}"
method="POST" class="inline">

@csrf
@method('DELETE')

<button class="text-red-600 font-semibold">
Eliminar
</button>

</form>

</td>

</tr>
@endforeach

</table>

</div>

<div class="mt-6">
{{ $pacientes->links() }}
</div>

</div>

</x-app-layout>