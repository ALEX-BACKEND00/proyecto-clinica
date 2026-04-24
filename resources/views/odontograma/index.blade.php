<x-app-layout>

<div class="p-8 space-y-8">

@php
$esAdmin = auth()->user()->role === 'admin';

$arcada_superior = ['18','17','16','15','14','13','12','11','21','22','23','24','25','26','27','28'];
$arcada_inferior = ['48','47','46','45','44','43','42','41','31','32','33','34','35','36','37','38'];
@endphp

{{-- CABECERA --}}
<div>
    <h1 class="text-3xl font-bold text-gray-800">
        {{ $esAdmin ? 'Odontograma Clínico' : 'Mi Odontograma' }}
    </h1>

    <p class="text-gray-500 mt-2">
        Paciente: {{ $paciente->nombres }} {{ $paciente->apellidos }}
    </p>
</div>

@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-xl">
    {{ session('success') }}
</div>
@endif

<form method="POST" action="{{ route('odontograma.guardar') }}">
@csrf

<input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

{{-- LEYENDA --}}
<div class="bg-white shadow rounded-2xl p-6">

    <h2 class="font-bold mb-4">Leyenda Clínica</h2>

    <div class="flex flex-wrap gap-3 text-sm">
        <span class="px-3 py-1 rounded bg-white border">Sano</span>
        <span class="px-3 py-1 rounded bg-red-400 text-white">Caries</span>
        <span class="px-3 py-1 rounded bg-blue-400 text-white">Restaurado</span>
        <span class="px-3 py-1 rounded bg-gray-400 text-white">Ausente</span>
    </div>

</div>

{{-- ODONTOGRAMA --}}
<div class="bg-white shadow rounded-2xl p-6 space-y-8">

    {{-- SUPERIOR --}}
    <div>
        <h2 class="font-bold mb-3">Arcada Superior</h2>

        <div class="grid grid-cols-8 md:grid-cols-16 gap-3">

            @foreach($arcada_superior as $diente)

            @php $estado = $estados[$diente] ?? 'sano'; @endphp

            <div class="diente {{ $estado }} border rounded-xl p-3 text-center {{ $esAdmin ? 'cursor-pointer' : '' }}">
                <p class="font-bold text-sm">{{ $diente }}</p>

                <input type="hidden"
                name="dientes[{{ $diente }}]"
                value="{{ $estado }}">
            </div>

            @endforeach

        </div>
    </div>

    {{-- INFERIOR --}}
    <div>
        <h2 class="font-bold mb-3">Arcada Inferior</h2>

        <div class="grid grid-cols-8 md:grid-cols-16 gap-3">

            @foreach($arcada_inferior as $diente)

            @php $estado = $estados[$diente] ?? 'sano'; @endphp

            <div class="diente {{ $estado }} border rounded-xl p-3 text-center {{ $esAdmin ? 'cursor-pointer' : '' }}">
                <p class="font-bold text-sm">{{ $diente }}</p>

                <input type="hidden"
                name="dientes[{{ $diente }}]"
                value="{{ $estado }}">
            </div>

            @endforeach

        </div>
    </div>

</div>

@if($esAdmin)
<button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl shadow">
    Guardar Odontograma
</button>
@endif

</form>

</div>

<style>
.diente{transition:.2s}
.diente.sano{background:#fff}
.diente.caries{background:#f87171;color:#fff}
.diente.restaurado{background:#60a5fa;color:#fff}
.diente.ausente{background:#9ca3af;color:#fff}
.diente:hover{transform:scale(1.03)}
</style>

@if($esAdmin)
<script>
document.querySelectorAll('.diente').forEach(diente => {

    const estados = ['sano','caries','restaurado','ausente'];

    diente.addEventListener('click', () => {

        let input = diente.querySelector('input');
        let actual = input.value;

        let index = estados.indexOf(actual);
        index = (index + 1) % estados.length;

        let nuevo = estados[index];

        diente.classList.remove(...estados);
        diente.classList.add(nuevo);

        input.value = nuevo;

    });

});
</script>
@endif

</x-app-layout>