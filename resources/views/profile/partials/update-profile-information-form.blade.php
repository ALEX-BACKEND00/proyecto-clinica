@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<section class="{{ $isAdmin ? 'bg-slate-800/50 border-slate-700/80 shadow-xl' : 'bg-white border-slate-200/80 shadow-sm' }} border rounded-2xl p-6 sm:p-8 space-y-6">
    <header>
        <h2 class="text-xl font-bold {{ $isAdmin ? 'text-white' : 'text-slate-900' }} tracking-tight">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-1 text-sm {{ $isAdmin ? 'text-slate-400' : 'text-slate-600' }} font-medium">
            {{ __("Actualiza la información de tu cuenta y tu dirección de correo electrónico.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="font-bold text-sm {{ $isAdmin ? 'text-slate-200' : 'text-slate-800' }} mb-2 block">
                Nombre completo
            </label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100 focus:ring-teal-400/10 focus:border-teal-400' : 'bg-white border-slate-200 text-slate-900 focus:ring-teal-500/10 focus:border-teal-500' }} border text-sm rounded-xl px-4 py-3.5 focus:ring-4 transition-all outline-none" />
            <x-input-error class="mt-2 text-rose-400 text-xs" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="font-bold text-sm {{ $isAdmin ? 'text-slate-200' : 'text-slate-800' }} mb-2 block">
                Correo electrónico
            </label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username"
                class="w-full {{ $isAdmin ? 'bg-slate-900 border-slate-700 text-slate-100 focus:ring-teal-400/10 focus:border-teal-400' : 'bg-white border-slate-200 text-slate-900 focus:ring-teal-500/10 focus:border-teal-500' }} border text-sm rounded-xl px-4 py-3.5 focus:ring-4 transition-all outline-none" />
            <x-input-error class="mt-2 text-rose-400 text-xs" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-3">
                    <p class="text-sm {{ $isAdmin ? 'text-slate-300' : 'text-slate-800' }}">
                        {{ __('Tu dirección de correo electrónico no está verificada.') }}

                        <button form="send-verification" class="underline text-sm {{ $isAdmin ? 'text-slate-400 hover:text-slate-200' : 'text-slate-600 hover:text-slate-900' }} rounded-md focus:outline-none transition-colors">
                            {{ __('Haz clic aquí para volver a enviar el correo de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-semibold text-sm text-emerald-400">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu correo electrónico.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button type="submit" 
                class="w-full sm:w-auto px-6 py-3.5 bg-gradient-to-r {{ $isAdmin ? 'from-teal-600 to-cyan-600 hover:from-teal-500 hover:to-cyan-500' : 'from-teal-600 to-cyan-700 hover:from-teal-500 hover:to-cyan-600' }} text-white font-bold text-sm rounded-xl transition-all duration-300 shadow-lg hover:-translate-y-0.5 outline-none">
                {{ __('Guardar') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm font-bold text-emerald-400">
                    {{ __('Guardado correctamente.') }}
                </p>
            @endif
        </div>
    </form>
</section>