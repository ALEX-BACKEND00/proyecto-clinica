@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<x-app-layout>

<div class="max-w-3xl mx-auto space-y-6">

    {{-- CABECERA --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('facturas.index') }}" class="inline-flex items-center justify-center w-10 h-10 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white border border-slate-700 rounded-xl transition-all duration-200 shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-black text-white tracking-tight">Editar <span class="text-teal-400">Factura</span></h1>
            <p class="text-slate-400 text-sm mt-1 font-medium">Actualiza los detalles del registro de facturación</p>
        </div>
    </div>

    {{-- FORMULARIO --}}
    <form action="{{ route('facturas.update', $factura) }}" method="POST" class="bg-slate-800/50 border border-slate-700 shadow-2xl rounded-2xl p-6 sm:p-8 space-y-6">
        @csrf
        @method('PUT')

        <div class="space-y-6">

            <div>
                <label class="block mb-2 font-bold text-sm text-slate-300">Paciente</label>
                <select name="paciente_id" required
                        class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                    @foreach($pacientes as $paciente)
                        <option value="{{ $paciente->id }}" {{ $factura->paciente_id == $paciente->id ? 'selected' : '' }}>
                            {{ $paciente->nombres }} {{ $paciente->apellidos }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-bold text-sm text-slate-300">Total</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-500 font-bold">
                            $
                        </div>
                        <input type="number" step="0.01" name="total" value="{{ $factura->total }}" required placeholder="0.00"
                               class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl pl-8 pr-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none font-mono">
                    </div>
                </div>

                <div>
                    <label class="block mb-2 font-bold text-sm text-slate-300">Estado</label>
                    <select name="estado" required
                            class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                        <option value="pendiente" {{ $factura->estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="pagada" {{ $factura->estado == 'pagada' ? 'selected' : '' }}>Pagada</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block mb-2 font-bold text-sm text-slate-300">Descripción</label>
                <textarea name="descripcion" rows="4" required
                          class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none resize-none"
                          placeholder="Modifica o complementa la descripción...">{{ $factura->descripcion }}</textarea>
            </div>

        </div>

        {{-- BOTÓN DE ACCIÓN --}}
        <div class="pt-4 flex justify-end border-t border-slate-700/60 mt-6">
            <button type="submit" 
                class="w-full sm:w-auto px-6 py-3.5 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white font-bold text-sm rounded-xl transition-all duration-300 shadow-lg shadow-teal-500/20 hover:shadow-cyan-500/30 hover:-translate-y-0.5">
                Actualizar Factura
            </button>
        </div>

    </form>

</div>

</x-app-layout>