<x-app-layout>

<div class="p-8 max-w-3xl mx-auto">

<h1 class="text-3xl font-bold mb-6">Editar Cita</h1>

<form action="{{ route('citas.update',$cita) }}" method="POST"
class="bg-white shadow rounded-2xl p-8 space-y-6">

@csrf
@method('PUT')

<div>
<label>Paciente</label>

<select name="paciente_id"
class="w-full border rounded-lg px-4 py-2">

@foreach($pacientes as $paciente)
<option value="{{ $paciente->id }}"
{{ $cita->paciente_id == $paciente->id ? 'selected' : '' }}>
{{ $paciente->nombres }} {{ $paciente->apellidos }}
</option>
@endforeach

</select>
</div>

<div>
<label>Fecha</label>
<input type="date" name="fecha"
value="{{ $cita->fecha }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label>Hora</label>
<input type="time" name="hora"
value="{{ $cita->hora }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label>Estado</label>

<select name="estado"
class="w-full border rounded-lg px-4 py-2">
<option value="pendiente" {{ $cita->estado=='pendiente'?'selected':'' }}>Pendiente</option>
<option value="confirmada" {{ $cita->estado=='confirmada'?'selected':'' }}>Confirmada</option>
<option value="completada" {{ $cita->estado=='completada'?'selected':'' }}>Completada</option>
<option value="cancelada" {{ $cita->estado=='cancelada'?'selected':'' }}>Cancelada</option>
</select>
</div>

<div>
<label>Motivo</label>
<textarea name="motivo"
class="w-full border rounded-lg px-4 py-2">{{ $cita->motivo }}</textarea>
</div>

<button class="bg-blue-600 text-white px-6 py-3 rounded-lg">
Actualizar Cita
</button>

</form>

</div>

</x-app-layout>