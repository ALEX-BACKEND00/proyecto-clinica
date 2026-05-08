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
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-cyan-400">Facturación</span>
                @else
                    Mis <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-600 to-cyan-600">Facturas</span>
                @endif
            </h1>

            <p class="text-slate-400 mt-1 font-medium text-sm">
                {{ $isAdmin ? 'Gestión financiera de la clínica' : 'Consulta tus pagos y facturas odontológicas' }}
            </p>
        </div>

        @if($isAdmin)
            <a href="{{ route('facturas.create') }}"
               class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white font-bold text-sm px-6 py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-teal-500/20 hover:shadow-cyan-500/30 hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Nueva Factura
            </a>
        @endif

    </div>

    {{-- ALERTA --}}
    @if(session('success'))
        <div class="{{ $isAdmin ? 'bg-emerald-950/40 border-emerald-800/60 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700' }} border px-5 py-4 rounded-xl flex items-center gap-3 backdrop-blur-sm animate-fade-in">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    {{-- TABLA --}}
    <div class="{{ $isAdmin ? 'bg-slate-800 border-slate-700/80 shadow-2xl' : 'bg-white border-slate-200 shadow-sm' }} border rounded-2xl overflow-hidden relative">

        <div class="p-6 border-b {{ $isAdmin ? 'border-slate-700 bg-slate-800/50' : 'border-slate-100 bg-white' }}">
            <h2 class="text-xl font-bold {{ $isAdmin ? 'text-white' : 'text-slate-800' }} tracking-tight">
                {{ $isAdmin ? 'Listado de Facturas' : 'Mis Facturas Pendientes y Pagadas' }}
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse">

                <thead class="{{ $isAdmin ? 'bg-slate-900/50 text-slate-400 border-slate-700' : 'bg-slate-50 text-slate-500 border-slate-200' }} text-xs font-black uppercase tracking-widest border-b">
                    <tr>
                        <th class="p-4">
                            {{ $isAdmin ? 'Paciente' : 'Servicio' }}
                        </th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Fecha</th>
                        @if($isAdmin)
                            <th class="p-4 text-center">Acciones</th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y {{ $isAdmin ? 'divide-slate-700/60 text-slate-300' : 'divide-slate-100 text-slate-700' }} text-sm">

                    @forelse($facturas as $factura)
                        <tr class="hover:bg-slate-700/20 transition-colors duration-150">

                            <td class="p-4 font-bold {{ $isAdmin ? 'text-white' : 'text-slate-900' }}">
                                @if($isAdmin)
                                    {{ $factura->paciente->nombres }}
                                    {{ $factura->paciente->apellidos }}
                                @else
                                    Atención Odontológica
                                @endif
                            </td>

                            <td class="font-mono font-semibold {{ $isAdmin ? 'text-emerald-400' : 'text-emerald-600' }}">
    {{ $factura->total_formateado }}
</td>

                            <td>
                                @if($factura->estado == 'pagada')
                                    <span class="inline-flex items-center gap-1 font-bold text-xs uppercase tracking-wider border {{ $isAdmin ? 'bg-emerald-950/40 border-emerald-800/60 text-emerald-300' : 'bg-emerald-50 border-emerald-200 text-emerald-700' }} px-3 py-1.5 rounded-lg">
                                        Pagada
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 font-bold text-xs uppercase tracking-wider border {{ $isAdmin ? 'bg-amber-950/40 border-amber-800/60 text-amber-300' : 'bg-amber-50 border-amber-200 text-amber-700' }} px-3 py-1.5 rounded-lg">
                                        Pendiente
                                    </span>
                                @endif
                            </td>

                            <td class="font-mono text-slate-400">
                                {{ $factura->created_at->format('Y-m-d') }}
                            </td>

                            @if($isAdmin)
                                <td class="p-4">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        @if($factura->estado === 'pendiente')
                                            <a href="{{ route('facturas.edit', $factura) }}"
                                               class="inline-flex items-center bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 border border-blue-500/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-200">
                                                Editar
                                            </a>
                                        @endif

                                        @if($factura->estado === 'pendiente')
                                            <form action="{{ route('facturas.destroy', $factura) }}" method="POST" onsubmit="return confirm('¿Desea eliminar esta factura?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="inline-flex items-center bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-200">
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
                                No hay facturas registradas.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-4">
        {{ $facturas->links() }}
    </div>

</div>

</x-app-layout>