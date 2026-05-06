<x-app-layout>

<div class="space-y-8">

    {{-- CABECERA --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl sm:text-4xl font-black text-white tracking-tight">
                Gestión de <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-400 to-cyan-400">Pacientes</span>
            </h1>
            <p class="text-slate-400 mt-1 font-medium text-sm">
                Administración general de pacientes registrados
            </p>
        </div>

        <a href="{{ route('pacientes.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white font-bold text-sm px-6 py-3.5 rounded-xl transition-all duration-300 shadow-lg shadow-teal-500/20 hover:shadow-cyan-500/30 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Paciente
        </a>
    </div>

    {{-- ALERTA --}}
    @if(session('success'))
        <div class="bg-emerald-950/40 border border-emerald-800/60 text-emerald-300 px-5 py-4 rounded-xl flex items-center gap-3 backdrop-blur-sm">
            <svg class="w-5 h-5 flex-shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-semibold">{{ session('success') }}</span>
        </div>
    @endif

    {{-- FILTRO --}}
    <div class="bg-slate-800/50 border border-slate-700/80 rounded-2xl p-6 shadow-xl">
        <form method="GET" action="{{ route('pacientes.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
            
            <div class="md:col-span-2 relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text"
                       name="buscar"
                       value="{{ $buscar ?? '' }}"
                       placeholder="Buscar por nombre, apellido o documento..."
                       class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl pl-11 pr-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
            </div>

            <button type="submit"
                    class="w-full bg-slate-700 hover:bg-slate-600 text-white font-bold text-sm rounded-xl px-6 py-3.5 border border-slate-600 transition-colors duration-200">
                Buscar
            </button>

            <a href="{{ route('pacientes.index') }}"
               class="w-full bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-slate-200 font-bold text-sm rounded-xl px-6 py-3.5 border border-slate-700/80 text-center transition-colors duration-200">
                Limpiar
            </a>

        </form>
    </div>

    {{-- TABLA --}}
    <div class="bg-slate-800 border border-slate-700/80 shadow-2xl rounded-2xl overflow-hidden relative">

        <div class="p-6 border-b border-slate-700 bg-slate-800/50">
            <h2 class="text-xl font-bold text-white tracking-tight">
                Listado de Pacientes
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-900/50 text-slate-400 text-xs font-black uppercase tracking-widest border-b border-slate-700">
                    <tr>
                        <th class="p-4">Paciente</th>
                        <th>Documento</th>
                        <th>Teléfono</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-700/60 text-sm text-slate-300">
                    @forelse($pacientes as $paciente)
                        <tr class="hover:bg-slate-700/30 transition-colors duration-150">
                            <td class="p-4">
                                <div class="font-bold text-white">
                                    {{ $paciente->nombres }} {{ $paciente->apellidos }}
                                </div>
                                <div class="text-xs text-slate-400 mt-0.5">
                                    {{ $paciente->email }}
                                </div>
                            </td>

                            <td class="font-mono text-slate-400 tracking-wide">
                                {{ $paciente->documento }}
                            </td>

                            <td class="text-slate-400">
                                {{ $paciente->telefono }}
                            </td>

                            <td class="p-4">
                                <div class="flex flex-wrap items-center justify-center gap-2">
                                    <a href="{{ route('pacientes.edit', $paciente->id) }}"
                                       class="inline-flex items-center bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 border border-blue-500/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-200">
                                        Editar
                                    </a>

                                    <a href="{{ route('pacientes.odontograma', $paciente->id) }}"
                                       class="inline-flex items-center bg-purple-500/10 hover:bg-purple-500/20 text-purple-400 border border-purple-500/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-200 relative z-10">
                                        Odontograma
                                    </a>

                                    <a href="{{ route('pacientes.historia', $paciente->id) }}"
                                       class="inline-flex items-center bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-200">
                                        Ficha
                                    </a>

                                    <form action="{{ route('pacientes.destroy', $paciente->id) }}"
                                          method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('¿Desea eliminar este paciente permanentemente?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wider transition-all duration-200">
                                            Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center text-slate-500 font-medium">
                                No hay pacientes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-4">
        {{ $pacientes->links() }}
    </div>

</div>

</x-app-layout>