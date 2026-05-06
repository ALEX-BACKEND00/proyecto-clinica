@php
    $isAdmin = auth()->user()->role === 'admin';
@endphp

<x-app-layout>

    <div class="max-w-4xl mx-auto space-y-8">

        {{-- CABECERA (CORREGIDO CONTRASTE) --}}
        <div>
            <h1 class="text-3xl sm:text-4xl font-black {{ $isAdmin ? 'text-slate-100' : 'text-slate-900' }} tracking-tight">
                Mi <span class="text-transparent bg-clip-text bg-gradient-to-r {{ $isAdmin ? 'from-teal-400 to-cyan-400' : 'from-teal-600 to-cyan-600' }}">Perfil</span>
            </h1>
            <p class="text-slate-400 mt-1 font-medium text-sm">
                Gestiona tus datos personales y la seguridad de tu cuenta
            </p>
        </div>

        {{-- FORMULARIOS (Limpios sin cajas envolventes oscuras) --}}
        <div class="space-y-6">
            @include('profile.partials.update-profile-information-form')

            @include('profile.partials.update-password-form')

            @include('profile.partials.delete-user-form')
        </div>

    </div>

</x-app-layout>