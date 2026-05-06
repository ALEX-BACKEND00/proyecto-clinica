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
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                        
                        <button @click="open = ! open" class="inline-flex items-center gap-2 px-4 py-2 border border-slate-200/80 bg-white text-sm font-bold text-slate-700 hover:text-teal-600 rounded-xl transition-all duration-200 shadow-sm focus:outline-none">
                            <span class="flex w-2 h-2 rounded-full bg-teal-500"></span>
                            <div>{{ Auth::user()->name }}</div>
                            <svg class="h-4 w-4 text-slate-400 transition-transform duration-200" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 z-50 mt-2 w-48 rounded-xl shadow-xl border {{ $isAdmin ? 'bg-slate-800 border-slate-700/80' : 'bg-white border-slate-100' }} py-1.5 overflow-hidden"
                             style="display: none;">
                            
                            <a href="{{ route('profile.edit') }}" 
                               class="block w-full px-4 py-2.5 text-left text-sm font-semibold transition-colors duration-150 ease-in-out {{ $isAdmin ? 'text-slate-200 hover:bg-slate-700 hover:text-white' : 'text-slate-800 hover:bg-teal-50/60 hover:text-teal-700' }}">
                                Mi Perfil
                            </a>

                            <div class="h-px w-full {{ $isAdmin ? 'bg-slate-700/60' : 'bg-slate-100' }} my-1"></div>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" 
                                        class="block w-full px-4 py-2.5 text-left text-sm font-bold transition-colors duration-150 ease-in-out {{ $isAdmin ? 'text-rose-400 hover:bg-rose-900/30' : 'text-rose-600 hover:bg-rose-50/60' }}">
                                    Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
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