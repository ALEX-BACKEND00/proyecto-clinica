<x-app-layout>

    <div class="max-w-4xl mx-auto space-y-6">

        {{-- CABECERA --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('pacientes.index') }}"
                class="inline-flex items-center justify-center w-10 h-10 bg-slate-800 hover:bg-slate-700 text-slate-400 hover:text-white border border-slate-700 rounded-xl transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-black text-white tracking-tight">Nuevo <span
                        class="text-teal-400">Paciente</span></h1>
                <p class="text-slate-400 text-sm mt-1 font-medium">Crea un registro para un nuevo paciente</p>
            </div>
        </div>

        {{-- FORMULARIO --}}
        <form action="{{ route('pacientes.store') }}" method="POST"
            class="bg-slate-800/50 border border-slate-700 shadow-2xl rounded-2xl p-6 sm:p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- NOMBRES --}}
                <div>
                    <label class="block font-bold text-slate-300 mb-2 text-sm">Nombres</label>
                    <input type="text" name="nombres" value="{{ old('nombres') }}" autocomplete="off" required
                        minlength="2" maxlength="60" spellcheck="false" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s'-]+$"
                        oninput="this.value=this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñÜü\s'-]/g,'')"
                        title="Ingrese nombres válidos. Solo letras."
                        class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                    @error('nombres')
                        <p class="mt-2 text-sm text-red-400 font-medium">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- APELLIDOS --}}
                <div>
                    <label class="block font-bold text-slate-300 mb-2 text-sm">Apellidos</label>
                    <input type="text" name="apellidos" value="{{ old('apellidos') }}" autocomplete="off" required
                        minlength="2" maxlength="60" spellcheck="false" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñÜü\s'-]+$"
                        oninput="this.value=this.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúÑñÜü\s'-]/g,'')"
                        title="Ingrese apellidos válidos. Solo letras."
                        class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                    @error('apellidos')
                        <p class="mt-2 text-sm text-red-400 font-medium">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- IDENTIFICACIÓN --}}
                <div>
                    <label class="block font-bold text-slate-300 mb-2 text-sm">Documento</label>
                    <input type="text" name="documento" value="{{ old('documento') }}" autocomplete="off" required
                        inputmode="numeric" minlength="6" maxlength="11" pattern="[0-9]{6,11}"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                        title="Ingrese un número de identificación válido entre 6 y 11 dígitos."
                        class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                    @error('documento')
                        <p class="mt-2 text-sm text-red-400 font-medium">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- TELÉFONO COLOMBIA --}}
                <div>
                    <label class="block font-bold text-slate-300 mb-2 text-sm">Teléfono</label>
                    <input type="text" name="telefono" value="{{ old('telefono') }}" autocomplete="off" required
                        inputmode="numeric" minlength="10" maxlength="10" pattern="3[0-9]{9}"
                        oninput="this.value=this.value.replace(/[^0-9]/g,'')"
                        title="Ingrese un celular colombiano válido de 10 dígitos."
                        class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                    @error('telefono')
                        <p class="mt-2 text-sm text-red-400 font-medium">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- EMAIL --}}
                <div>
                    <label class="block font-bold text-slate-300 mb-2 text-sm">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" autocomplete="off" maxlength="120"
                        title="Ingrese un correo electrónico válido."
                        class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                    @error('email')
                        <p class="mt-2 text-sm text-red-400 font-medium">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- FECHA NACIMIENTO --}}
                <div>
                    <label class="block font-bold text-slate-300 mb-2 text-sm">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required
                        min="{{ now()->subYears(120)->format('Y-m-d') }}" max="{{ now()->format('Y-m-d') }}"
                        class="w-full bg-slate-900 border border-slate-700 text-slate-400 focus:text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                    @error('fecha_nacimiento')
                        <p class="mt-2 text-sm text-red-400 font-medium">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- DIRECCIÓN --}}
                <div class="md:col-span-2">
                    <label class="block font-bold text-slate-300 mb-2 text-sm">Dirección</label>
                    <input type="text" name="direccion" value="{{ old('direccion') }}" autocomplete="off" required
                        minlength="5" maxlength="150" title="Ingrese una dirección válida."
                        class="w-full bg-slate-900 border border-slate-700 text-slate-100 text-sm rounded-xl px-4 py-3.5 focus:border-teal-400 focus:ring-4 focus:ring-teal-400/10 transition-all outline-none">
                    @error('direccion')
                        <p class="mt-2 text-sm text-red-400 font-medium">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>

            {{-- BOTÓN DE ACCIÓN --}}
            <div class="pt-4 flex justify-end border-t border-slate-700/60 mt-6">
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-3.5 bg-gradient-to-r from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500 text-white font-bold text-sm rounded-xl transition-all duration-300 shadow-lg shadow-teal-500/20 hover:shadow-cyan-500/30 hover:-translate-y-0.5">
                    Guardar Paciente
                </button>
            </div>

        </form>

    </div>

</x-app-layout>
