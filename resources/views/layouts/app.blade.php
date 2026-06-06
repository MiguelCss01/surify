<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Surify - Turismo Nacional')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles & Scripts (Tailwind compilado localmente por Breeze/Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #0b0f19;
            color: #f3f4f6;
            font-family: 'Outfit', sans-serif;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen antialiased">

    <!-- Header / Navbar -->
    <header class="border-b border-gray-800 bg-gray-950/80 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}" class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-rose-500 to-pink-500 tracking-tight">
                    Surify🗺️
                </a>
            </div>
            
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}" class="text-sm font-medium hover:text-rose-500 transition-colors">Inicio</a>
                <a href="{{ route('mapa.nacional') }}" class="text-sm font-medium hover:text-rose-500 transition-colors">Mapa Nacional</a>
                <a href="{{ route('eventos.index') }}" class="text-sm font-medium hover:text-rose-500 transition-colors">Eventos & Festividades</a>
            </nav>

            <div class="flex items-center gap-4">
                @auth
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="w-8 h-8 rounded-full border border-rose-500">
                            @endif
                            <span class="text-sm font-medium text-gray-300">{{ auth()->user()->name }}</span>
                        </div>
                        
                        <!-- Formulario de Desconexión (Logout) de Breeze -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-xs font-semibold px-3 py-1.5 rounded-lg border border-gray-850 hover:border-rose-500 text-gray-400 hover:text-white transition-all">
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-2">
                        <a href="{{ route('login') }}" class="text-xs font-semibold px-4 py-2 rounded-full border border-gray-800 hover:border-rose-500 text-gray-350 hover:text-white transition-all">Iniciar Sesión</a>
                        <a href="{{ route('register') }}" class="text-xs font-semibold px-4 py-2 rounded-full bg-rose-600 hover:bg-rose-500 text-white transition-all">Registrarse</a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if(session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-500/10 border border-rose-500/20 text-rose-400 text-sm">
                ⚠️ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="border-t border-gray-800 bg-gray-950/60 py-8 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} Surify. Todos los derechos reservados. Desarrollado con 💖 y Laravel.</p>
        </div>
    </footer>

</body>
</html>
