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
                {{ $isAdmin ? 'Nueva' : 'Solicitar' }} <span class="text-teal-500">Cita</span>
            </h1>
            <p class="text-slate-400 text-sm mt-1 font-medium">Completa el formulario para reservar una cita</p>
        </div>
    </div>

    {{-- FORMULARIO --}}
    <form action="{{ route('citas.store') }}" method="POST" 
          class="{{ $isAdmin ? 'bg-slate-800/50 border-slate-700 shadow-2xl' : 'bg-white border-slate-100 shadow-sm' }} border rounded-2xl p-6 sm:p-8 space-y-6">

        @csrf

        <div class="space-y-6">

            <div>
                <label class="block mb-2 font-bold text-sm {{ $isAdmin ? 'text-slate-300' : 'text-slate-700' }}">Paciente</label>

                @if($isAdmin)

    <input
        type="hidden"
        name="paciente_id"
        id="paciente_id"
        value="{{ $paciente_id }}"
    >

    <input
        type="text"
        id="buscarPaciente"
        placeholder="Escriba nombre del paciente..."
        autocomplete="off"
        class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 outline-none"
    >

    <div
        id="listaPacientes"
        class="mt-2 bg-slate-900 border border-slate-700 rounded-xl hidden max-h-60 overflow-y-auto"
    >

        @foreach($pacientes as $paciente)

            <div
                class="paciente-item px-4 py-3 cursor-pointer hover:bg-slate-800 text-slate-200"
                data-id="{{ $paciente->id }}"
                data-nombre="{{ $paciente->nombres }} {{ $paciente->apellidos }}"
            >
                {{ $paciente->nombres }} {{ $paciente->apellidos }}
            </div>

        @endforeach

    </div>

@else

    <input type="hidden" name="paciente_id" value="{{ $pacientes->first()->id }}">

    <div class="w-full bg-slate-100 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl px-4 py-3.5">
        {{ $pacientes->first()->nombres }} {{ $pacientes->first()->apellidos }}
    </div>

@endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 font-bold text-sm {{ $isAdmin ? 'text-slate-300' : 'text-slate-700' }}">Fecha</label>
                    <input type="date" name="fecha" value="{{ $fecha }}" required
                           class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100' : 'bg-white border-slate-200 text-slate-900' }} border text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                </div>

                <div>
                    <label class="block mb-2 font-bold text-sm {{ $isAdmin ? 'text-slate-300' : 'text-slate-700' }}">Hora</label>
                    <input type="time" name="hora" required
                           class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100' : 'bg-white border-slate-200 text-slate-900' }} border text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                </div>
            </div>

            <div>
                <label class="block mb-2 font-bold text-sm {{ $isAdmin ? 'text-slate-300' : 'text-slate-700' }}">Motivo de la Consulta</label>
                <textarea name="motivo" rows="4" required
                          class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100' : 'bg-white border-slate-200 text-slate-900' }} border text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none resize-none"
                          placeholder="Describe brevemente el motivo..."></textarea>
            </div>

        </div>

        {{-- BOTON DE ACCIÓN --}}
        <div class="pt-4 flex justify-end border-t {{ $isAdmin ? 'border-slate-700/60' : 'border-slate-100' }} mt-6">
            <button type="submit" 
                class="w-full sm:w-auto px-6 py-3.5 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white font-bold text-sm rounded-xl transition-all duration-300 shadow-lg shadow-teal-500/20 hover:shadow-cyan-500/30 hover:-translate-y-0.5">
                Guardar Cita
            </button>
        </div>

    </form>

</div>
<script>
document.addEventListener('DOMContentLoaded', function(){

    const input = document.getElementById('buscarPaciente');
    const hidden = document.getElementById('paciente_id');
    const lista = document.getElementById('listaPacientes');

    if(!input) return;

    const items = document.querySelectorAll('.paciente-item');

    input.addEventListener('focus', function(){
        lista.classList.remove('hidden');
    });

    input.addEventListener('keyup', function(){

        const texto = this.value.toLowerCase();

        lista.classList.remove('hidden');

        items.forEach(item => {

            const nombre = item.dataset.nombre.toLowerCase();

            if(nombre.includes(texto)){
                item.style.display = 'block';
            }else{
                item.style.display = 'none';
            }

        });

    });

    items.forEach(item => {

        item.addEventListener('click', function(){

            input.value = this.dataset.nombre;

            hidden.value = this.dataset.id;

            lista.classList.add('hidden');

        });

    });

});
</script>
</x-app-layout>