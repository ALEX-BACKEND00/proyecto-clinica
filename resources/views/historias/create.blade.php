@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<x-app-layout>

<div class="max-w-5xl mx-auto space-y-6">

    {{-- CABECERA --}}
    <div class="flex items-center gap-4">
        <a href="{{ url()->previous() }}" class="inline-flex items-center justify-center w-10 h-10 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white border border-slate-700 rounded-xl transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Nueva <span class="text-teal-400">Evolución Clínica</span></h1>
            <p class="text-slate-400 text-sm mt-1 font-medium">Registro de atención odontológica del paciente</p>
        </div>
    </div>

    {{-- FORMULARIO --}}
    <form action="{{ route('historias.store') }}" method="POST" 
          class="bg-slate-800/50 border border-slate-700 shadow-2xl rounded-2xl p-6 sm:p-8 space-y-8">
        @csrf

        {{-- BLOQUE 1 --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            <div>
                <label class="block font-bold text-slate-300 mb-2 text-sm">Paciente</label>
                <select name="paciente_id" required
                        class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}" {{ ($paciente_id == $paciente->id) ? 'selected' : '' }}>
                            {{ $paciente->nombres }} {{ $paciente->apellidos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-2 text-sm">Fecha</label>
                <input type="date" name="fecha" value="{{ $fecha }}" required
                       class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-2 text-sm">Odontólogo</label>
                <input type="text" name="odontologo" placeholder="Dr. Nombre" required
                       class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
            </div>

        </div>

        {{-- BLOQUE 2 --}}
        <div class="space-y-6">

            <div>
                <label class="block font-bold text-slate-300 mb-2 text-sm">Motivo de Consulta</label>
                <textarea name="motivo_consulta" rows="3" required placeholder="Describe el motivo de la consulta..."
                          class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none resize-none"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-2 text-sm">Diagnóstico</label>
                <textarea name="diagnostico" rows="3" required placeholder="Escribe el diagnóstico clínico..."
                          class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none resize-none"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-2 text-sm">Tratamiento Realizado</label>
                <textarea name="tratamiento" rows="4" required placeholder="Describe detalladamente el tratamiento efectuado..."
                          class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none resize-none"></textarea>
            </div>

            <div>
                <label class="block font-bold text-slate-300 mb-2 text-sm">Observaciones</label>
                <textarea name="observaciones" rows="3" placeholder="Añade notas u observaciones adicionales..."
                          class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none resize-none"></textarea>
            </div>

        </div>

        {{-- BLOQUE 3 --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center pt-4 border-t border-slate-700/60">

            <div>
                <label class="block font-bold text-slate-300 mb-2 text-sm">Próximo Control</label>
                <input type="date" name="proximo_control"
                       class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
            </div>

            <div class="flex items-end h-full">
                <p class="text-sm text-slate-400 bg-slate-900/40 p-4 border border-slate-800 rounded-xl leading-relaxed">
                    <strong class="text-teal-400">Nota:</strong> Puedes generar citas o facturas directamente desde la ficha clínica más adelante.
                </p>
            </div>

        </div>

        {{-- BOTONES --}}
        <div class="pt-4 flex flex-col sm:flex-row justify-end gap-3 border-t border-slate-700/60 mt-6">
            <a href="{{ url()->previous() }}"
               class="w-full sm:w-auto px-6 py-3.5 bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white font-bold text-sm rounded-xl border border-slate-700 text-center transition-all duration-200">
                Cancelar
            </a>
            
            <button type="submit" 
                class="w-full sm:w-auto px-6 py-3.5 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white font-bold text-sm rounded-xl transition-all duration-300 shadow-lg shadow-teal-500/20 hover:shadow-cyan-500/30 hover:-translate-y-0.5">
                Guardar Evolución
            </button>
        </div>

    </form>

</div>

</x-app-layout>