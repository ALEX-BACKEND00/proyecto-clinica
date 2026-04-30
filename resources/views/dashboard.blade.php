<x-app-layout>

    <div class="p-4 sm:p-8 space-y-10">

        @if(auth()->user()->role === 'admin')
            {{-- ========================================== --}}
            {{--          VISTA ADMINISTRADOR (DARK)         --}}
            {{-- ========================================== --}}
            
            {{-- CABECERA --}}
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-black text-white tracking-tight">
                        Panel <span class="text-teal-400">Administrativo</span>
                    </h1>
                    <p class="text-slate-400 mt-1 font-medium italic">Resumen operativo del día • {{ now()->format('d M, Y') }}</p>
                </div>
                <div class="hidden sm:block">
                    <span class="px-4 py-2 bg-slate-800 border border-slate-700 rounded-xl text-xs font-bold text-teal-400 uppercase tracking-widest">
                        Staff Médico
                    </span>
                </div>
            </div>

            {{-- KPIS --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6">
                @php
                    $kpis = [
                        ['label' => 'Citas Hoy', 'val' => $citasHoy, 'icon' => 'calendar', 'color' => 'text-blue-400'],
                        ['label' => 'Nuevos', 'val' => $pacientesHoy, 'icon' => 'users', 'color' => 'text-purple-400'],
                        ['label' => 'Facturado', 'val' => '$'.number_format($facturasHoy), 'icon' => 'cash', 'color' => 'text-emerald-400'],
                        ['label' => 'Pendientes', 'val' => $facturasPendientes, 'icon' => 'clock', 'color' => 'text-amber-400'],
                        ['label' => 'Pagadas', 'val' => $facturasPagadas, 'icon' => 'check', 'color' => 'text-teal-400'],
                        ['label' => 'Mes', 'val' => '$'.number_format($ingresoMensual), 'icon' => 'chart', 'color' => 'text-cyan-400'],
                    ];
                @endphp

                @foreach($kpis as $kpi)
                    <div class="bg-slate-800/50 border border-slate-700 p-5 rounded-2xl hover:border-slate-500 transition-colors">
                        <p class="text-slate-400 text-xs font-bold uppercase tracking-tighter">{{ $kpi['label'] }}</p>
                        <h2 class="text-xl sm:text-2xl font-black text-white mt-1">{{ $kpi['val'] }}</h2>
                    </div>
                @endforeach
            </div>

            {{-- MODULOS --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('pacientes.index') }}" class="group relative overflow-hidden bg-slate-800 border border-slate-700 p-6 rounded-2xl transition-all hover:bg-slate-700">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                        <svg class="w-24 h-24 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08s5.97 1.09 6 3.08c-1.29 1.94-3.5 3.22-6 3.22z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Pacientes</h3>
                    <p class="mt-1 text-slate-400 text-sm">Gestión de base de datos clínica.</p>
                </a>

                <a href="{{ route('citas.index') }}" class="group relative overflow-hidden bg-slate-800 border border-slate-700 p-6 rounded-2xl transition-all hover:bg-slate-700">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                        <svg class="w-24 h-24 text-cyan-500" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Citas</h3>
                    <p class="mt-1 text-slate-400 text-sm">Control de agenda y horarios.</p>
                </a>

                <a href="{{ route('facturas.index') }}" class="group relative overflow-hidden bg-slate-800 border border-slate-700 p-6 rounded-2xl transition-all hover:bg-slate-700">
                    <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:scale-110 transition-transform">
                        <svg class="w-24 h-24 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M11.8 10.9c-2.27-.59-3-1.2-3-2.15 0-1.09 1.01-1.85 2.7-1.85 1.78 0 2.44.85 2.5 2.1h2.21c-.07-2.01-1.39-3.59-3.51-4.13V3h-2.7v2.01c-1.89.41-3.41 1.63-3.41 3.59 0 2.34 1.92 3.51 4.71 4.19 2.67.64 3.19 1.48 3.19 2.39 0 1.02-1.03 1.9-2.85 1.9-2.05 0-2.83-1.03-2.94-2.29H6.41c.11 2.52 1.89 4.07 4.19 4.5V21h2.7v-2.01c1.92-.37 3.53-1.5 3.53-3.6 0-2.75-2.26-3.8-5.03-4.49z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-white">Facturación</h3>
                    <p class="mt-1 text-slate-400 text-sm">Contabilidad y cierres de caja.</p>
                </a>
            </div>

            {{-- AGENDA Y TABLA --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- CALENDARIO --}}
                <div class="lg:col-span-2 bg-slate-800 border border-slate-700 shadow-2xl rounded-2xl overflow-hidden p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-black text-white">Agenda Clínica</h2>
                        <span class="text-[10px] uppercase font-bold text-slate-500 tracking-widest">Vista Tiempo Real</span>
                    </div>
                    <div id="calendario" class="text-slate-200"></div>
                </div>

                {{-- PRÓXIMAS --}}
                <div class="bg-slate-800 border border-slate-700 rounded-2xl overflow-hidden">
                    <div class="p-5 border-b border-slate-700 bg-slate-800/50">
                        <h2 class="text-lg font-bold text-white flex items-center gap-2">
                            <span class="w-2 h-2 bg-teal-400 rounded-full animate-pulse"></span>
                            Próximos Turnos
                        </h2>
                    </div>
                    <div class="divide-y divide-slate-700 max-h-[600px] overflow-y-auto">
                        @foreach($proximasCitas as $cita)
                            <div class="p-4 hover:bg-slate-700/30 transition-colors">
                                <p class="font-bold text-slate-200">{{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}</p>
                                <p class="text-xs text-teal-400 font-medium mt-1 uppercase tracking-wider">
                                    {{ $cita->fecha }} • {{ $cita->hora }}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- TABLA CITAS HOY --}}
            <div class="bg-slate-800 border border-slate-700 shadow-2xl rounded-2xl overflow-hidden">
                <div class="p-6 border-b border-slate-700">
                    <h2 class="text-xl font-black text-white tracking-tight">Pacientes Citados Hoy</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-900/50 text-slate-400 text-xs uppercase font-black tracking-widest">
                            <tr>
                                <th class="p-4">Paciente</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-700 text-sm">
                            @foreach($citasHoyList as $cita)
                                <tr class="hover:bg-slate-700/20 transition-colors">
                                    <td class="p-4 font-bold text-slate-200">
                                        {{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}
                                    </td>
                                    <td class="text-slate-400 font-mono">{{ $cita->hora }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $cita->estado }}">
                                            {{ $cita->estado }}
                                        </span>
                                    </td>
                                    <td class="p-4 flex items-center justify-center gap-4">
                                        @if($cita->estado === 'pendiente')
                                            <form method="POST" action="{{ route('citas.estado', $cita) }}">
                                                @csrf
                                                <input type="hidden" name="estado" value="confirmada">
                                                <button class="text-blue-400 hover:text-blue-300 font-bold text-xs uppercase tracking-widest">Confirmar</button>
                                            </form>
                                        @endif
                                        @if(in_array($cita->estado, ['pendiente', 'confirmada']))
                                            <form method="POST" action="{{ route('citas.completar', $cita) }}">
                                                @csrf
                                                <button class="text-emerald-400 hover:text-emerald-300 font-bold text-xs uppercase tracking-widest">Completar</button>
                                            </form>
                                        @endif
                                        @if(!in_array($cita->estado, ['cancelada', 'completada']))
                                            <form method="POST" action="{{ route('citas.estado', $cita) }}" onsubmit="return confirm('¿Cancelar cita?')">
                                                @csrf
                                                <input type="hidden" name="estado" value="cancelada">
                                                <button class="text-rose-500 hover:text-rose-400 font-bold text-xs uppercase tracking-widest">Cancelar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- FINANZAS --}}
            <div class="bg-slate-800 border border-slate-700 rounded-2xl p-6 shadow-2xl">
                <h2 class="text-xl font-black text-white mb-6">Rendimiento Financiero Anual</h2>
                @if($ingresosMensuales->isNotEmpty())
                    <div class="overflow-hidden border border-slate-700 rounded-xl">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-900/50 text-slate-500 uppercase text-[10px] font-black tracking-widest">
                                <tr>
                                    <th class="px-6 py-4 text-left">Mes Contable</th>
                                    <th class="px-6 py-4 text-right">Ingresos Percibidos</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-700">
                                @foreach($ingresosMensuales as $ingreso)
                                    <tr class="hover:bg-slate-700/20 transition-colors">
                                        <td class="px-6 py-4 text-slate-300 font-medium">{{ \Carbon\Carbon::create()->month($ingreso->mes)->format('F') }}</td>
                                        <td class="px-6 py-4 text-right font-mono text-emerald-400">${{ number_format($ingreso->total, 2) }}</td>
                                    </tr>
                                @endforeach
                                <tr class="bg-slate-900/80">
                                    <td class="px-6 py-4 font-black text-white">TOTAL ACUMULADO ANUAL</td>
                                    <td class="px-6 py-4 text-right font-black text-teal-400 text-lg">${{ number_format($ingresosMensuales->sum('total'), 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-10 bg-slate-900/30 rounded-xl border border-dashed border-slate-700 text-slate-500">
                        No se registran datos financieros en el periodo actual.
                    </div>
                @endif
            </div>

        @else
            {{-- ========================================== --}}
            {{--           VISTA PACIENTE (LIGHT)            --}}
            {{-- ========================================== --}}
            {{-- Aquí va el código que ya diseñamos anteriormente para el paciente --}}
            <div class="space-y-8 sm:space-y-12">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                            Hola, <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-cyan-600">{{ auth()->user()->name }}</span>
                        </h1>
                        <p class="text-slate-500 mt-2 font-medium italic italic">Bienvenido a tu portal de salud dental</p>
                    </div>
                </div>

                {{-- TARJETAS RESUMEN PACIENTE --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- [CONTENIDO PREVIO DE PACIENTE] --}}
                    {{-- Próxima Cita --}}
                    <div class="bg-gradient-to-br from-teal-600 to-cyan-700 text-white rounded-2xl shadow-xl p-6 relative overflow-hidden">
                        <div class="absolute -right-4 -top-4 opacity-20"><svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg></div>
                        <p class="text-xs font-bold uppercase tracking-widest opacity-80">Tu Próxima Cita</p>
                        @if($proximaCita)
                            <h2 class="text-2xl font-black mt-2">{{ \Carbon\Carbon::parse($proximaCita->fecha)->format('d/m/Y') }}</h2>
                            <p class="text-sm mt-1 font-medium italic">{{ $proximaCita->hora ? substr($proximaCita->hora,0,5) : '--:--' }} • {{ ucfirst($proximaCita->estado) }}</p>
                        @else
                            <h2 class="text-xl font-bold mt-2">Sin citas activas</h2>
                            <a href="{{ route('citas.create') }}" class="mt-4 inline-block bg-white/20 px-4 py-2 rounded-lg text-xs font-bold hover:bg-white/30 transition-all">AGENDAR AHORA</a>
                        @endif
                    </div>
                    
                    {{-- Tiempo sin atención --}}
                    <div class="rounded-2xl shadow-lg p-6 text-white @if($alertaDias == 'danger') bg-rose-600 @elseif($alertaDias == 'warning') bg-amber-500 @else bg-slate-800 @endif">
                        <p class="text-xs font-bold uppercase tracking-widest opacity-80">Estado de Control</p>
                        @if($diasSinCita !== null)
                            <h2 class="text-3xl font-black mt-2">{{ $diasSinCita }} <span class="text-sm font-normal">Días</span></h2>
                            <p class="text-xs mt-2 font-bold">{{ $alertaDias == 'danger' ? '⚠️ NECESITAS REVISIÓN' : ($alertaDias == 'warning' ? '⏳ CONTROL PRÓXIMO' : '✅ AL DÍA') }}</p>
                        @else
                            <h2 class="text-xl font-bold mt-2">Nuevo Paciente</h2>
                        @endif
                    </div>

                    {{-- Facturas --}}
                    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Facturas Pendientes</p>
                        <h2 class="text-4xl font-black text-slate-800 mt-2">{{ $facturasPendientes }}</h2>
                        <p class="text-xs mt-2 font-bold @if($facturasPendientes > 0) text-rose-500 @else text-emerald-500 @endif">
                            {{ $facturasPendientes > 0 ? 'PAGOS POR REALIZAR' : 'SIN DEUDAS' }}
                        </p>
                    </div>
                </div>

                {{-- MODULOS PACIENTE --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('citas.create') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl transition-all group">
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-teal-600 transition-colors">Solicitar Cita</h3>
                        <p class="text-sm text-slate-500 mt-1">Agenda tu espacio con nosotros.</p>
                    </a>
                    <a href="{{ route('citas.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl transition-all group">
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-teal-600 transition-colors">Mis Citas</h3>
                        <p class="text-sm text-slate-500 mt-1">Ver historial y agendamientos.</p>
                    </a>
                    <a href="{{ route('historias.index') }}" class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl transition-all group">
                        <h3 class="text-lg font-bold text-slate-800 group-hover:text-teal-600 transition-colors">Mi Historial</h3>
                        <p class="text-sm text-slate-500 mt-1">Tu salud dental paso a paso.</p>
                    </a>
                </div>
            </div>
        @endif

    </div>

    {{-- SCRIPTS Y ESTILOS ESPECÍFICOS --}}
    @if(auth()->user()->role === 'admin')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @vite('resources/js/agenda.js')

        <style>
            /* Badges Dinámicos en Modo Oscuro */
            .status-badge {
                padding: 4px 12px;
                border-radius: 8px;
                font-size: 10px;
                font-weight: 800;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .status-pendiente { background: #451a03; color: #fbbf24; border: 1px solid #78350f; }
            .status-confirmada { background: #172554; color: #60a5fa; border: 1px solid #1e3a8a; }
            .status-completada { background: #064e3b; color: #34d399; border: 1px solid #065f46; }
            .status-cancelada { background: #450a0a; color: #f87171; border: 1px solid #7f1d1d; }

            /* ========================================================= */
            /* AJUSTES DE FULLCALENDAR - DARK MODE Y CORRECCIÓN OVERFLOW */
            /* ========================================================= */
            
            /* Elimina bordes gruesos generales */
            .fc { border: none !important; font-family: 'Inter', sans-serif !important; }
            .fc-header-toolbar { margin-bottom: 2rem !important; }
            .fc-toolbar-title { font-size: 1.25rem !important; font-weight: 800 !important; color: white; }
            
            /* Botones del mes/semana */
            .fc-button { background: #1e293b !important; border: 1px solid #334155 !important; font-weight: 700 !important; text-transform: uppercase !important; font-size: 10px !important; box-shadow: none !important; }
            .fc-button-active { background: #0d9488 !important; border-color: #0d9488 !important; color: white !important; }
            
            /* Bordes de las celdas */
            .fc-theme-standard td, .fc-theme-standard th { border-color: #334155 !important; }
            .fc-day-today { background: rgba(13, 148, 136, 0.1) !important; } /* Resalta el día de hoy con teal */
            
            /* 1. SOLUCIÓN FONDO BLANCO EN CABECERA DE DÍAS */
            .fc .fc-col-header-cell {
                background-color: #0f172a !important; /* bg-slate-900 */
                padding: 8px 0 !important;
            }
            .fc-col-header-cell-cushion { color: #94a3b8 !important; text-decoration: none !important; font-weight: 800; text-transform: uppercase; font-size: 11px;}
            
            /* Números de los días */
            .fc-daygrid-day-number { color: #64748b; font-weight: 700; padding: 8px !important; text-decoration: none !important; }

            /* ========================================================= */
            /* 2. SOLUCIÓN DESBORDAMIENTO DE LOS EVENTOS (LAS CITAS)     */
            /* ========================================================= */
            
            /* Contenedor que abraza el evento */
            .fc-daygrid-event-harness {
                max-width: 100% !important; /* Evita que crezca más allá de la celda */
            }

            /* La caja del evento en sí */
            .fc-event {
                margin: 2px !important;
                padding: 4px 6px !important;
                border-radius: 6px !important;
                border: 1px solid rgba(255,255,255,0.1) !important;
                overflow: hidden !important; /* Corta lo que sale */
                white-space: normal !important; /* Permite saltos de línea */
                word-break: break-word !important; /* Rompe nombres largos si no caben */
                
                /* Si le inyectas colores dinámicos desde JS, déjalos. Si no, le damos un color base */
                background-color: #1e293b !important; /* bg-slate-800 */
                color: #e2e8f0 !important; /* text-slate-200 */
            }

            /* El contenido de texto dentro de la cita */
            .fc-event-main {
                display: flex !important;
                flex-direction: column !important;
                gap: 2px;
                line-height: 1.2 !important;
                font-size: 10px !important;
                overflow: hidden !important;
            }

            /* Si tus eventos tienen la clase .confirmada, .cancelada, etc desde el backend/JS */
            .fc-event.confirmada { border-left: 3px solid #3b82f6 !important; }
            .fc-event.pendiente { border-left: 3px solid #f59e0b !important; }
            .fc-event.completada { border-left: 3px solid #10b981 !important; }
            .fc-event.cancelada { border-left: 3px solid #ef4444 !important; opacity: 0.6; }
        </style>
    @endif

</x-app-layout>