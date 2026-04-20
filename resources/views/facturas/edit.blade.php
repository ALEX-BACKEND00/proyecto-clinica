<x-app-layout>

<div class="p-8 max-w-3xl mx-auto">

<h1 class="text-3xl font-bold mb-6">Editar Factura</h1>

<form action="{{ route('facturas.update',$factura) }}" method="POST"
class="bg-white shadow rounded-2xl p-8 space-y-6">

@csrf
@method('PUT')

<div>
<label>Paciente</label>

<select name="paciente_id"
class="w-full border rounded-lg px-4 py-2">

@foreach($pacientes as $paciente)
<option value="{{ $paciente->id }}"
{{ $factura->paciente_id == $paciente->id ? 'selected' : '' }}>
{{ $paciente->nombres }} {{ $paciente->apellidos }}
</option>
@endforeach

</select>
</div>

<div>
<label>Total</label>
<input type="number" step="0.01" name="total"
value="{{ $factura->total }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label>Estado</label>

<select name="estado"
class="w-full border rounded-lg px-4 py-2">

<option value="pendiente"
{{ $factura->estado=='pendiente'?'selected':'' }}>
Pendiente
</option>

<option value="pagada"
{{ $factura->estado=='pagada'?'selected':'' }}>
Pagada
</option>

</select>
</div>

<div>
<label>Descripción</label>
<textarea name="descripcion"
class="w-full border rounded-lg px-4 py-2">{{ $factura->descripcion }}</textarea>
</div>

<button class="bg-blue-600 text-white px-6 py-3 rounded-lg">
Actualizar Factura
</button>

</form>

</div>

</x-app-layout>