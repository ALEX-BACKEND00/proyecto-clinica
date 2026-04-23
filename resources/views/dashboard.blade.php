<x-app-layout>

<div class="p-8 space-y-10">

@if(auth()->user()->role === 'admin')

{{-- CABECERA --}}
<div>
    <h1 class="text-3xl font-bold text-gray-800">
        Bienvenido Administrador
    </h1>

    <p class="text-gray-500 mt-2">
        Resumen operativo del día
    </p>
</div>

{{-- KPIS --}}
<div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-6">

    <div class="bg-white shadow rounded-2xl p-6">
        <p class="text-gray-500 text-sm">Citas Hoy</p>
        <h2 class="text-3xl font-bold">{{ $citasHoy }}</h2>
    </div>

    <div class="bg-white shadow rounded-2xl p-6">
        <p class="text-gray-500 text-sm">Pacientes Nuevos</p>
        <h2 class="text-3xl font-bold">{{ $pacientesHoy }}</h2>
    </div>

    <div class="bg-white shadow rounded-2xl p-6">
        <p class="text-gray-500 text-sm">Facturación Hoy</p>
        <h2 class="text-3xl font-bold">
            ${{ number_format($facturasHoy,2) }}
        </h2>
    </div>

    <div class="bg-white shadow rounded-2xl p-6">
        <p class="text-gray-500 text-sm">Pendientes</p>
        <h2 class="text-3xl font-bold">{{ $facturasPendientes }}</h2>
    </div>

    <div class="bg-white shadow rounded-2xl p-6">
        <p class="text-gray-500 text-sm">Pagadas</p>
        <h2 class="text-3xl font-bold">{{ $facturasPagadas }}</h2>
    </div>

    <div class="bg-white shadow rounded-2xl p-6">
        <p class="text-gray-500 text-sm">Ingreso Mes</p>
        <h2 class="text-2xl font-bold">
            ${{ number_format($ingresoMensual,2) }}
        </h2>
    </div>

</div>

{{-- MODULOS --}}
<div>

    <h2 class="text-2xl font-bold text-gray-800 mb-4">
        Módulos del Sistema
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <a href="{{ route('pacientes.index') }}"
        class="bg-blue-600 text-white p-6 rounded-2xl shadow hover:bg-blue-700">

            <h3 class="text-xl font-bold">Pacientes</h3>
            <p class="mt-2 text-sm opacity-90">
                Gestionar pacientes
            </p>

        </a>

        <a href="{{ route('citas.index') }}"
        class="bg-cyan-600 text-white p-6 rounded-2xl shadow hover:bg-cyan-700">

            <h3 class="text-xl font-bold">Citas</h3>
            <p class="mt-2 text-sm">
                Agenda clínica
            </p>

        </a>

        <a href="{{ route('facturas.index') }}"
        class="bg-green-600 text-white p-6 rounded-2xl shadow hover:bg-green-700">

            <h3 class="text-xl font-bold">Facturación</h3>
            <p class="mt-2 text-sm">
                Cobros y pagos
            </p>

        </a>

    </div>

</div>

{{-- CALENDARIO --}}
<div class="bg-white shadow rounded-2xl p-6">

    <h2 class="text-2xl font-bold mb-4">
        Agenda Clínica Semanal
    </h2>

    <div id="calendario"></div>

</div>

{{-- CITAS Y PROXIMAS --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

{{-- CITAS HOY --}}
<div class="lg:col-span-2 bg-white shadow rounded-2xl overflow-hidden">

    <div class="p-6 border-b">
        <h2 class="text-2xl font-bold">
            Citas de Hoy
        </h2>
    </div>

    <table class="w-full">

        <thead class="bg-gray-100">
            <tr>
                <th class="p-4 text-left">Paciente</th>
                <th class="text-left">Hora</th>
                <th class="text-left">Estado</th>
                <th class="text-left">Acciones</th>
            </tr>
        </thead>

        <tbody>

        @foreach($citasHoyList as $cita)

        <tr class="border-t">

            <td class="p-4">
                {{ $cita->paciente->nombres }}
                {{ $cita->paciente->apellidos }}
            </td>

            <td>{{ $cita->hora }}</td>

            <td>

                @if($cita->estado == 'pendiente')
                    <span class="text-yellow-600 font-semibold">Pendiente</span>
                @elseif($cita->estado == 'confirmada')
                    <span class="text-blue-600 font-semibold">Confirmada</span>
                @elseif($cita->estado == 'completada')
                    <span class="text-green-600 font-semibold">Completada</span>
                @else
                    <span class="text-red-600 font-semibold">Cancelada</span>
                @endif

            </td>

            <td class="space-x-2">

                <form method="POST" action="/citas/{{ $cita->id }}/estado" class="inline">
                    @csrf
                    <input type="hidden" name="estado" value="confirmada">
                    <button class="text-blue-600">Confirmar</button>
                </form>

                <form method="POST" action="/citas/{{ $cita->id }}/completar" class="inline">
                    @csrf
                    <button class="text-green-600">Completar</button>
                </form>

                <form method="POST" action="/citas/{{ $cita->id }}/estado" class="inline">
                    @csrf
                    <input type="hidden" name="estado" value="cancelada">
                    <button class="text-red-600">Cancelar</button>
                </form>

            </td>

        </tr>

        @endforeach

        </tbody>

    </table>

</div>

{{-- PROXIMAS --}}
<div class="bg-white shadow rounded-2xl overflow-hidden">

    <div class="p-6 border-b">
        <h2 class="text-xl font-bold">
            Próximas Citas
        </h2>
    </div>

    <div class="divide-y">

        @foreach($proximasCitas as $cita)

        <div class="p-4">

            <p class="font-semibold">
                {{ $cita->paciente->nombres }}
                {{ $cita->paciente->apellidos }}
            </p>

            <p class="text-sm text-gray-500">
                {{ $cita->fecha }} - {{ $cita->hora }}
            </p>

        </div>

        @endforeach

    </div>

</div>

</div>

{{-- FINANZAS --}}
<div class="bg-white shadow rounded-2xl p-6">

    <h2 class="text-xl font-bold mb-4">
        Ingresos Mensuales
    </h2>

    <canvas id="graficoIngresos"></canvas>

</div>

@else

<div class="space-y-10">

    {{-- CABECERA --}}
    <div>
        <h1 class="text-3xl font-bold text-cyan-700">
            Bienvenido {{ auth()->user()->name }}
        </h1>

        <p class="text-gray-500 mt-2">
            Portal del paciente
        </p>
    </div>

    {{-- TARJETAS RESUMEN --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-cyan-600 text-white rounded-2xl shadow p-6">
            <p class="text-sm opacity-90">Próxima Cita</p>
            <h2 class="text-2xl font-bold mt-2">
                Sin cita programada
            </h2>
        </div>

        <div class="bg-blue-600 text-white rounded-2xl shadow p-6">
            <p class="text-sm opacity-90">Mis Citas</p>
            <h2 class="text-3xl font-bold mt-2">
                0
            </h2>
        </div>

        <div class="bg-green-600 text-white rounded-2xl shadow p-6">
            <p class="text-sm opacity-90">Facturas Pendientes</p>
            <h2 class="text-3xl font-bold mt-2">
                0
            </h2>
        </div>

    </div>

    {{-- MODULOS --}}
    <div>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            Mis Servicios
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <a href="{{ route('citas.create') }}"
            class="bg-white shadow rounded-2xl p-6 hover:shadow-lg transition">

                <h3 class="text-xl font-bold text-gray-800">
                    Solicitar Cita
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    Agenda una nueva consulta odontológica
                </p>

            </a>

            <a href="{{ route('citas.index') }}"
            class="bg-white shadow rounded-2xl p-6 hover:shadow-lg transition">

                <h3 class="text-xl font-bold text-gray-800">
                    Mis Citas
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    Ver próximas y anteriores citas
                </p>

            </a>

            <a href="#"
            class="bg-white shadow rounded-2xl p-6 hover:shadow-lg transition">

                <h3 class="text-xl font-bold text-gray-800">
                    Mi Historial
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    Consultar historia clínica
                </p>

            </a>

            <a href="#"
            class="bg-white shadow rounded-2xl p-6 hover:shadow-lg transition">

                <h3 class="text-xl font-bold text-gray-800">
                    Mi Odontograma
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    Estado dental actualizado
                </p>

            </a>

            <a href="{{ route('facturas.index') }}"
            class="bg-white shadow rounded-2xl p-6 hover:shadow-lg transition">

                <h3 class="text-xl font-bold text-gray-800">
                    Mis Facturas
                </h3>

                <p class="text-sm text-gray-500 mt-2">
                    Consultar pagos pendientes
                </p>

            </a>

            <div class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white rounded-2xl p-6 shadow">

                <h3 class="text-xl font-bold">
                    Consejo Dental
                </h3>

                <p class="text-sm mt-2 opacity-90">
                    Recuerda realizar control odontológico cada 6 meses.
                </p>

            </div>

        </div>

    </div>

    {{-- PANEL INFERIOR --}}
    <div class="bg-white shadow rounded-2xl p-6">

        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Recordatorios
        </h2>

        <ul class="space-y-3 text-gray-600">

            <li>• Cepillado mínimo 3 veces al día.</li>
            <li>• Usa hilo dental diariamente.</li>
            <li>• Agenda tu próximo control preventivo.</li>

        </ul>

    </div>

</div>

@endif

</div>

@if(auth()->user()->role === 'admin')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('graficoIngresos');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: @json($meses),
        datasets: [{
            label: 'Ingresos',
            data: @json($totales),
            backgroundColor: '#06b6d4',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendario');

    var calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'timeGridWeek',
        locale: 'es',
        height: 750,
        expandRows: true,
        slotMinTime: "07:00:00",
        slotMaxTime: "20:00:00",
        allDaySlot: false,
        nowIndicator: true,
        editable: true,

        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'timeGridWeek,timeGridDay'
        },

        events: '/api/citas',

        eventDrop: function(info) {

            fetch('/api/citas/mover', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    id: info.event.id,
                    start: info.event.start
                })
            });

        }

    });

    calendar.render();

});
</script>

<style>
#calendario{
    min-height:750px;
    font-size:14px;
}

.fc{
    font-family:system-ui;
}

.fc-event{
    border-radius:8px;
    padding:2px;
}
</style>

@endif

</x-app-layout>