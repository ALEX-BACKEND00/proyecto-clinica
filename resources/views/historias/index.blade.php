@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<x-app-layout>
    <div class="space-y-8">

        {{-- Encabezado --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-3xl sm:text-4xl font-black {{ $isAdmin ? 'text-white' : 'text-slate-900' }} tracking-tight">
                    @if($isAdmin)
                        Historia <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-cyan-400">Clínica</span>
                    @else
                        Mi Historia <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-cyan-600">Clínica</span>
                    @endif
                </h1>

                <p class="text-slate-400 mt-1 font-medium text-sm">
                    Consulta los registros odontológicos y evolución clínica del paciente
                </p>
            </div>
        </div>

        {{-- Alertas --}}
        @if(session('error'))
            <div class="bg-rose-950/40 border border-rose-800/60 text-rose-300 px-5 py-4 rounded-xl flex items-center gap-3 backdrop-blur-sm animate-fade-in">
                <svg class="w-5 h-5 flex-shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        @if(session('success'))
            <div class="{{ $isAdmin ? 'bg-emerald-950/40 border-emerald-800/60 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700' }} border px-5 py-4 rounded-xl flex items-center gap-3 backdrop-blur-sm animate-fade-in">
                <svg class="w-5 h-5 flex-shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-sm font-semibold">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Resumen (Cards) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <div class="{{ $isAdmin ? 'bg-slate-800/50 border-slate-700/80 shadow-xl' : 'bg-white border-slate-100 shadow-sm' }} border rounded-2xl p-6 flex flex-col justify-between h-full">
                <p class="text-xs font-black uppercase tracking-widest {{ $isAdmin ? 'text-slate-400' : 'text-slate-500' }}">Total Registros</p>
                <p class="text-3xl font-black {{ $isAdmin ? 'text-white' : 'text-slate-900' }} mt-2">
                    {{ $historias->total() }}
                </p>
            </div>

            <div class="{{ $isAdmin ? 'bg-slate-800/50 border-slate-700/80 shadow-xl' : 'bg-white border-slate-100 shadow-sm' }} border rounded-2xl p-6 flex flex-col justify-between h-full">
                <p class="text-xs font-black uppercase tracking-widest {{ $isAdmin ? 'text-slate-400' : 'text-slate-500' }}">Última Atención</p>
                <p class="text-lg font-bold {{ $isAdmin ? 'text-teal-400' : 'text-teal-600' }} mt-2">
                    @if($historias->count())
                        {{ \Carbon\Carbon::parse($historias->first()->fecha)->format('d/m/Y') }}
                    @else
                        Sin registros
                    @endif
                </p>
            </div>

            <div class="{{ $isAdmin ? 'bg-slate-800/50 border-slate-700/80 shadow-xl' : 'bg-white border-slate-100 shadow-sm' }} border rounded-2xl p-6 flex flex-col justify-between h-full">
                <p class="text-xs font-black uppercase tracking-widest {{ $isAdmin ? 'text-slate-400' : 'text-slate-500' }}">Paciente</p>
                <p class="text-lg font-bold {{ $isAdmin ? 'text-white' : 'text-slate-900' }} mt-2">
                    {{ $paciente->nombres }} {{ $paciente->apellidos }}
                </p>
            </div>

        </div>

        {{-- Tabla --}}
        <div class="{{ $isAdmin ? 'bg-slate-800 border-slate-700/80 shadow-2xl' : 'bg-white border-slate-200 shadow-sm' }} border rounded-2xl overflow-hidden relative">

            <div class="p-6 border-b {{ $isAdmin ? 'border-slate-700 bg-slate-800/50' : 'border-slate-100 bg-white' }}">
                <h2 class="text-xl font-bold {{ $isAdmin ? 'text-white' : 'text-slate-800' }} tracking-tight">
                    Historial de Consultas
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">

                    <thead class="{{ $isAdmin ? 'bg-slate-900/50 text-slate-400 border-slate-700' : 'bg-slate-50 text-slate-500 border-slate-200' }} text-xs font-black uppercase tracking-widest border-b">
                        <tr>
                            <th class="p-4">Fecha</th>
                            <th class="p-4">Odontólogo</th>
                            <th class="p-4">Motivo</th>
                            <th class="p-4">Diagnóstico</th>
                            <th class="p-4">Tratamiento</th>
                            <th class="p-4">Próximo Control</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y {{ $isAdmin ? 'divide-slate-700/60 text-slate-300' : 'divide-slate-100 text-slate-700' }} text-sm">

                        @forelse($historias as $historia)
                            <tr class="hover:bg-slate-700/20 transition-colors duration-150">

                                <td class="p-4 font-mono font-bold tracking-wide {{ $isAdmin ? 'text-white' : 'text-slate-900' }}">
                                    {{ \Carbon\Carbon::parse($historia->fecha)->format('d/m/Y') }}
                                </td>

                                <td class="p-4 font-medium">
                                    {{ $historia->odontologo ?? 'No registrado' }}
                                </td>

                                <td class="p-4 leading-relaxed">
                                    {{ $historia->motivo_consulta }}
                                </td>

                                <td class="p-4 leading-relaxed">
                                    {{ $historia->diagnostico }}
                                </td>

                                <td class="p-4 leading-relaxed">
                                    {{ $historia->tratamiento }}
                                </td>

                                <td class="p-4 font-mono font-bold tracking-wide">
                                    @if($historia->proximo_control)
                                        {{ \Carbon\Carbon::parse($historia->proximo_control)->format('d/m/Y') }}
                                    @else
                                        —
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-12 text-center text-slate-500 font-medium">
                                    No tienes registros clínicos disponibles.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

        {{-- Paginación --}}
        <div class="mt-4">
            {{ $historias->links() }}
        </div>

    </div>
</x-app-layout>