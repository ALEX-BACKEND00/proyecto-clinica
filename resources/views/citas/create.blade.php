<x-app-layout>

<div class="p-8 max-w-3xl mx-auto">

<h1 class="text-3xl font-bold mb-6">Nueva Cita</h1>

<form action="{{ route('citas.store') }}" method="POST"
class="bg-white shadow rounded-2xl p-8 space-y-6">

@csrf

<div>
<label>Paciente</label>

<select name="paciente_id" class="w-full border rounded-lg px-4 py-2">

@foreach($pacientes as $paciente)

<option value="{{ $paciente->id }}"
{{ ($paciente_id == $paciente->id) ? 'selected' : '' }}>

{{ $paciente->nombres }} {{ $paciente->apellidos }}

</option>

@endforeach

</select>
</div>

<div>
<label>Fecha</label>
<input type="date"
name="fecha"
value="{{ $fecha }}"
class="w-full border rounded-lg px-4 py-2">

<div>
<label>Hora</label>
<input type="time" name="hora"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label>Motivo</label>
<textarea name="motivo"
class="w-full border rounded-lg px-4 py-2"></textarea>
</div>

<button class="bg-cyan-600 text-white px-6 py-3 rounded-lg">
Guardar Cita
</button>

</form>

</div>

</x-app-layout>