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

    <!-- Leaflet - siempre disponible -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f8fafc;
            color: #1e293b;
            font-family: 'Outfit', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            line-height: 1;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen antialiased">

    <header class="border-b border-slate-200 bg-white/90 backdrop-blur-md sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between gap-4">

            <!-- Logo -->
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('home') }}" class="flex items-center gap-2 bg-white px-3.5 py-1.5 rounded-xl border border-slate-200 shadow-sm select-none hover:opacity-95 transition-opacity text-decoration-none">
                    <span class="material-symbols-outlined text-[24px] text-[#28628f]" style="font-variation-settings: 'FILL' 1;">explore</span>
                    <span class="text-xl font-black text-[#191c1d] tracking-tighter" style="font-family: 'Inter', sans-serif;">Surify</span>
                </a>
            </div>

            <!-- Buscador central -->
            <div class="relative flex-grow max-w-md hidden md:block" id="search-container">
                <div class="flex items-center bg-slate-100 border border-transparent rounded-full px-4 py-2 gap-2 focus-within:border-[#28628f] focus-within:bg-white transition-all">
                    <span class="material-symbols-outlined text-slate-400 text-[18px]">search</span>
                    <input
                        id="search-input"
                        type="text"
                        placeholder="Destinos, festivales, provincias..."
                        class="bg-transparent border-none p-0 focus:ring-0 text-sm text-slate-700 placeholder:text-slate-400 w-full"
                        autocomplete="off">
                </div>
                <!-- Dropdown resultados -->
                <div id="search-dropdown" class="hidden absolute top-full left-0 right-0 mt-2 bg-white rounded-xl shadow-xl border border-slate-200 z-50 overflow-hidden">
                    <div id="search-results" class="max-h-80 overflow-y-auto"></div>
                    <div id="search-empty" class="hidden px-4 py-6 text-center text-sm text-slate-400">
                        No se encontraron resultados
                    </div>
                </div>
            </div>

            <!-- Nav links -->
            <!-- Nav links -->
<nav class="hidden md:flex items-center gap-1 shrink-0">
    @auth
        @if(auth()->user()->hasRole('admin'))
            {{-- Navbar Admin --}}
<a href="{{ route('dashboard') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
    <span class="material-symbols-outlined text-[16px]">dashboard</span> Dashboard
</a>
<a href="{{ route('admin.roles.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
    <span class="material-symbols-outlined text-[16px]">admin_panel_settings</span> Roles
</a>
<a href="#" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
    <span class="material-symbols-outlined text-[16px]">group</span> Usuarios
</a>
<a href="{{ route('admin.destinos.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
    <span class="material-symbols-outlined text-[16px]">landscape</span> Destinos
</a>
<a href="#" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none flex items-center gap-1">
    <span class="material-symbols-outlined text-[16px]">celebration</span> Eventos
</a>
        @else
            {{-- Navbar Usuario Normal --}}
            <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none">Inicio</a>
            <a href="{{ route('mapa.nacional') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none">Mapa</a>
            <a href="{{ route('eventos.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none">Eventos</a>
            <a href="{{ route('combustible.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none">Combustible</a>
        @endif
    @else
        {{-- Navbar Invitado --}}
        <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none">Inicio</a>
        <a href="{{ route('mapa.nacional') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none">Mapa</a>
        <a href="{{ route('eventos.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] hover:bg-slate-50 px-3 py-2 rounded-lg transition-all text-decoration-none">Eventos</a>
    @endauth
</nav>

            <!-- Auth -->
            <div class="flex items-center gap-3 shrink-0">
                @auth
                <div class="flex items-center gap-3">
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
            <p>&copy; {{ date('Y') }} Surify. Todos los derechos reservados. Desarrollado con 💖 y Laravel.</p>
        </div>
    </footer>

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

                if (savedTime > 0) {
                    audio.currentTime = savedTime;
                }

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
            }, {
                once: true
            });

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

    <script>
        function navegarSinRecarga(url) {
            fetch(url)
                .then(r => r.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newMain = doc.querySelector('main');
                    if (newMain) {
                        document.querySelector('main').innerHTML = newMain.innerHTML;
                        window.history.pushState({}, '', url);
                        document.title = doc.title;

                        // Ejecutar los scripts de la nueva página
                        document.querySelector('main').querySelectorAll('script').forEach(function(scriptViejo) {
                            const scriptNuevo = document.createElement('script');
                            scriptNuevo.textContent = scriptViejo.textContent;
                            document.body.appendChild(scriptNuevo);
                        });
                    }
                });
        }

        document.addEventListener('click', function(e) {
            const link = e.target.closest('a[href]');
            if (!link) return;

            const url = link.href;

            if (!url.startsWith(window.location.origin)) return;
            if (url.includes('logout')) return;
            if (url.includes('#')) return;

            if (url.includes('login') || url.includes('register') || url.includes('profile')) return;

            e.preventDefault();
            navegarSinRecarga(url);
        });

        window.addEventListener('popstate', function() {
            navegarSinRecarga(window.location.href);
        });
    </script>

</body>

</html>