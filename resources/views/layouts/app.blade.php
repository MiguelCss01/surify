<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Surify - Turismo Nacional')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #f8fafc; color: #1e293b; font-family: 'Outfit', sans-serif; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; display: inline-block; line-height: 1; }
        #loading-screen { position: fixed; inset: 0; z-index: 9999; background: white; display: flex; flex-direction: column; align-items: center; justify-content: center; transition: opacity 0.5s ease; }
        #loading-screen.oculto { opacity: 0; pointer-events: none; }
    </style>

    <script>
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="flex flex-col min-h-screen antialiased">

    {{-- Pantalla de carga --}}
    <div id="loading-screen">
        <div style="display:flex;flex-direction:column;align-items:center;gap:24px">
            <div style="display:flex;align-items:center;gap:8px">
                <span class="material-symbols-outlined" style="font-variation-settings:'FILL' 1;font-size:40px;color:#28628f">explore</span>
                <span style="font-family:'Inter',sans-serif;font-size:2.5rem;font-weight:900;color:#191c1d;letter-spacing:-0.05em">Surify</span>
            </div>
            <div style="width:192px;height:4px;background:#f1f5f9;border-radius:9999px;overflow:hidden">
                <div id="loading-bar-screen" style="height:100%;background:#28628f;border-radius:9999px;width:0%;transition:width 0.3s"></div>
            </div>
            <p style="font-size:0.75rem;font-weight:600;color:#94a3b8;letter-spacing:0.1em;text-transform:uppercase">Explorando Argentina...</p>
        </div>
    </div>

    <header class="border-b border-slate-200 bg-white/90 backdrop-blur-md sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">

            <!-- Logo -->
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2 bg-white px-3.5 py-1.5 rounded-xl border border-slate-200 shadow-sm select-none hover:opacity-95 transition-opacity text-decoration-none">
                    <span class="material-symbols-outlined text-[24px] text-[#28628f]" style="font-variation-settings: 'FILL' 1;">explore</span>
                    <span class="text-xl font-black text-[#191c1d] tracking-tighter" style="font-family: 'Inter', sans-serif;">Surify</span>
                </a>
            </div>

            <!-- Buscador -->
            <div class="relative flex-grow max-w-md hidden md:block" id="search-container">
                <div class="flex items-center bg-slate-100 border border-transparent rounded-full px-4 py-2 gap-2 focus-within:border-[#28628f] focus-within:bg-white transition-all">
                    <span class="material-symbols-outlined text-slate-400 text-[18px]">search</span>
                    <input id="search-input" type="text" placeholder="Destinos, festivales, provincias..."
                        class="bg-transparent border-none p-0 focus:ring-0 text-sm text-slate-700 placeholder:text-slate-400 w-full" autocomplete="off">
                </div>
                <div id="search-dropdown" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-slate-200 z-50 overflow-hidden">
                    <div id="search-results" class="max-h-80 overflow-y-auto"></div>
                    <div id="search-empty" class="hidden px-4 py-6 text-center text-sm text-slate-400">No se encontraron resultados</div>
                </div>
            </div>

            <!-- Nav links -->
            <nav class="hidden md:flex items-center gap-1 shrink-0">
                @auth
                @php
                    $user = auth()->user();
                    $modoUsuario = session('modo_usuario', false);
                    $esAdmin = !$modoUsuario && ($user->hasRole('admin') || $user->hasRole('Admin'));
                    $permisosUsuario = $user->permisos()->pluck('nombre')->toArray();
                    $tieneAlguno = fn(array $perms) => !$modoUsuario && ($esAdmin || count(array_intersect($perms, $permisosUsuario)) > 0);
                    $esOperador = !$modoUsuario && ($esAdmin || count($permisosUsuario) > 0);
                @endphp

                {{-- Links públicos: solo si NO es operador o está en modo usuario --}}
                @if(!$esOperador || $modoUsuario)
                    <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">home</span> Inicio
                    </a>
                    <a href="{{ route('mapa.nacional') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">map</span> Mapa
                    </a>
                    <a href="{{ route('eventos.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">event</span> Eventos
                    </a>
                    <a href="{{ route('combustible.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">local_gas_station</span> Combustible
                    </a>
                @endif

                {{-- Dashboard --}}
                @if($esOperador)
                    <span class="h-5 w-px bg-slate-200 mx-1"></span>
                    <a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">dashboard</span> Dashboard
                    </a>
                @endif

                {{-- Solo Admin --}}
                @if($esAdmin)
                    <a href="{{ route('admin.roles.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span> Roles
                    </a>
                    <a href="{{ route('admin.usuarios.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">group</span> Usuarios
                    </a>
                @endif

                {{-- Dinámico por permisos --}}
                @if($tieneAlguno(['crear_destino', 'modificar_destino', 'eliminar_destino', 'administrar_destinos_sugeridos']))
                    <a href="{{ route('admin.destinos.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">landscape</span> Destinos
                    </a>
                @endif

                @if($tieneAlguno(['crear_evento', 'modificar_evento', 'eliminar_evento', 'administrar_eventos_sugeridos']))
                    <a href="/admin/eventos" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">celebration</span> Festivales
                    </a>
                @endif

                @if($tieneAlguno(['administrar_resena', 'administrar_resenas', 'eliminar_comentario']))
                    <a href="{{ route('admin.resenas.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">chat_bubble</span> Reseñas
                    </a>
                @endif

                @if($tieneAlguno(['gestionar_gastronomia']))
                    <a href="{{ route('admin.gastronomia.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">restaurant</span> Gastronomía
                    </a>
                @endif

                @else
                {{-- Invitado --}}
                <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none">Inicio</a>
                <a href="{{ route('mapa.nacional') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none">Mapa</a>
                <a href="{{ route('eventos.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none">Eventos</a>
                @endauth
            </nav>

            <!-- Auth -->
            <div class="flex items-center gap-3 shrink-0">
                @auth
                <div class="flex items-center gap-3">

                    {{-- Botón Ver como usuario / Vista Admin --}}
                    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('Admin') || count(auth()->user()->permisos()->pluck('nombre')->toArray()) > 0)
                        <form method="POST" action="{{ route('admin.cambiar_vista') }}">
                            @csrf
                            <button type="submit" class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-slate-200 hover:border-[#28628f] text-slate-500 hover:text-[#28628f] transition-all bg-white cursor-pointer flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]">{{ session('modo_usuario') ? 'admin_panel_settings' : 'visibility' }}</span>
                                {{ session('modo_usuario') ? 'Vista Admin' : 'Ver como usuario' }}
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 hover:opacity-80 transition-all text-decoration-none">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full border border-[#28628f]">
                        @else
                            <div class="w-8 h-8 rounded-full bg-[#28628f] text-white flex items-center justify-center text-sm font-bold">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <span class="text-sm font-medium text-slate-700 hidden lg:block">{{ auth()->user()->name }}</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-slate-200 hover:border-[#28628f] text-slate-500 hover:text-[#28628f] transition-all bg-white cursor-pointer">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-semibold px-4 py-2 rounded-full border border-slate-200 hover:border-[#28628f] text-slate-600 hover:text-[#28628f] transition-all bg-white text-decoration-none">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" class="text-xs font-semibold px-4 py-2 rounded-full bg-[#28628f] hover:bg-[#1a4669] text-white transition-all shadow-sm text-decoration-none">Registrarse</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('status'))
        <div class="mb-6 p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 text-[#28628f] text-sm font-semibold flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">info</span>
            {{ session('status') }}
        </div>
        @endif
        @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-600 text-sm">
            ✅ {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-600 text-sm">
            ⚠️ {{ session('error') }}
        </div>
        @endif
        @yield('content')
    </main>

    <footer class="border-t border-slate-200 bg-white py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-slate-400">
            <p>&copy; {{ date('Y') }} Surify. Todos los derechos reservados. Desarrollado con 💖 por Casasola, Gómez y Martínez para la UCP 🌸.</p>
        </div>
    </footer>

    <!-- Reproductor Himno -->
    <div class="fixed bottom-6 right-6 z-50 flex items-center bg-white border border-slate-200 p-3 rounded-full shadow-xl gap-3 max-w-xs transition-all duration-300 hover:border-[#28628f]">
        <button id="global-music-btn" class="w-10 h-10 rounded-full bg-[#28628f] text-white flex items-center justify-center hover:bg-[#1a4669] transition-transform active:scale-95 shadow-sm">
            <span id="global-music-icon" class="material-symbols-outlined">play_arrow</span>
        </button>
        <div class="flex flex-col pr-4 select-none">
            <span class="text-xs font-bold text-slate-800 leading-tight truncate max-w-[120px]">Himno Surify</span>
            <span id="global-music-status" class="text-[10px] text-slate-400 font-semibold tracking-wide">Pausado</span>
        </div>
        <audio id="global-surify-song" loop>
            <source src="{{ asset('audio/cancion_surify.mpeg') }}" type="audio/mpeg">
        </audio>
    </div>

    <script>
        (function() {
            const bar = document.getElementById('loading-bar-screen');
            const screen = document.getElementById('loading-screen');
            let progress = 0;
            let oculto = false;
            const interval = setInterval(() => {
                progress += Math.random() * 15;
                if (progress > 85) progress = 85;
                bar.style.width = progress + '%';
            }, 100);
            function ocultarPantalla() {
                if (oculto) return;
                oculto = true;
                clearInterval(interval);
                bar.style.width = '100%';
                setTimeout(() => {
                    screen.classList.add('oculto');
                    setTimeout(() => { if (screen.parentNode) screen.remove(); }, 500);
                }, 200);
            }
            document.addEventListener('DOMContentLoaded', ocultarPantalla);
            setTimeout(ocultarPantalla, 5000);
        })();

        document.addEventListener('DOMContentLoaded', function() {
            const audio = document.getElementById('global-surify-song');
            const btn = document.getElementById('global-music-btn');
            const icon = document.getElementById('global-music-icon');
            const status = document.getElementById('global-music-status');

            setInterval(function() {
                if (audio && !audio.paused) {
                    localStorage.setItem('surify-music-time', audio.currentTime);
                    localStorage.setItem('surify-music-playing', 'true');
                }
            }, 1000);

            audio.addEventListener('loadedmetadata', function() {
                const savedTime = parseFloat(localStorage.getItem('surify-music-time') || '0');
                const wasPlaying = localStorage.getItem('surify-music-playing') === 'true';
                if (savedTime > 0) audio.currentTime = savedTime;
                if (wasPlaying) {
                    audio.play().then(() => {
                        icon.textContent = 'pause';
                        status.textContent = 'Reproduciendo';
                        status.className = "text-[10px] text-emerald-500 font-bold animate-pulse tracking-wide";
                    }).catch(() => {
                        icon.textContent = 'play_arrow';
                        status.textContent = 'Continuar Himno';
                        status.className = "text-[10px] text-amber-500 font-bold tracking-wide animate-pulse";
                    });
                }
            }, { once: true });

            btn.addEventListener('click', function() {
                if (audio.paused) {
                    audio.play().then(() => {
                        icon.textContent = 'pause';
                        status.textContent = 'Reproduciendo';
                        status.className = "text-[10px] text-emerald-500 font-bold animate-pulse tracking-wide";
                        localStorage.setItem('surify-music-playing', 'true');
                    });
                } else {
                    audio.pause();
                    icon.textContent = 'play_arrow';
                    status.textContent = 'Pausado';
                    status.className = "text-[10px] text-slate-400 font-semibold tracking-wide";
                    localStorage.setItem('surify-music-playing', 'false');
                    localStorage.removeItem('surify-music-time');
                }
            });
        });
    </script>

</body>
</html>