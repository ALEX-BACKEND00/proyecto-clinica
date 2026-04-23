<x-app-layout>

<div class="p-8 max-w-3xl mx-auto">

<h1 class="text-3xl font-bold mb-6">Nueva Factura</h1>

<form action="{{ route('facturas.store') }}" method="POST"
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
<label>Total</label>
<input type="number" step="0.01" name="total"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label>Estado</label>
<select name="estado"
class="w-full border rounded-lg px-4 py-2">
<option value="pendiente">Pendiente</option>
<option value="pagada">Pagada</option>
</select>
</div>

<div>
<label>Descripción</label>
<textarea name="descripcion"
class="w-full border rounded-lg px-4 py-2"></textarea>
</div>

<button class="bg-green-600 text-white px-6 py-3 rounded-lg">
Guardar Factura
</button>

</form>

</div>

</x-app-layout>