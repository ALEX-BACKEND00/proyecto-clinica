@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<x-app-layout>

<div class="space-y-8">

    {{-- CABECERA --}}
    <div class="bg-slate-800/50 border border-slate-700/80 shadow-xl rounded-2xl p-6 sm:p-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                    {{ $paciente->nombres }} <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-cyan-400">{{ $paciente->apellidos }}</span>
                </h1>
                <p class="text-slate-400 mt-1 font-medium text-sm">
                    Expediente Clínico del Paciente
                </p>
            </div>

            @if($isAdmin)
                <a href="{{ route('pacientes.index') }}" class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white border border-slate-700 font-bold text-sm px-5 py-3 rounded-xl transition-all duration-200">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            @endif
        </div>
    </div>

    {{-- ALERTAS --}}
    @if(count($alertas))
        <div class="space-y-3">
            @foreach($alertas as $alerta)
                <div class="p-4 rounded-xl border flex items-center gap-3 backdrop-blur-sm animate-fade-in text-sm font-semibold
                    @if($alerta['tipo']=='info') bg-blue-950/40 border-blue-800/60 text-blue-300 @endif
                    @if($alerta['tipo']=='warning') bg-amber-950/40 border-amber-800/60 text-amber-300 @endif
                    @if($alerta['tipo']=='danger') bg-rose-950/40 border-rose-800/60 text-rose-300 @endif">
                    
                    @if($alerta['tipo']=='info')
                        <svg class="w-5 h-5 flex-shrink-0 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @elseif($alerta['tipo']=='warning')
                        <svg class="w-5 h-5 flex-shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    @elseif($alerta['tipo']=='danger')
                        <svg class="w-5 h-5 flex-shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    @endif
                    
                    {{ $alerta['texto'] }}
                </div>
            @endforeach
        </div>
    @endif

    {{-- TARJETAS RESUMEN --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <div class="bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded-2xl p-6 shadow-lg shadow-blue-500/10">
            <p class="text-xs font-black uppercase tracking-widest text-blue-100 opacity-90">Próxima Cita</p>
            @if($proximaCita)
                <h2 class="text-xl font-black mt-2 tracking-tight">
                    {{ \Carbon\Carbon::parse($proximaCita->fecha)->format('d/m/Y') }} <span class="text-blue-100 font-normal">|</span> {{ $proximaCita->hora }}
                </h2>
            @else
                <h2 class="text-xl font-black mt-2 tracking-tight opacity-80">Sin cita programada</h2>
            @endif
        </div>

        <div class="bg-gradient-to-br from-amber-500 to-orange-600 text-white rounded-2xl p-6 shadow-lg shadow-orange-500/10">
            <p class="text-xs font-black uppercase tracking-widest text-orange-100 opacity-90">Facturas Pendientes</p>
            <h2 class="text-3xl font-black mt-2 tracking-tight">
                {{ $facturasPendientes }}
            </h2>
        </div>

        <div class="bg-gradient-to-br from-teal-500 to-cyan-600 text-white rounded-2xl p-6 shadow-lg shadow-teal-500/10">
            <p class="text-xs font-black uppercase tracking-widest text-teal-100 opacity-90">Historial Clínico</p>
            <h2 class="text-3xl font-black mt-2 tracking-tight">
                {{ $historias->count() }}
            </h2>
        </div>

    </div>

    {{-- ACCIONES RÁPIDAS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

        <a href="/historias/create?paciente={{ $paciente->id }}"
           class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-200 hover:text-white border border-slate-700 font-bold text-sm p-4 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-5 h-5 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            Nueva Evolución
        </a>

        <a href="/pacientes/{{ $paciente->id }}/odontograma"
           class="inline-flex items-center justify-center gap-2 bg-purple-500/10 hover:bg-purple-500/20 text-purple-400 border border-purple-500/30 font-bold text-sm p-4 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
            </svg>
            Odontograma
        </a>

        <a href="/citas/create?paciente={{ $paciente->id }}"
           class="inline-flex items-center justify-center gap-2 bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 border border-blue-500/30 font-bold text-sm p-4 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            Nueva Cita
        </a>

        <a href="/facturas/create?paciente={{ $paciente->id }}"
           class="inline-flex items-center justify-center gap-2 bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 font-bold text-sm p-4 rounded-xl transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M12 16H11" />
            </svg>
            Nueva Factura
        </a>

    </div>

    {{-- TIMELINE HISTORIAL --}}
    <div class="bg-slate-800 border border-slate-700/80 shadow-2xl rounded-2xl overflow-hidden relative">

        <div class="p-6 border-b border-slate-700 bg-slate-800/50">
            <h2 class="text-xl font-bold text-white tracking-tight">
                Historial Clínico de Evolución
            </h2>
        </div>

        <div class="divide-y divide-slate-700/60">

            @forelse($historias as $historia)
                <div class="p-6 space-y-3 hover:bg-slate-700/20 transition-colors duration-150">

                    <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2">
                        <span class="font-mono font-bold text-teal-400 tracking-wide text-sm bg-slate-900/60 border border-slate-700/80 px-3 py-1.5 rounded-xl w-fit">
                            {{ \Carbon\Carbon::parse($historia->fecha)->format('d/m/Y') }}
                        </span>
                        <span class="text-xs font-bold uppercase tracking-widest text-slate-400 bg-slate-900/30 border border-slate-800 px-2.5 py-1 rounded-lg">
                            Atendido por: {{ $historia->odontologo }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                        <div>
                            <span class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-1">Motivo de Consulta</span>
                            <p class="text-sm font-medium text-slate-300 leading-relaxed">{{ $historia->motivo_consulta }}</p>
                        </div>

                        <div>
                            <span class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-1">Diagnóstico</span>
                            <p class="text-sm font-medium text-slate-300 leading-relaxed">{{ $historia->diagnostico }}</p>
                        </div>

                        <div>
                            <span class="block text-xs font-black uppercase tracking-widest text-slate-500 mb-1">Tratamiento</span>
                            <p class="text-sm font-medium text-slate-300 leading-relaxed">{{ $historia->tratamiento }}</p>
                        </div>
                    </div>

                    @if($historia->proximo_control)
                        <div class="pt-2">
                            <span class="inline-flex items-center gap-1 font-bold text-xs uppercase tracking-wider border bg-blue-950/30 border-blue-800/40 text-blue-300 px-3 py-1.5 rounded-lg">
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Próximo Control: {{ \Carbon\Carbon::parse($historia->proximo_control)->format('d/m/Y') }}
                            </span>
                        </div>
                    @endif

                </div>

            @empty

                <div class="p-12 text-center text-slate-500 font-medium">
                    Paciente sin atenciones clínicas registradas.
                </div>

            @endforelse

        </div>

    </div>

</div>

</x-app-layout>