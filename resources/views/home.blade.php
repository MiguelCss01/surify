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
                                <img alt="{{ $region->titulo }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-500" src="{{ asset('storage/' . $region->imagen) }}"/>
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
                    <!-- Tarjetas fijas de respaldo en modo claro con URLs seguras -->
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="h-56"><img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?q=80&w=600&auto=format&fit=crop"/></div>
                        <div class="p-6"><h3 class="text-xl font-bold text-slate-800">Glaciar Perito Moreno</h3><p class="text-sm text-slate-500 mt-2">Espectáculo natural de hielos eternos en la Patagonia.</p></div>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="h-56"><img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1606293926075-69a00dbfde81?q=80&w=600&auto=format&fit=crop"/></div>
                        <div class="p-6"><h3 class="text-xl font-bold text-slate-800">Quebrada de Humahuaca</h3><p class="text-sm text-slate-500 mt-2">Cerros multiculturales de colores vivos en el norte argentino.</p></div>
                    </div>
                    <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300">
                        <div class="h-56"><img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1560493676-04071c5f467b?q=80&w=600&auto=format&fit=crop"/></div>
                        <div class="p-6"><h3 class="text-xl font-bold text-slate-800">Ruta del Vino</h3><p class="text-sm text-slate-500 mt-2">Los mejores viñedos boutique a los pies de la cordillera de los Andes.</p></div>
                    </div>
                @endif
            </div>
        </section>

    </div>

    <!-- Script único para manejar la transición automática del carrusel del Banner -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const items = document.querySelectorAll('.carousel-item');
            let currentIdx = 0;
            if(items.length > 1) {
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
@endsection