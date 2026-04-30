<x-guest-layout>
    
    <!-- Encabezado del Formulario -->
    <div class="mb-8">
        <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">Crear nueva cuenta</h3>
        <p class="text-slate-500 text-sm">Ingresa tus datos personales para registrarte como paciente en nuestra clínica.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf

        <!-- Nombre -->
        <div>
            <label for="name" class="block text-sm font-semibold text-slate-700 mb-1.5">Nombre completo</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none" 
                placeholder="Ej. Juan Pérez">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500 text-xs font-medium" />
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Correo electrónico</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none" 
                placeholder="tu@correo.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs font-medium" />
        </div>

        <!-- Grid para contraseñas (Para ahorrar espacio vertical en pantallas grandes) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-semibold text-slate-700 mb-1.5">Contraseña</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none" 
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs font-medium" />
            </div>

            <!-- Confirmar Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-1.5">Confirmar contraseña</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="block w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none" 
                    placeholder="••••••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500 text-xs font-medium" />
            </div>
        </div>

        <!-- Acciones -->
        <div class="pt-4 mt-6 border-t border-slate-200/60">
            <button type="submit" 
                class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-sm shadow-teal-600/20 text-sm font-bold text-white bg-teal-600 hover:bg-teal-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 transition-colors">
                Completar Registro
            </button>
        </div>

        <!-- Link al Login -->
        <p class="text-center text-sm text-slate-600 mt-6">
            ¿Ya eres paciente de la clínica? 
            <a href="{{ route('login') }}" class="font-bold text-teal-600 hover:text-teal-700 hover:underline transition-all">
                Inicia sesión aquí
            </a>
        </p>
    </form>

</x-guest-layout>