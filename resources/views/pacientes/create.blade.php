<x-app-layout>

<div class="p-8 max-w-4xl mx-auto">

<h1 class="text-3xl font-bold mb-6">Nuevo Paciente</h1>

<form action="{{ route('pacientes.store') }}" method="POST"
class="bg-white shadow rounded-2xl p-8 space-y-6">

@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

<div>
<label class="block font-semibold mb-2">Nombres</label>
<input type="text" name="nombres"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block font-semibold mb-2">Apellidos</label>
<input type="text" name="apellidos"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block font-semibold mb-2">Documento</label>
<input type="text" name="documento"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block font-semibold mb-2">Teléfono</label>
<input type="text" name="telefono"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block font-semibold mb-2">Correo</label>
<input type="email" name="email"
class="w-full border rounded-lg px-4 py-2">
</div>

<div>
<label class="block font-semibold mb-2">Fecha Nacimiento</label>
<input type="date" name="fecha_nacimiento"
class="w-full border rounded-lg px-4 py-2">
</div>

<div class="md:col-span-2">
<label class="block font-semibold mb-2">Dirección</label>
<input type="text" name="direccion"
class="w-full border rounded-lg px-4 py-2">
</div>

</div>

<button class="bg-green-600 text-white px-6 py-3 rounded-lg">
Guardar Paciente
</button>

</form>

</div>

</x-app-layout>