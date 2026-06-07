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
    
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2 bg-white px-3.5 py-1.5 rounded-xl border border-slate-200 shadow-sm select-none hover:opacity-95 transition-opacity text-decoration-none">
                    <span class="material-symbols-outlined text-[24px] text-[#28628f]" style="font-variation-settings: 'FILL' 1;">explore</span>
                    <span class="text-xl font-black text-[#191c1d] tracking-tighter font-sans" style="font-family: 'Inter', sans-serif;">Surify</span>
                </a>
            </div>
            
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] transition-colors text-decoration-none">Inicio</a>
                <a href="{{ route('mapa.nacional') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] transition-colors text-decoration-none">Mapa Nacional</a>
                <a href="{{ route('eventos.index') }}" class="text-sm font-semibold text-slate-700 hover:text-[#28628f] transition-colors text-decoration-none">Eventos & Festividades</a>
            </nav>

            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full border border-[#28628f]">
                            @endif
                            <span class="text-sm font-medium text-slate-700">{{ auth()->user()->name }}</span>
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-slate-200 hover:border-[#28628f] text-slate-500 hover:text-[#28628f] transition-all bg-white">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="text-xs font-semibold px-4 py-2 rounded-full border border-slate-200 hover:border-[#28628f] text-slate-600 hover:text-[#28628f] transition-all bg-white text-decoration-none">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="text-xs font-semibold px-4 py-2 rounded-full bg-[#28628f] hover:bg-[#1a4669] text-white transition-all shadow-sm text-decoration-none">Registrarse</a>
                    </div>
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
    document.addEventListener('DOMContentLoaded', function () {
    const audio = document.getElementById('global-surify-song');
    const btn = document.getElementById('global-music-btn');
    const icon = document.getElementById('global-music-icon');
    const status = document.getElementById('global-music-status');

    // Guardar el tiempo continuamente (cada segundo)
    setInterval(function () {
        if (audio && !audio.paused) {
            localStorage.setItem('surify-music-time', audio.currentTime);
            localStorage.setItem('surify-music-playing', 'true');
        }
    }, 1000);

    // Esperar a que el audio esté listo para setear el tiempo
    audio.addEventListener('loadedmetadata', function () {
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
}, { once: true });

    // Botón play/pause
    btn.addEventListener('click', function () {
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
        
        // Si la URL va al login o al registro, permitimos la navegación normal de Laravel
        if (url.includes('login') || url.includes('register')) return;
        
        e.preventDefault();
        // REMOVIDO: Se eliminó la función fantasma que rompía el hilo de ejecución
        navegarSinRecarga(url);
    });

    window.addEventListener('popstate', function() {
        navegarSinRecarga(window.location.href);
    });
</script>

</body>
</html>