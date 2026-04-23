<x-app-layout>

<div class="p-8 space-y-8">

{{-- CABECERA --}}
<div class="bg-white shadow rounded-2xl p-6">

<h1 class="text-3xl font-bold">
{{ $paciente->nombres }} {{ $paciente->apellidos }}
</h1>

<p class="text-gray-500 mt-2">
Expediente Clínico del Paciente
</p>

</div>
@if(count($alertas))

<div class="space-y-3">

@foreach($alertas as $alerta)

<div class="
p-4 rounded-xl text-white

@if($alerta['tipo']=='info') bg-blue-600 @endif
@if($alerta['tipo']=='warning') bg-yellow-500 @endif
@if($alerta['tipo']=='danger') bg-red-600 @endif
">

{{ $alerta['texto'] }}

</div>

@endforeach

</div>

@endif
{{-- TARJETAS RESUMEN --}}
<div class="grid md:grid-cols-3 gap-6">

<div class="bg-blue-600 text-white rounded-2xl p-6">
<p>Próxima Cita</p>

@if($proximaCita)
<h2 class="text-xl font-bold mt-2">
{{ $proximaCita->fecha }} {{ $proximaCita->hora }}
</h2>
@else
<h2 class="text-xl font-bold mt-2">Sin cita</h2>
@endif

</div>

<div class="bg-yellow-500 text-white rounded-2xl p-6">
<p>Facturas Pendientes</p>
<h2 class="text-3xl font-bold mt-2">
{{ $facturasPendientes }}
</h2>
</div>

<div class="bg-green-600 text-white rounded-2xl p-6">
<p>Historial Clínico</p>
<h2 class="text-3xl font-bold mt-2">
{{ $historias->count() }}
</h2>
</div>

</div>

{{-- ACCIONES RÁPIDAS --}}
<div class="grid md:grid-cols-4 gap-4">

<a href="/historias/create?paciente={{ $paciente->id }}"
class="bg-gray-900 text-white p-4 rounded-xl text-center">
Nueva Evolución
</a>

<a href="/pacientes/{{ $paciente->id }}/odontograma"
class="bg-purple-600 text-white p-4 rounded-xl text-center">
Odontograma
</a>

<a href="/citas/create?paciente={{ $paciente->id }}"
class="bg-blue-600 text-white p-4 rounded-xl text-center">
Nueva Cita
</a>

<a href="/facturas/create?paciente={{ $paciente->id }}"
class="bg-green-600 text-white p-4 rounded-xl text-center">
Nueva Factura
</a>

</div>

{{-- TIMELINE HISTORIAL --}}
<div class="bg-white shadow rounded-2xl overflow-hidden">

<div class="p-6 border-b">
<h2 class="text-2xl font-bold">
Historial Clínico
</h2>
</div>

@forelse($historias as $historia)

<div class="p-6 border-b space-y-2">

<div class="flex justify-between">
<strong>{{ $historia->fecha }}</strong>
<span class="text-sm text-gray-500">
{{ $historia->odontologo }}
</span>
</div>

<p><strong>Motivo:</strong> {{ $historia->motivo_consulta }}</p>

<p><strong>Diagnóstico:</strong> {{ $historia->diagnostico }}</p>

<p><strong>Tratamiento:</strong> {{ $historia->tratamiento }}</p>

@if($historia->proximo_control)
<p class="text-blue-600">
Próximo control:
{{ $historia->proximo_control }}
</p>
@endif

</div>

@empty

<div class="p-6 text-gray-500">
Paciente sin atenciones clínicas registradas.
</div>

@endforelse

</div>

</div>

</x-app-layout>