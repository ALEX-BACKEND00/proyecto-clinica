@php
    $esAdmin = auth()->user()->role === 'admin';
    $themeClass = $esAdmin ? 'theme-dark' : 'theme-light';

    $arcada_superior = ['18','17','16','15','14','13','12','11','21','22','23','24','25','26','27','28'];
    $arcada_inferior = ['48','47','46','45','44','43','42','41','31','32','33','34','35','36','37','38'];
@endphp

<x-app-layout>

<div class="space-y-8 {{ $themeClass }}">

    {{-- CABECERA --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl sm:text-4xl font-black {{ $esAdmin ? 'text-white' : 'text-slate-900' }} tracking-tight">
                @if($esAdmin)
                    Odontograma <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-cyan-400">Clínico</span>
                @else
                    Mi <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-cyan-600">Odontograma</span>
                @endif
            </h1>

            <p class="text-slate-400 mt-1 font-medium text-sm">
                Paciente: <span class="font-bold {{ $esAdmin ? 'text-slate-200' : 'text-slate-800' }}">{{ $paciente->nombres }} {{ $paciente->apellidos }}</span>
            </p>
        </div>

        @if($esAdmin)
            <a href="{{ route('pacientes.index') }}" class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white border border-slate-700 font-bold text-sm px-5 py-3 rounded-xl transition-all duration-200 shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Volver a Pacientes
            </a>
        @endif
    </div>

    {{-- ALERTA --}}
    @if(session('success'))
        <div class="{{ $esAdmin ? 'bg-emerald-950/40 border-emerald-800/60 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700' }} border px-5 py-4 rounded-xl flex items-center gap-3 backdrop-blur-sm animate-fade-in">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    <form method="POST" action="{{ route('odontograma.guardar') }}" class="space-y-6">
        @csrf

        <input type="hidden" name="paciente_id" value="{{ $paciente->id }}">

        {{-- LEYENDA --}}
        <div class="{{ $esAdmin ? 'bg-slate-800/50 border-slate-700/80 shadow-xl' : 'bg-white border-slate-200 shadow-sm' }} border rounded-2xl p-6">
            <h2 class="text-xs font-black uppercase tracking-widest {{ $esAdmin ? 'text-slate-400' : 'text-slate-500' }} mb-4">Leyenda Clínica</h2>

            <div class="flex flex-wrap gap-3 text-sm">
                {{-- SANO DESTACADO --}}
                <span class="inline-flex items-center gap-2 font-bold text-xs uppercase tracking-wider border bg-pearl-sano border-slate-300 text-slate-800 px-3 py-1.5 rounded-lg shadow-inner-sano">
                    <span class="w-2 h-2 rounded-full bg-white shadow-pearl-light"></span>
                    Sano
                </span>
                <span class="inline-flex items-center gap-1 font-bold text-xs uppercase tracking-wider border {{ $esAdmin ? 'bg-rose-950/40 border-rose-800/60 text-rose-300' : 'bg-rose-50 border-rose-200 text-rose-700' }} px-3 py-1.5 rounded-lg">
                    Caries
                </span>
                <span class="inline-flex items-center gap-1 font-bold text-xs uppercase tracking-wider border {{ $esAdmin ? 'bg-blue-950/40 border-blue-800/60 text-blue-300' : 'bg-blue-50 border-blue-200 text-blue-700' }} px-3 py-1.5 rounded-lg">
                    Restaurado
                </span>
                <span class="inline-flex items-center gap-1 font-bold text-xs uppercase tracking-wider border {{ $esAdmin ? 'bg-slate-700/40 border-slate-600/40 text-slate-500' : 'bg-slate-100 border-slate-300 text-slate-400' }} px-3 py-1.5 rounded-lg">
                    Ausente
                </span>
            </div>
        </div>

        {{-- ODONTOGRAMA --}}
        <div class="{{ $esAdmin ? 'bg-slate-800/50 border-slate-700/80 shadow-xl' : 'bg-white border-slate-200 shadow-sm' }} border rounded-2xl p-6 sm:p-8 space-y-8">

            {{-- SUPERIOR --}}
            <div>
                <h2 class="text-sm font-black uppercase tracking-widest {{ $esAdmin ? 'text-slate-400' : 'text-slate-500' }} mb-4">Arcada Superior</h2>

                <div class="grid grid-cols-8 md:grid-cols-16 gap-2">
                    @foreach($arcada_superior as $diente)
                        @php $estado = $estados[$diente] ?? 'sano'; @endphp

                        <div class="diente {{ $estado }} border rounded-xl p-3 text-center {{ $esAdmin ? 'cursor-pointer hover:scale-105' : '' }} transition-all duration-200">
                            <p class="font-mono font-black text-sm">{{ $diente }}</p>
                            <input type="hidden" name="dientes[{{ $diente }}]" value="{{ $estado }}">
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- DIVISOR --}}
            <div class="h-px w-full {{ $esAdmin ? 'bg-slate-700' : 'bg-slate-100' }}"></div>

            {{-- INFERIOR --}}
            <div>
                <h2 class="text-sm font-black uppercase tracking-widest {{ $esAdmin ? 'text-slate-400' : 'text-slate-500' }} mb-4">Arcada Inferior</h2>

                <div class="grid grid-cols-8 md:grid-cols-16 gap-2">
                    @foreach($arcada_inferior as $diente)
                        @php $estado = $estados[$diente] ?? 'sano'; @endphp

                        <div class="diente {{ $estado }} border rounded-xl p-3 text-center {{ $esAdmin ? 'cursor-pointer hover:scale-105' : '' }} transition-all duration-200">
                            <p class="font-mono font-black text-sm">{{ $diente }}</p>
                            <input type="hidden" name="dientes[{{ $diente }}]" value="{{ $estado }}">
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        @if($esAdmin)
            <div class="pt-4 flex justify-end">
                <button class="w-full sm:w-auto px-6 py-3.5 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white font-bold text-sm rounded-xl transition-all duration-300 shadow-lg shadow-teal-500/20 hover:shadow-cyan-500/30 hover:-translate-y-0.5">
                    Guardar Odontograma
                </button>
            </div>
        @endif

    </form>

</div>

{{-- ESTILOS EXACTOS BI-TONAL PARA DIENTES CON AJUSTE EN 'SANO' --}}
<style>
    /* Definición Global de colores y sombras para SANO */
    :root {
        --bg-sano-pearl: #fdfdfd; /* Blanco perla casi puro */
        --border-sano-pearl: #d1d5db; /* border-slate-300 */
        --shadow-sano-inner: inset 0 2px 4px rgba(255,255,255,1), inset 0 -2px 4px rgba(0,0,0,0.05), 0 2px 4px rgba(0,0,0,0.1);
        --shadow-sano-pearl: 0 0 10px 2px rgba(255,255,255,0.8);
    }

    .bg-pearl-sano { background-color: var(--bg-sano-pearl) !important; }
    .shadow-inner-sano { box-shadow: var(--shadow-sano-inner) !important; }
    .shadow-pearl-light { box-shadow: var(--shadow-sano-pearl) !important; }

    /* Estilo Base Universal para Diente Sano */
    .diente.sano {
        background-color: var(--bg-sano-pearl) !important;
        border-color: var(--border-sano-pearl) !important;
        color: #1e293b !important; /* text-slate-800 para legibilidad */
        box-shadow: var(--shadow-sano-inner) !important;
    }

    /* 1. MODO OSCURO (Admin) - Otros estados */
    .theme-dark .diente.caries {
        background-color: rgba(244, 63, 94, 0.2);
        border-color: rgba(244, 63, 94, 0.4);
        color: #f43f5e;
    }
    .theme-dark .diente.restaurado {
        background-color: rgba(59, 130, 246, 0.2);
        border-color: rgba(59, 130, 246, 0.4);
        color: #3b82f6;
    }
    .theme-dark .diente.ausente {
        background-color: rgba(100, 116, 139, 0.2);
        border-color: rgba(100, 116, 139, 0.3);
        color: #475569;
    }

    /* 2. MODO CLARO (Paciente) - Otros estados */
    .theme-light .diente.caries {
        background-color: #fff1f2;
        border-color: #fecdd3;
        color: #be123c;
    }
    .theme-light .diente.restaurado {
        background-color: #eff6ff;
        border-color: #bfdbfe;
        color: #1d4ed8;
    }
    .theme-light .diente.ausente {
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: #94a3b8;
    }
</style>

@if($esAdmin)
<script>
    document.querySelectorAll('.diente').forEach(diente => {
        const estados = ['sano', 'caries', 'restaurado', 'ausente'];

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