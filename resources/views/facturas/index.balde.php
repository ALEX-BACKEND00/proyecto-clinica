<x-app-layout>

<div class="p-8">

<h1 class="text-3xl font-bold mb-6">Facturación</h1>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
{{ session('success') }}
</div>
@endif

<a href="{{ route('facturas.create') }}"
class="bg-green-600 text-white px-5 py-3 rounded-lg">
Nueva Factura
</a>

<div class="bg-white shadow rounded-2xl mt-6 overflow-hidden">

<table class="w-full">

<tr class="bg-gray-100">
<th class="p-4 text-left">Paciente</th>
<th>Total</th>
<th>Estado</th>
<th>Fecha</th>
<th>Acciones</th>
</tr>

@foreach($facturas as $factura)

<tr class="border-t">

<td class="p-4">
{{ $factura->paciente->nombres }} {{ $factura->paciente->apellidos }}
</td>

<td>$ {{ number_format($factura->total,2) }}</td>

<td>
@if($factura->estado == 'pagada')
<span class="text-green-600 font-semibold">Pagada</span>
@else
<span class="text-yellow-600 font-semibold">Pendiente</span>
@endif
</td>

<td>{{ $factura->created_at->format('Y-m-d') }}</td>

<td>

<a href="{{ route('facturas.edit',$factura) }}"
class="text-blue-600 font-semibold">
Editar
</a>

<form action="{{ route('facturas.destroy',$factura) }}"
method="POST" class="inline">

@csrf
@method('DELETE')

<button class="text-red-600 ml-3">
Eliminar
</button>

</form>

</td>

</tr>

@endforeach

</table>

</div>

<div class="mt-6">
{{ $facturas->links() }}
</div>

</div>

</x-app-layout>