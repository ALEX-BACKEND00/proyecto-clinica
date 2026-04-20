<x-app-layout>

    <div class="p-8">

        @if(auth()->user()->role === 'admin')

            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                Bienvenido Administrador
            </h1>

            <p class="text-gray-500 mb-8">
                Resumen operativo del día
            </p>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

                    <div class="bg-white shadow rounded-2xl p-6">
                        <p class="text-gray-500">Facturas Pendientes</p>
                        <h2 class="text-4xl font-bold">{{ $facturasPendientes }}</h2>
                    </div>

                    <div class="bg-white shadow rounded-2xl p-6">
                        <p class="text-gray-500">Facturas Pagadas</p>
                        <h2 class="text-4xl font-bold">{{ $facturasPagadas }}</h2>
                    </div>

                    <div class="bg-white shadow rounded-2xl p-6">
                        <p class="text-gray-500">Ingreso Mensual</p>
                        <h2 class="text-4xl font-bold">
                            $ {{ number_format($ingresoMensual, 2) }}
                        </h2>
                    </div>

                </div>

                <div class="bg-white shadow rounded-2xl p-6">
                    <p class="text-gray-500">Citas agendadas</p>
                    <h2 class="text-4xl font-bold">{{ $citasHoy }}</h2>
                </div>

                <div class="bg-white shadow rounded-2xl p-6">
                    <p class="text-gray-500">Pacientes registrados</p>
                    <h2 class="text-4xl font-bold">{{ $pacientesHoy }}</h2>
                </div>

                <div class="bg-white shadow rounded-2xl p-6">
                    <p class="text-gray-500">Facturas del día</p>
                    <h2 class="text-4xl font-bold">
                        $ {{ number_format($facturasHoy, 2) }}
                    </h2>
                </div>

            </div>
            <div class="bg-white shadow rounded-2xl p-6 mt-10">

                <h2 class="text-2xl font-bold mb-4">
                    Agenda Clínica Semanal
                </h2>

                <div id="calendario"></div>

            </div>
            <div class="mt-10">


                <h2 class="text-2xl font-bold mb-4">
                    Citas de Hoy
                </h2>

                <div class="bg-white shadow rounded-2xl overflow-hidden">

                    <table class="w-full">

                        <tr class="bg-gray-100 text-left">
                            <th class="p-4">Paciente</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>

                        @foreach($citasHoyList as $cita)

                            <tr class="border-t">

                                <td class="p-4">
                                    {{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}
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

                                    <form method="POST" action="/citas/{{ $cita->id }}/estado" class="inline">
                                        @csrf
                                        <input type="hidden" name="estado" value="completada">
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

                    </table>

                </div>

            </div>

            <h2 class="text-2xl font-bold mb-4">
                Próximas Citas
            </h2>

            <div class="bg-white shadow rounded-2xl overflow-hidden mb-10">

                <table class="w-full">

                    <tr class="bg-gray-100">
                        <th class="p-4 text-left">Paciente</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                    </tr>


                    @foreach($proximasCitas as $cita)
                        <tr class="border-t">
                            <td class="p-4">
                                {{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}
                            </td>
                            <td>{{ $cita->fecha }}</td>
                            <td>{{ $cita->hora }}</td>
                        </tr>
                    @endforeach

                </table>

            </div>


        @else

            <h1 class="text-3xl font-bold text-blue-700 mb-6">
                Bienvenido Paciente
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="bg-white shadow rounded-2xl p-6">
                    Solicitar cita
                </div>

                <div class="bg-white shadow rounded-2xl p-6">
                    Mis citas
                </div>

                <div class="bg-white shadow rounded-2xl p-6">
                    Mi historial
                </div>

            </div>

        @endif

    </div>

    @if(auth()->user()->role === 'admin')

        <div class="mt-10">

            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                Módulos del Sistema
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <a href="{{ route('pacientes.index') }}"
                    class="bg-blue-600 text-white p-6 rounded-2xl shadow hover:bg-blue-700 transition">

                    <h3 class="text-xl font-bold">Pacientes</h3>
                    <p class="mt-2 text-sm opacity-90">
                        Gestionar registros de pacientes
                    </p>

                </a>

                <a href="{{ route('citas.index') }}"
                    class="bg-cyan-600 text-white p-6 rounded-2xl shadow hover:bg-cyan-700">

                    <h3 class="text-xl font-bold">Citas</h3>
                    <p class="mt-2 text-sm">Gestionar agenda clínica</p>

                </a>
                <a href="{{ route('facturas.index') }}"
                    class="bg-green-600 text-white p-6 rounded-2xl shadow hover:bg-green-700">

                    <h3 class="text-xl font-bold">Facturación</h3>
                    <p class="mt-2 text-sm">Cobros y facturas</p>

                </a>


            </div>

        </div>
        <div class="bg-white shadow rounded-2xl p-6">

            <h2 class="text-xl font-bold mb-4">
                Ingresos Mensuales
            </h2>

            <canvas id="graficoIngresos"></canvas>
            <script>
                const ctx = document.getElementById('graficoIngresos');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: @json($meses),
                        datasets: [{
                            label: 'Ingresos',
                            data: @json($totales),
                            borderWidth: 1,
                            backgroundColor: '#06b6d4'
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>

        </div>

    @endif
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendario');

    var calendar = new FullCalendar.Calendar(calendarEl, {

        initialView: 'timeGridWeek', // 👈 clave: vista semanal
        locale: 'es',

        height: 750, // 👈 tamaño grande tipo clínica
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
#calendario {
    min-height: 750px;
    font-size: 14px;
}

.fc {
    font-family: system-ui;
}

.fc-event {
    border-radius: 8px;
    padding: 2px;
}
</style>

</x-app-layout>