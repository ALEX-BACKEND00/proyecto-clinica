@php
    $isAdmin = auth()->user()->role === 'admin';

    // 1. FUNDIR EL HEADER: Hacemos que el fondo sea exactamente igual al del body/header
    $navClass = $isAdmin 
        ? 'bg-slate-950 border-slate-800' // Oscuro profundo, igual que el body
        : 'bg-slate-50 border-slate-200'; // Claro limpio, igual que el body

    $textClass = $isAdmin ? 'text-slate-300 hover:text-white' : 'text-slate-600 hover:text-teal-600';
    $dropdownBtnClass = $isAdmin 
        ? 'bg-slate-800 text-slate-300 hover:text-white border-slate-700 hover:border-slate-600' 
        : 'bg-white text-slate-700 hover:text-teal-700 border-slate-200 hover:border-teal-200';
@endphp

<nav x-data="{ open: false }" class="relative z-50 {{ $navClass }} border-b transition-colors duration-500">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Aumentamos la altura de la barra a h-20/24 para dar más aire al logo grande -->
        <div class="flex justify-between h-20 sm:h-24">
            <div class="flex items-center">
                
                <!-- 2. BRANDING MÁS GRANDE Y VISIBLE (CORREGIDO) -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group transition-transform hover:scale-105">
                        
                        <!-- Si es Admin, le damos un fondo blanco redondeado al logo para garantizar contraste -->
                        <div class="{{ $isAdmin ? 'bg-white p-1.5 rounded-xl shadow-sm' : '' }}">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo CMR" class="h-10 sm:h-12 w-auto object-contain">
                        </div>
                        
                        <div class="border-l-2 {{ $isAdmin ? 'border-slate-700' : 'border-slate-300' }} pl-3">
                            <span class="text-2xl sm:text-3xl font-black {{ $isAdmin ? 'text-white' : 'text-slate-900' }} leading-none">CMR</span>
                            <p class="text-[9px] sm:text-[10px] uppercase tracking-[0.2em] {{ $isAdmin ? 'text-teal-400' : 'text-teal-600' }} font-bold leading-none mt-1">Clínica</p>
                        </div>
                    </a>
                </div>

                <!-- 3. LINKS CON ESTILO ACTIVO RESALTADO -->
                <div class="hidden space-x-4 sm:-my-px sm:ms-12 sm:flex items-center">
                    
                    @php
                        $isDashboardActive = request()->routeIs('dashboard');
                        // Si está activo, le damos fondo de color y texto blanco/brillante
                        $activeLinkClass = $isAdmin
                            ? 'bg-slate-800 text-teal-400 border border-slate-700' 
                            : 'bg-teal-50 text-teal-700 border border-teal-100';
                            
                        // Si NO está activo, estilo normal
                        $inactiveLinkClass = $isAdmin
                            ? 'text-slate-400 hover:text-slate-200 hover:bg-slate-800/50'
                            : 'text-slate-500 hover:text-slate-800 hover:bg-slate-100/50';
                    @endphp

                    <a href="{{ route('dashboard') }}" 
                       class="px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 {{ $isDashboardActive ? $activeLinkClass : $inactiveLinkClass }}">
                        Dashboard
                    </a>
                    
                    {{-- Ejemplos de otros links para el Admin --}}
                    @if($isAdmin)
                        <a href="{{ route('pacientes.index') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 {{ request()->routeIs('pacientes.*') ? $activeLinkClass : $inactiveLinkClass }}">
                            Pacientes
                        </a>
                        <a href="{{ route('citas.index') }}" 
                           class="px-4 py-2 rounded-lg text-sm font-bold transition-all duration-200 {{ request()->routeIs('citas.*') ? $activeLinkClass : $inactiveLinkClass }}">
                            Citas
                        </a>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <!-- Botón de usuario un poco más robusto -->
                        <button class="inline-flex items-center px-4 py-2 border {{ $dropdownBtnClass }} text-sm font-bold rounded-xl transition-all duration-200 focus:outline-none shadow-sm">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full {{ $isAdmin ? 'bg-teal-400' : 'bg-teal-500' }} shadow-[0_0_8px_rgba(45,212,191,0.6)]"></div>
                                {{ Auth::user()->name }}
                            </div>

                            <div class="ms-3">
                                <svg class="fill-current h-4 w-4 opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Contenedor del Dropdown -->
                        <div class="{{ $isAdmin ? 'bg-slate-800 border-slate-700' : 'bg-white border-slate-200' }} border shadow-xl rounded-lg overflow-hidden py-1">
                            
                            <!-- Link Mi Perfil (HTML PURO) -->
                            <a href="{{ route('profile.edit') }}" 
                               class="block w-full px-4 py-2 text-left text-sm font-semibold transition-colors duration-150 ease-in-out {{ $isAdmin ? 'text-slate-200 hover:bg-slate-700 hover:text-white' : 'text-slate-900 hover:bg-teal-50 hover:text-teal-700' }}">
                                Mi Perfil
                            </a>

                            <!-- Divisor -->
                            <div class="h-px w-full {{ $isAdmin ? 'bg-slate-700' : 'bg-slate-100' }} my-1"></div>

                            <!-- Link Cerrar Sesión (HTML PURO) -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full px-4 py-2 text-left text-sm font-bold transition-colors duration-150 ease-in-out {{ $isAdmin ? 'text-rose-400 hover:bg-rose-900/30' : 'text-rose-600 hover:bg-rose-50' }}">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl {{ $isAdmin ? 'text-slate-400 hover:bg-slate-800' : 'text-slate-500 hover:bg-slate-100' }} transition duration-150">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu Mobile -->
    <div x-show="open" x-transition class="sm:hidden {{ $isAdmin ? 'bg-slate-900 border-t border-slate-800' : 'bg-white border-t border-slate-100' }}">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-lg text-base font-bold {{ $isDashboardActive ? $activeLinkClass : $inactiveLinkClass }}">
                Dashboard
            </a>
            @if($isAdmin)
                <a href="{{ route('pacientes.index') }}" class="block px-4 py-3 rounded-lg text-base font-bold {{ request()->routeIs('pacientes.*') ? $activeLinkClass : $inactiveLinkClass }}">
                    Pacientes
                </a>
            @endif
        </div>

        <div class="pt-4 pb-4 border-t {{ $isAdmin ? 'border-slate-800' : 'border-slate-100' }}">
            <div class="px-6 mb-4">
                <div class="font-bold text-base {{ $isAdmin ? 'text-white' : 'text-slate-800' }}">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm {{ $isAdmin ? 'text-slate-500' : 'text-slate-500' }}">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1 px-4">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 rounded-lg text-sm font-medium {{ $isAdmin ? 'text-slate-400 hover:bg-slate-800' : 'text-slate-600 hover:bg-slate-50' }}">
                    Mi Perfil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 rounded-lg text-sm font-bold text-rose-500 {{ $isAdmin ? 'hover:bg-rose-900/20' : 'hover:bg-rose-50' }}">
                        Cerrar Sesión
                    </a>
                </form>
            </div>
        </div>
    </div>
</nav>