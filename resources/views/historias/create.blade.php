<x-app-layout>

<div class="p-8 max-w-5xl mx-auto">

<h1 class="text-3xl font-bold mb-2">
Nueva Evolución Clínica
</h1>

<p class="text-gray-500 mb-8">
Registro de atención odontológica del paciente
</p>

<form action="{{ route('historias.store') }}" method="POST"
class="bg-white shadow rounded-2xl p-8 space-y-8">

@csrf

{{-- BLOQUE 1 --}}
<div class="grid md:grid-cols-3 gap-6">

<div>
<label class="font-semibold">Paciente</label>

<select name="paciente_id"
class="w-full border rounded-lg px-4 py-3 mt-2">

@foreach($pacientes as $paciente)

<option value="{{ $paciente->id }}"
{{ ($paciente_id == $paciente->id) ? 'selected' : '' }}>

{{ $paciente->nombres }} {{ $paciente->apellidos }}

</option>

@endforeach

</select>
</div>

<div>
<label class="font-semibold">Fecha</label>

<input type="date"
name="fecha"
value="{{ $fecha }}"
class="w-full border rounded-lg px-4 py-3 mt-2">
</div>

<div>
<label class="font-semibold">Odontólogo</label>

<input type="text"
name="odontologo"
placeholder="Dr. Nombre"
class="w-full border rounded-lg px-4 py-3 mt-2">
</div>

</div>

{{-- BLOQUE 2 --}}
<div class="space-y-6">

<div>
<label class="font-semibold">Motivo de Consulta</label>

<textarea name="motivo_consulta"
rows="3"
class="w-full border rounded-lg px-4 py-3 mt-2"></textarea>
</div>

<div>
<label class="font-semibold">Diagnóstico</label>

<textarea name="diagnostico"
rows="3"
class="w-full border rounded-lg px-4 py-3 mt-2"></textarea>
</div>

<div>
<label class="font-semibold">Tratamiento Realizado</label>

<textarea name="tratamiento"
rows="4"
class="w-full border rounded-lg px-4 py-3 mt-2"></textarea>
</div>

<div>
<label class="font-semibold">Observaciones</label>

<textarea name="observaciones"
rows="3"
class="w-full border rounded-lg px-4 py-3 mt-2"></textarea>
</div>

</div>

{{-- BLOQUE 3 --}}
<div class="grid md:grid-cols-2 gap-6">

<div>
<label class="font-semibold">Próximo Control</label>

<input type="date"
name="proximo_control"
class="w-full border rounded-lg px-4 py-3 mt-2">
</div>

<div class="flex items-end">
<p class="text-sm text-gray-500">
Puedes generar cita o factura luego desde la ficha clínica.
</p>
</div>

</div>

{{-- BOTONES --}}
<div class="flex gap-4 pt-4">

<button
class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold">

Guardar Evolución

</button>

<a href="{{ url()->previous() }}"
class="bg-gray-200 hover:bg-gray-300 px-8 py-3 rounded-xl font-semibold">

Cancelar

</a>

</div>

</form>

</div>

</x-app-layout>