<x-app-layout>

<div class="p-8 max-w-4xl mx-auto">

<h1 class="text-3xl font-bold mb-6">Editar Paciente</h1>

<form action="{{ route('pacientes.update',$paciente) }}" method="POST"
class="bg-white shadow rounded-2xl p-8 space-y-6">

@csrf
@method('PUT')

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<div>
<label class="block font-semibold mb-2">Nombres</label>
<input type="text" name="nombres"
value="{{ $paciente->nombres }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block font-semibold mb-2">Apellidos</label>
<input type="text" name="apellidos"
value="{{ $paciente->apellidos }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block font-semibold mb-2">Documento</label>
<input type="text" name="documento"
value="{{ $paciente->documento }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block font-semibold mb-2">Teléfono</label>
<input type="text" name="telefono"
value="{{ $paciente->telefono }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block font-semibold mb-2">Correo</label>
<input type="email" name="email"
value="{{ $paciente->email }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block font-semibold mb-2">Fecha Nacimiento</label>
<input type="date" name="fecha_nacimiento"
value="{{ $paciente->fecha_nacimiento }}"
class="w-full border rounded-lg px-4 py-2">
</div>

<div class="md:col-span-2">
<label class="block font-semibold mb-2">Dirección</label>
<input type="text" name="direccion"
value="{{ $paciente->direccion }}"
class="w-full border rounded-lg px-4 py-2">
</div>

</div>

<button class="bg-blue-600 text-white px-6 py-3 rounded-lg">
Actualizar Paciente
</button>

</form>

</div>

</x-app-layout>