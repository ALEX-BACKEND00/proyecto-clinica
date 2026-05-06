@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<section class="{{ $isAdmin ? 'bg-slate-800/50 border-slate-700/80 shadow-xl' : 'bg-white border-slate-200/80 shadow-sm' }} border rounded-2xl p-6 sm:p-8 space-y-6">
    <header>
        <h2 class="text-xl font-bold {{ $isAdmin ? 'text-white' : 'text-slate-900' }} tracking-tight">
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="mt-1 text-sm {{ $isAdmin ? 'text-slate-400' : 'text-slate-600' }} font-medium">
            {{ __('Asegúrate de que tu cuenta esté usando una contraseña larga y aleatoria para mantenerla segura.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="font-bold text-sm {{ $isAdmin ? 'text-slate-200' : 'text-slate-800' }} mb-2 block">
                {{ __('Contraseña Actual') }}
            </label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password"
                class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100 focus:ring-teal-400/10 focus:border-teal-400' : 'bg-white border-slate-200 text-slate-900 focus:ring-teal-500/10 focus:border-teal-500' }} border text-sm rounded-xl px-4 py-3.5 focus:ring-4 transition-all outline-none" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-rose-400 text-xs" />
        </div>

        <div>
            <label for="update_password_password" class="font-bold text-sm {{ $isAdmin ? 'text-slate-200' : 'text-slate-800' }} mb-2 block">
                {{ __('Nueva Contraseña') }}
            </label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password"
                class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100 focus:ring-teal-400/10 focus:border-teal-400' : 'bg-white border-slate-200 text-slate-900 focus:ring-teal-500/10 focus:border-teal-500' }} border text-sm rounded-xl px-4 py-3.5 focus:ring-4 transition-all outline-none" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-rose-400 text-xs" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="font-bold text-sm {{ $isAdmin ? 'text-slate-200' : 'text-slate-800' }} mb-2 block">
                {{ __('Confirmar Contraseña') }}
            </label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password"
                class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100 focus:ring-teal-400/10 focus:border-teal-400' : 'bg-white border-slate-200 text-slate-900 focus:ring-teal-500/10 focus:border-teal-500' }} border text-sm rounded-xl px-4 py-3.5 focus:ring-4 transition-all outline-none" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-rose-400 text-xs" />
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" 
                class="w-full sm:w-auto px-6 py-3.5 bg-gradient-to-r {{ $isAdmin ? 'from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500' : 'from-teal-600 to-cyan-700 hover:from-teal-500 hover:to-cyan-600' }} text-white font-bold text-sm rounded-xl transition-all duration-300 shadow-lg hover:-translate-y-0.5 outline-none">
                {{ __('Cambiar Contraseña') }}
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-emerald-400">
                    {{ __('Contraseña actualizada.') }}
                </p>
            @endif
        </div>
    </form>
</section>