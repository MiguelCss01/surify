@extends('layouts.app')

@section('title', 'Surify - Inicio')

@section('content')
<div class="antialiased min-h-screen">

    <!-- ==================== HERO BANNER CON CARRUSEL DINÁMICO ==================== -->
    <section class="relative w-full h-[550px] flex items-center justify-center overflow-hidden rounded-2xl shadow-xl mx-auto max-w-7xl bg-slate-900 border border-slate-200/10">

        <!-- Contenedor del Carrusel -->
        <div id="hero-carousel" class="absolute inset-0 z-0 w-full h-full">
            @if(isset($banners) && $banners->count() > 0)
            @foreach($banners as $index => $banner)
            <img src="{{ asset('storage/' . $banner->imagen) }}"
                class="carousel-item absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 {{ $index == 0 ? 'opacity-100' : 'opacity-0' }} filter brightness-[0.65]" alt="{{ $banner->titulo }}">
            @endforeach
            @else
            <!-- CORRECCIÓN: URLs optimizadas de respaldo con compresión automática y carga garantizada -->
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?q=80&w=1920&auto=format&fit=crop" class="carousel-item absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-100 filter brightness-[0.65]" alt="Iguazú">
            <img src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?q=80&w=1920&auto=format&fit=crop" class="carousel-item absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0 filter brightness-[0.65]" alt="Perito Moreno">
            <img src="https://images.unsplash.com/photo-1606293926075-69a00dbfde81?q=80&w=1920&auto=format&fit=crop" class="carousel-item absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 opacity-0 filter brightness-[0.65]" alt="Humahuaca">
            @endif

            <!-- Degradado suave para que los textos en blanco se lean perfecto -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/30 to-transparent opacity-95"></div>
        </div>

        <!-- Contenido del Hero Banner -->
        <div class="relative z-10 w-full px-6 md:px-12 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 space-y-6">
                <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-md border border-white/30 px-3 py-1.5 rounded-full">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-white text-xs uppercase font-bold tracking-wider">Descubrimiento Expansivo</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white tracking-tighter leading-none">
                    Descubre la inmensidad de Argentina.
                </h1>
                <p class="text-lg text-slate-100 max-w-xl">
                    Desde los picos de la Patagonia hasta el trueno de Iguazú. Planifica tu viaje, descubre festivales y sumérgete en la cultura.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('mapa.nacional') }}" class="bg-[#28628f] text-white font-bold px-8 py-4 rounded-xl flex items-center justify-center space-x-2 hover:bg-[#1a4669] transition-all hover:-translate-y-0.5 active:translate-y-0 text-decoration-none shadow-md">
                        <span class="material-symbols-outlined">map</span>
                        <span>Explorar mapa</span>
                    </a>
                    <a href="{{ route('eventos.index') }}" class="bg-white/10 backdrop-blur-md border border-white/20 text-white font-bold px-8 py-4 rounded-xl flex items-center justify-center space-x-2 hover:bg-white/20 transition-all hover:-translate-y-0.5 text-decoration-none">
                        <span class="material-symbols-outlined">calendar_month</span>
                        <span>Ver calendario</span>
                    </a>
                </div>
            </div>
        </div>
    </section>
    {{-- ========== DESTINOS CERCANOS ========== --}}
    @auth
    <section class="max-w-7xl mx-auto px-6 md:px-12 py-8" id="seccion-cercanos" style="display:none;">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-3xl font-black text-slate-800 tracking-tight">Cerca de vos</h2>
                <p class="text-slate-500 text-sm mt-1" id="texto-ubicacion">Destinos turísticos cercanos a tu ubicación</p>
            </div>
            <span class="material-symbols-outlined text-rose-500 text-[28px]" style="font-variation-settings: 'FILL' 1;">location_on</span>
        </div>
        <div id="destinos-cercanos-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        </div>
    </section>
    @endauth
    <!-- ==================== CLIMA EN MODO CLARO (OPENWEATHER API) ==================== -->
    <section class="max-w-7xl mx-auto px-6 md:px-12 py-12">
        <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm backdrop-blur-xl">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-slate-800 tracking-tight">Clima actual en tiempo real</h3>
                <span class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Powered by OpenWeather</span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @if(isset($climaData))
                @foreach($climaData as $clima)
                <div class="bg-slate-50 p-4 rounded-xl flex flex-col items-center text-center border border-slate-100 hover:bg-slate-100 transition-colors cursor-pointer">
                    <span class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-2">{{ $clima['provincia'] }}</span>
                    <img src="https://openweathermap.org/img/wn/{{ $clima['icono'] }}@2x.png" class="w-12 h-12" alt="Weather icon">
                    <span class="text-2xl font-black text-slate-800">{{ round($clima['temp']) }}°C</span>
                    <span class="text-sm text-slate-600">{{ $clima['ciudad'] }}</span>
                </div>
                @endforeach
                @else
                <!-- Tarjetas Mock de Respaldo Adaptadas a Fondo Claro -->
                <div class="bg-slate-50 p-4 rounded-xl flex flex-col items-center text-center border border-slate-100 hover:bg-slate-100 transition-colors cursor-pointer">
                    <span class="text-xs text-slate-500 font-bold tracking-wider uppercase mb-1">Patagonia</span>
                    <span class="material-symbols-outlined text-3xl text-sky-600 my-2">ac_unit</span>
                    <span class="text-2xl font-bold text-slate-800">2°C</span>
                    <span class="text-xs text-slate-500">Bariloche</span>
                </div>
                <div class="bg-slate-50 p-4 rounded-xl flex flex-col items-center text-center border border-slate-100 hover:bg-slate-100 transition-colors cursor-pointer">
                    <span class="text-xs text-slate-500 font-bold tracking-wider uppercase mb-1">Cuyo</span>
                    <span class="material-symbols-outlined text-3xl text-amber-500 my-2">light_mode</span>
                    <span class="text-2xl font-bold text-slate-800">24°C</span>
                    <span class="text-xs text-slate-500">Mendoza</span>
                </div>
                <div class="bg-slate-50 p-4 rounded-xl flex flex-col items-center text-center border border-slate-100 hover:bg-slate-100 transition-colors cursor-pointer">
                    <span class="text-xs text-slate-500 font-bold tracking-wider uppercase mb-1">Norte</span>
                    <span class="material-symbols-outlined text-3xl text-amber-600 my-2">partly_cloudy_day</span>
                    <span class="text-2xl font-bold text-slate-800">28°C</span>
                    <span class="text-xs text-slate-500">Salta</span>
                </div>
                <div class="bg-slate-50 p-4 rounded-xl flex flex-col items-center text-center border border-slate-100 hover:bg-slate-100 transition-colors cursor-pointer hidden md:flex">
                    <span class="text-xs text-slate-500 font-bold tracking-wider uppercase mb-1">Pampeana</span>
                    <span class="material-symbols-outlined text-3xl text-slate-500 my-2">cloud</span>
                    <span class="text-2xl font-bold text-slate-800">18°C</span>
                    <span class="text-xs text-slate-500">Buenos Aires</span>
                </div>
                <div class="bg-slate-50 p-4 rounded-xl flex flex-col items-center text-center border border-slate-100 hover:bg-slate-100 transition-colors cursor-pointer hidden md:flex">
                    <span class="text-xs text-slate-500 font-bold tracking-wider uppercase mb-1">Litoral</span>
                    <span class="material-symbols-outlined text-3xl text-blue-600 my-2">rainy</span>
                    <span class="text-2xl font-bold text-slate-800">30°C</span>
                    <span class="text-xs text-slate-500">Misiones</span>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- ==================== REGIONES DESTACADAS EN MODO CLARO ==================== -->
    <section class="max-w-7xl mx-auto px-6 md:px-12 pb-24">
        <h2 class="text-3xl font-black text-slate-800 tracking-tight mb-2">Regiones destacadas</h2>
        <p class="text-slate-500 mb-8">Explora los paisajes más icónicos de Argentina.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @if(isset($regiones) && $regiones->count() > 0)
            @foreach($regiones as $region)
            <div class="group bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                <div class="relative h-56 overflow-hidden">
                    <img alt="{{ $region->titulo }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500" src="{{ asset('storage/' . $region->imagen) }}" />
                    <div class="absolute top-4 left-4">
                        <span class="bg-white/90 backdrop-blur-sm border border-slate-200 text-slate-800 font-semibold px-3 py-1 rounded-full text-xs">{{ $region->nombre_zona }}</span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-[#28628f] transition-colors">{{ $region->titulo }}</h3>
                    <p class="text-sm text-slate-500 line-clamp-2">{{ $region->descripcion }}</p>
                </div>
            </div>
            @endforeach
            @else
            {{-- Mostrar destinos reales de la BD --}}
            @foreach($destinos->take(6) as $destino)
            <a href="{{ route('destinos.show', $destino['id']) }}"
                class="group bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 text-decoration-none">
                <div class="h-56 overflow-hidden">
                    <img class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500"
                        src="{{ $destino['imagen_url'] ?? 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=600&q=80' }}"
                        alt="{{ $destino['nombre'] }}">
                </div>
                <div class="p-6">
                    <span class="text-xs font-bold text-[#28628f] uppercase tracking-wider">{{ $destino['provincia'] }}</span>
                    <h3 class="text-xl font-bold text-slate-800 mt-1 group-hover:text-[#28628f] transition-colors">{{ $destino['nombre'] }}</h3>
                    <p class="text-sm text-slate-500 mt-2 line-clamp-2">{{ $destino['descripcion'] }}</p>
                </div>
            </a>
            @endforeach
            @endif
        </div>
    </section>

</div>

<!-- Script único para manejar la transición automática del carrusel del Banner -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const items = document.querySelectorAll('.carousel-item');
        let currentIdx = 0;
        if (items.length > 1) {
            setInterval(() => {
                items[currentIdx].classList.remove('opacity-100');
                items[currentIdx].classList.add('opacity-0');
                currentIdx = (currentIdx + 1) % items.length;
                items[currentIdx].classList.remove('opacity-0');
                items[currentIdx].classList.add('opacity-100');
            }, 4000);
        }
    });
</script>

<script>
    var destinosData = @json($destinos);

    function calcularDistancia(lat1, lng1, lat2, lng2) {
        const R = 6371;
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLng = (lng2 - lng1) * Math.PI / 180;
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
            Math.sin(dLng / 2) * Math.sin(dLng / 2);
        return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    }

    function mostrarDestinosCercanos(lat, lng) {
        const cercanos = destinosData
            .map(d => ({
                ...d,
                distancia: calcularDistancia(lat, lng, d.lat, d.lng)
            }))
            .filter(d => d.distancia < 500)
            .sort((a, b) => a.distancia - b.distancia)
            .slice(0, 6);

        if (cercanos.length === 0) return;

        const grid = document.getElementById('destinos-cercanos-grid');
        grid.innerHTML = cercanos.map(d => `
        <a href="/destinos/${d.id}" class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:scale-[1.01] transition-all border border-slate-200 flex flex-col group text-decoration-none">
            <div class="h-48 bg-slate-100 overflow-hidden relative">
                <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                     src="${d.imagen_url ?? 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=400'}"
                     alt="${d.nombre}">
                <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-xs font-bold text-rose-500 flex items-center gap-1">
                    <span style="font-family: 'Material Symbols Outlined'; font-size:14px; font-variation-settings: 'FILL' 1;">location_on</span>
                    ${Math.round(d.distancia)} km
                </div>
                <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2 py-1 rounded-full text-[10px] font-bold text-slate-700 uppercase">
                    ${d.categoria ?? 'Turismo'}
                </div>
            </div>
            <div class="p-4 flex flex-col flex-grow">
                <h3 class="text-base font-bold text-slate-800 group-hover:text-[#28628f] transition-colors mb-1">${d.nombre}</h3>
                <p class="text-slate-500 text-xs mb-3 line-clamp-2">${d.descripcion}</p>
                <div class="mt-auto flex items-center justify-between">
                    <span class="text-xs text-slate-400">${d.provincia}</span>
                    <span class="text-[#28628f] font-bold text-xs flex items-center gap-1">
                        Ver detalles
                        <span style="font-family: 'Material Symbols Outlined'; font-size:14px;">arrow_forward</span>
                    </span>
                </div>
            </div>
        </a>
    `).join('');

        document.getElementById('seccion-cercanos').style.display = 'block';
    }

    var usuarioLogueado = @json(auth() -> check());

    if (usuarioLogueado && navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            mostrarDestinosCercanos(lat, lng);
        }, function() {
            console.log('Geolocalización no disponible o denegada');
        });
    }
</script>
@endsection