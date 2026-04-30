<x-guest-layout>
    <!-- Encabezado de la Vista -->
    <div class="mb-8">
        <h3 class="text-2xl sm:text-3xl font-bold text-slate-900 mb-2">¡Bienvenido de nuevo!</h3>
        <p class="text-slate-500 text-sm">Ingresa tus credenciales para acceder a tu panel de control.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-1.5">Correo electrónico</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none" 
                    placeholder="nombre@correo.com">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs font-medium" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-semibold text-slate-700">Contraseña</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-teal-600 hover:text-teal-700 hover:underline transition-colors" href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="block w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-slate-900 text-sm focus:ring-2 focus:ring-teal-500/20 focus:border-teal-500 transition-all outline-none" 
                    placeholder="••••••••">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs font-medium" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded-md border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500 focus:ring-offset-0 transition-colors" name="remember">
                <span class="ms-2 text-sm text-slate-600 font-medium">Mantener sesión iniciada</span>
            </label>
        </div>

        <!-- Acciones: EL BOTÓN QUE RESALTA -->
        <div class="pt-2">
            <button type="submit" 
                class="w-full group relative flex justify-center items-center py-3.5 px-4 rounded-xl overflow-hidden transition-all duration-300">
                <!-- Capa de fondo con gradiente intenso -->
                <span class="absolute inset-0 bg-gradient-to-r from-teal-600 via-cyan-600 to-teal-600 bg-[length:200%_auto] hover:bg-right transition-all duration-500"></span>
                
                <!-- Sombra difusa de color -->
                <span class="absolute inset-0 rounded-xl shadow-[0_10px_20px_-10px_rgba(13,148,136,0.5)] group-hover:shadow-[0_15px_30px_-10px_rgba(13,148,136,0.6)] transition-all"></span>

                <span class="relative flex items-center text-sm font-bold text-white tracking-wide">
                    Iniciar Sesión
                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l4-4m0 0l-4-4m4 4H3" />
                    </svg>
                </span>
            </button>
        </div>

        <!-- Registro para nuevos usuarios -->
        <div class="mt-8 text-center pt-6 border-t border-slate-200/60">
            <p class="text-sm text-slate-600">
                ¿Aún no tienes una cuenta? 
                <a href="{{ route('register') }}" class="font-bold text-teal-600 hover:text-teal-700 hover:underline transition-all">
                    Regístrate aquí
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>