<x-app-layout>

<div class="p-8 max-w-3xl mx-auto">

<h1 class="text-3xl font-bold mb-6">
    {{ auth()->user()->role === 'admin' ? 'Nueva Cita' : 'Solicitar Cita' }}
</h1>

<form action="{{ route('citas.store') }}" method="POST"
class="bg-white shadow rounded-2xl p-8 space-y-6">

@csrf

<div>
<label class="block mb-2 font-medium">Paciente</label>

@if(auth()->user()->role === 'admin')

<select name="paciente_id"
class="w-full border rounded-lg px-4 py-2">

@foreach($pacientes as $paciente)

<option value="{{ $paciente->id }}"
{{ ($paciente_id == $paciente->id) ? 'selected' : '' }}>

{{ $paciente->nombres }} {{ $paciente->apellidos }}

</option>

@endforeach

</select>

@else

<input type="hidden"
name="paciente_id"
value="{{ $pacientes->first()->id }}">

<div class="w-full border rounded-lg px-4 py-2 bg-gray-100">
    {{ $pacientes->first()->nombres }}
    {{ $pacientes->first()->apellidos }}
</div>

@endif

</div>

<div>
<label class="block mb-2 font-medium">Fecha</label>

<input type="date"
name="fecha"
value="{{ $fecha }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block mb-2 font-medium">Hora</label>

<input type="time"
name="hora"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block mb-2 font-medium">Motivo</label>

<textarea name="motivo"
class="w-full border rounded-lg px-4 py-2"></textarea>
</div>

<button class="bg-cyan-600 text-white px-6 py-3 rounded-lg">
    Guardar Cita
</button>

</form>

</div>

</x-app-layout>