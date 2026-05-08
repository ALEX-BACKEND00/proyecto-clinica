@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<x-app-layout>

    <div class="space-y-8">

        {{-- CABECERA --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black {{ $isAdmin ? 'text-white' : 'text-slate-900' }} tracking-tight">
                    @if($isAdmin)
                        Agenda de <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-cyan-400">Citas</span>
                    @else
                        Mis <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-cyan-600">Citas</span>
                    @endif
                </h1>

                <p class="text-slate-400 mt-1 font-medium text-sm">
                    {{ $isAdmin ? 'Gestión general de citas odontológicas' : 'Consulta y seguimiento de tus citas odontológicas' }}
                </p>
            </div>

            @if(!$isAdmin && !$puedeCrearCita)

    <div class="bg-amber-50 border border-amber-200 text-amber-700 px-5 py-4 rounded-xl">
        <p class="font-semibold text-sm">
            {{ $mensajeBloqueoCita }}
        </p>
    </div>

@endif
        </div>

        {{-- ALERTA --}}
        @if (session('success'))
            <div class="{{ $isAdmin ? 'bg-emerald-950/40 border-emerald-800/60 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700' }} border px-5 py-4 rounded-xl flex items-center gap-3 backdrop-blur-sm animate-fade-in">
                <svg class="w-5 h-5 flex-shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- FILTRO --}}
        <div class="{{ $isAdmin ? 'bg-slate-800/50 border-slate-700/80 shadow-xl' : 'bg-white border-slate-200 shadow-sm' }} border rounded-2xl p-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                
                <div class="relative">
                    <input type="date" name="fecha" value="{{ $fecha }}" 
                           class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100' : 'bg-white border-slate-200 text-slate-900' }} border text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                </div>

                <button class="w-full bg-slate-700 hover:bg-slate-600 text-white font-bold text-sm rounded-xl px-6 py-3.5 border border-slate-600 transition-colors duration-200">
                    Filtrar
                </button>

                <a href="{{ route('citas.index') }}"
                   class="w-full {{ $isAdmin ? 'bg-slate-800 hover:bg-slate-700 text-slate-400 border-slate-700/80' : 'bg-slate-100 hover:bg-slate-200 text-slate-600 border-slate-200' }} hover:text-slate-200 font-bold text-sm rounded-xl px-6 py-3.5 border text-center transition-colors duration-200">
                    Limpiar
                </a>
            </form>
        </div>

        {{-- TABLA --}}
        <div class="{{ $isAdmin ? 'bg-slate-800 border-slate-700/80 shadow-2xl' : 'bg-white border-slate-200 shadow-sm' }} border rounded-2xl overflow-hidden relative">

            <div class="p-6 border-b {{ $isAdmin ? 'border-slate-700 bg-slate-800/50' : 'border-slate-100 bg-white' }}">
                <h2 class="text-xl font-bold {{ $isAdmin ? 'text-white' : 'text-slate-800' }} tracking-tight">
                    {{ $isAdmin ? 'Listado de Citas' : 'Mis Próximas Citas' }}
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="{{ $isAdmin ? 'bg-slate-900/50 text-slate-400 border-slate-700' : 'bg-slate-50 text-slate-500 border-slate-200' }} text-xs font-black uppercase tracking-widest border-b">
                        <tr>
                            <th class="p-4">{{ $isAdmin ? 'Paciente' : 'Consulta' }}</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Estado</th>
                            @if($isAdmin)
                                <th class="p-4 text-center">Acciones</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody class="divide-y {{ $isAdmin ? 'divide-slate-700/60 text-slate-300' : 'divide-slate-100 text-slate-700' }} text-sm">
                        @forelse($citas as $cita)
                            <tr class="hover:bg-slate-700/20 transition-colors duration-150">
                                <td class="p-4 font-bold {{ $isAdmin ? 'text-white' : 'text-slate-900' }}">
                                    @if($isAdmin)
                                        {{ $cita->paciente->nombres }} {{ $cita->paciente->apellidos }}
                                    @else
                                        Consulta Odontológica
                                    @endif
                                </td>

                                <td class="font-mono text-slate-400">
                                    {{ $cita->fecha }}
                                </td>

                                <td class="font-mono text-slate-400">
                                    {{ $cita->horaFormateada }}
                                </td>

                                <td>
                                    @if ($cita->estado == 'pendiente')
                                        <span class="inline-flex items-center gap-1 font-bold text-xs uppercase tracking-wider border {{ $isAdmin ? 'bg-amber-950/40 border-amber-800/60 text-amber-300' : 'bg-amber-50 border-amber-200 text-amber-700' }} px-3 py-1.5 rounded-lg">
                                            Pendiente
                                        </span>
                                    @elseif($cita->estado == 'confirmada')
                                        <span class="inline-flex items-center gap-1 font-bold text-xs uppercase tracking-wider border {{ $isAdmin ? 'bg-blue-950/40 border-blue-800/60 text-blue-300' : 'bg-blue-50 border-blue-200 text-blue-700' }} px-3 py-1.5 rounded-lg">
                                            Confirmada
                                        </span>
                                    @elseif($cita->estado == 'completada')
                                        <span class="inline-flex items-center gap-1 font-bold text-xs uppercase tracking-wider border {{ $isAdmin ? 'bg-emerald-950/40 border-emerald-800/60 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700' }} px-3 py-1.5 rounded-lg">
                                            Completada
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 font-bold text-xs uppercase tracking-wider border {{ $isAdmin ? 'bg-rose-950/40 border-rose-800/60 text-rose-300' : 'bg-rose-50 border-rose-200 text-rose-700' }} px-3 py-1.5 rounded-lg">
                                            Cancelada
                                        </span>
                                    @endif
                                </td>

                                @if($isAdmin)
                                    <td class="p-4">
                                        <div class="flex flex-wrap items-center justify-center gap-2">
                                            @if(in_array($cita->estado, ['pendiente','confirmada']))
                                                <a href="{{ route('citas.edit', $cita) }}"
                                                   class="inline-flex items-center bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 border border-blue-500/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-200">
                                                    Editar
                                                </a>
                                            @endif

                                            <a href="/pacientes/{{ $cita->paciente_id }}/historia"
                                               class="inline-flex items-center bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-200">
                                                Ficha
                                            </a>

                                            @if(in_array($cita->estado, ['pendiente','confirmada']))
                                                <form action="{{ route('citas.destroy', $cita) }}" method="POST" onsubmit="return confirm('¿Eliminar cita?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="inline-flex items-center bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-200">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $isAdmin ? 5 : 4 }}" class="p-12 text-center text-slate-500 font-medium">
                                    No hay citas registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        {{-- PAGINACION --}}
        <div class="mt-4">
            {{ $citas->links() }}
        </div>

    </div>

</x-app-layout>