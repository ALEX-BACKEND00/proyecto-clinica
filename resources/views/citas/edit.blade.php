@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<x-app-layout>

<div class="max-w-3xl mx-auto space-y-6">

    {{-- CABECERA --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('citas.index') }}" class="inline-flex items-center justify-center w-10 h-10 {{ $isAdmin ? 'bg-slate-800 hover:bg-slate-700 text-slate-400 border-slate-700' : 'bg-white hover:bg-slate-50 text-slate-500 border-slate-200' }} hover:text-teal-500 border rounded-xl transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-black {{ $isAdmin ? 'text-white' : 'text-slate-900' }} tracking-tight">
                Editar <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-500 to-cyan-500">Cita</span>
            </h1>
            <p class="text-slate-400 text-sm mt-1 font-medium">Modifica la información de la cita programada</p>
        </div>
    </div>

    {{-- FORMULARIO --}}
    <form action="{{ route('citas.update', $cita) }}" method="POST"
          class="{{ $isAdmin ? 'bg-slate-800/50 border-slate-700/80 shadow-xl' : 'bg-white border-slate-200/80 shadow-sm' }} border rounded-2xl p-6 sm:p-8 space-y-6">

        @csrf
        @method('PUT')

        <div class="space-y-6">

            {{-- PACIENTE --}}
<div>
    <label class="block mb-2 font-bold text-sm {{ $isAdmin ? 'text-slate-200' : 'text-slate-800' }}">
        Paciente
    </label>

    <input
        type="hidden"
        name="paciente_id"
        value="{{ $cita->paciente_id }}"
    >

    <div class="w-full
        {{ $isAdmin
            ? 'bg-slate-900 border-slate-700 text-slate-300'
            : 'bg-slate-100 border-slate-200 text-slate-700'
        }}
        border text-sm font-semibold rounded-xl px-4 py-3.5">

        {{ $cita->paciente->nombres }}
        {{ $cita->paciente->apellidos }}

    </div>

</div>

            {{-- FECHA Y HORA --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-bold text-sm {{ $isAdmin ? 'text-slate-200' : 'text-slate-800' }}">Fecha</label>
                    <input type="date" name="fecha" value="{{ $cita->fecha }}" required
                           class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100' : 'bg-white border-slate-200 text-slate-900' }} border text-sm rounded-xl px-4 py-3.5 focus:ring-4 transition-all outline-none">
                </div>

                <div>
                    <label class="block mb-2 font-bold text-sm {{ $isAdmin ? 'text-slate-200' : 'text-slate-800' }}">Hora</label>
                    <input type="time" name="hora" value="{{ $cita->hora }}" required
                           class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100' : 'bg-white border-slate-200 text-slate-900' }} border text-sm rounded-xl px-4 py-3.5 focus:ring-4 transition-all outline-none">
                </div>
            </div>

            {{-- ESTADO --}}
            <div>
                <label class="block mb-2 font-bold text-sm {{ $isAdmin ? 'text-slate-200' : 'text-slate-800' }}">Estado de la Cita</label>

                @if($cita->estado === 'completada' && $cita->edicion_post_completada == 1)
                    <div class="relative">
                        <input type="text" value="Completada" disabled
                               class="w-full {{ $isAdmin ? 'bg-slate-950 border-slate-800 text-slate-500' : 'bg-slate-50 border-slate-200 text-slate-500' }} border text-sm rounded-xl px-4 py-3.5">
                        <input type="hidden" name="estado" value="completada">
                        <span class="absolute right-4 top-3.5 text-xs font-bold text-slate-500 uppercase">Bloqueado</span>
                    </div>
                @else
                    <select name="estado" required
                            class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100 focus:ring-teal-400/10 focus:border-teal-400' : 'bg-white border-slate-200 text-slate-900 focus:ring-teal-500/10 focus:border-teal-500' }} border text-sm rounded-xl px-4 py-3.5 focus:ring-4 transition-all outline-none">
                        <option value="pendiente" {{ $cita->estado=='pendiente'?'selected':'' }}>Pendiente</option>
                        <option value="confirmada" {{ $cita->estado=='confirmada'?'selected':'' }}>Confirmada</option>
                        <option value="completada" {{ $cita->estado=='completada'?'selected':'' }}>Completada</option>
                        <option value="cancelada" {{ $cita->estado=='cancelada'?'selected':'' }}>Cancelada</option>
                    </select>
                @endif
            </div>

            {{-- MOTIVO --}}
            <div>
                <label class="block mb-2 font-bold text-sm {{ $isAdmin ? 'text-slate-200' : 'text-slate-800' }}">Motivo de la Consulta</label>
                <textarea name="motivo" rows="4" required
                          class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100' : 'bg-white border-slate-200 text-slate-900' }} border text-sm rounded-xl px-4 py-3.5 focus:ring-4 transition-all outline-none resize-none">{{ $cita->motivo }}</textarea>
            </div>

        </div>

        {{-- BOTÓN DE ACCIÓN --}}
        <div class="pt-4 flex justify-end border-t {{ $isAdmin ? 'border-slate-700/60' : 'border-slate-100' }} mt-6">
            <button type="submit" 
                class="w-full sm:w-auto px-8 py-3.5 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white font-bold text-sm rounded-xl transition-all duration-300 shadow-lg hover:-translate-y-0.5">
                Actualizar Cita
            </button>
        </div>

    </form>

</div>

</x-app-layout>