@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<section class="{{ $isAdmin ? 'bg-slate-800/50 border-slate-700/80 shadow-xl' : 'bg-white border-slate-100 shadow-sm' }} border rounded-2xl p-6 sm:p-8 space-y-6">
    <header>
        <h2 class="text-xl font-bold {{ $isAdmin ? 'text-white' : 'text-slate-900' }} tracking-tight">
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="mt-1 text-sm {{ $isAdmin ? 'text-slate-400' : 'text-slate-600' }} font-medium">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente.') }}
        </p>
    </header>

    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="w-full sm:w-auto px-6 py-3.5 {{ $isAdmin ? 'bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border-rose-500/30' : 'bg-rose-50 hover:bg-rose-100 text-rose-700 border-rose-200' }} border font-bold text-xs uppercase tracking-wider rounded-xl transition-all duration-200 outline-none">
        {{ __('Eliminar mi cuenta') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 sm:p-8 {{ $isAdmin ? 'bg-slate-900 border border-slate-800' : 'bg-white' }} rounded-2xl">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold {{ $isAdmin ? 'text-white' : 'text-slate-900' }}">
                {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
            </h2>

            <p class="mt-2 text-sm {{ $isAdmin ? 'text-slate-400' : 'text-slate-600' }} font-medium leading-relaxed">
                {{ __('Por favor, ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Contraseña') }}" class="sr-only" />
                <input id="password" name="password" type="password" placeholder="{{ __('Ingresa tu contraseña') }}" required
                    class="w-full {{ $isAdmin ? 'bg-slate-800 border-slate-700 text-slate-100 focus:ring-rose-500/20 focus:border-rose-500' : 'bg-white border-slate-200 text-slate-900 focus:ring-rose-500/20 focus:border-rose-500' }} border text-sm rounded-xl px-4 py-3.5 focus:ring-4 transition-all outline-none" />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-rose-400 text-xs" />
            </div>

            <div class="mt-6 flex flex-col sm:flex-row justify-end gap-3">
                <button type="button" x-on:click="$dispatch('close')"
                    class="w-full sm:w-auto px-6 py-3.5 {{ $isAdmin ? 'bg-slate-800 hover:bg-slate-700 text-slate-300 border-slate-700' : 'bg-slate-100 hover:bg-slate-200 text-slate-600 border-slate-200' }} border font-bold text-sm rounded-xl text-center transition-all duration-200">
                    {{ __('Cancelar') }}
                </button>

                <button type="submit"
                    class="w-full sm:w-auto px-6 py-3.5 bg-rose-600 hover:bg-rose-500 text-white font-bold text-sm rounded-xl transition-all duration-200 shadow-lg shadow-rose-500/20">
                    {{ __('Eliminar permanentemente') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>