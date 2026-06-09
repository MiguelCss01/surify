@extends('layouts.app')

@section('title', 'Surify - ' . ($provincia ? $provincia->nombre : $nombre))

@section('content')

<div class="antialiased min-h-screen pt-4">

    {{-- ========== HERO ========== --}}
    <section class="max-w-7xl mx-auto px-4 md:px-8 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">

            {{-- Texto izquierda --}}
            <div class="lg:col-span-5 flex flex-col gap-4">
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-[#28628f]">location_on</span>
                    <span class="text-xs font-bold uppercase tracking-widest text-[#28628f]">
                        {{ $provincia ? ($provincia->region ?? 'Argentina') : 'Argentina' }}
                    </span>
                </div>

                <h1 class="text-5xl md:text-6xl font-black text-[#28628f] tracking-tighter leading-none" style="font-family: 'Inter', sans-serif;">
                    {{ $provincia ? $provincia->nombre : $nombre }}
                </h1>

                <p class="text-base text-slate-600 leading-relaxed">
                    {{ $provincia && $provincia->descripcion
                        ? $provincia->descripcion
                        : 'Descubrí los atractivos turísticos, paisajes imponentes, gastronomía regional y festivales tradicionales que esta provincia tiene para ofrecer.' }}
                </p>

                <div class="flex gap-3 pt-2">
                    <a href="#destinos-section"
                        class="bg-[#28628f] text-white px-6 py-3 rounded-xl font-bold hover:bg-[#1a4669] transition-all shadow-sm flex items-center gap-1 text-decoration-none">
                        <span>Explorar Destinos</span>
                        <span class="material-symbols-outlined text-sm">arrow_downward</span>
                    </a>
                    <a href="{{ route('mapa.nacional') }}"
                        class="border border-[#28628f] text-[#28628f] px-6 py-3 rounded-xl font-bold hover:bg-blue-50 transition-all flex items-center gap-1 text-decoration-none">
                        <span class="material-symbols-outlined text-sm">map</span>
                        <span>Ver Mapa</span>
                    </a>
                </div>
            </div>

            {{-- Galería derecha --}}
            <div class="lg:col-span-7 grid grid-cols-2 grid-rows-2 gap-3 h-[450px]">
                <div class="col-span-2 row-span-1 rounded-2xl overflow-hidden relative group shadow-sm">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                         src="{{ $provincia && $provincia->imagen_url ? asset('storage/' . $provincia->imagen_url) : 'https://images.unsplash.com/photo-1589307775553-9f62f3a61dfc?auto=format&fit=crop&w=1200&q=80' }}"
                         alt="Banner {{ $nombre }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent"></div>
                </div>
                <div class="col-span-1 row-span-1 rounded-2xl overflow-hidden group shadow-sm bg-slate-100">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         src="{{ $destinos->count() > 0 && $destinos[0]->imagen_url ? asset('storage/' . $destinos[0]->imagen_url) : 'https://images.unsplash.com/photo-1513026705753-bc31df43b444?auto=format&fit=crop&w=600&q=80' }}"
                         alt="Detalle 1">
                </div>
                <div class="col-span-1 row-span-1 rounded-2xl overflow-hidden group shadow-sm bg-slate-100">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                         src="{{ $destinos->count() > 1 && $destinos[1]->imagen_url ? asset('storage/' . $destinos[1]->imagen_url) : 'https://images.unsplash.com/photo-1560493676-04071c5f467b?auto=format&fit=crop&w=600&q=80' }}"
                         alt="Detalle 2">
                </div>
            </div>
        </div>
    </section>

    {{-- ========== CHIPS DE CARACTERÍSTICAS ========== --}}
    <section class="bg-white border-y border-slate-200 py-6 my-4 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="max-w-xl">
                    <h2 class="text-xl font-black text-slate-800 tracking-tight mb-1">Cultura, Naturaleza e Historia</h2>
                    <p class="text-sm text-slate-500 leading-relaxed">Una experiencia integral para el explorador moderno, con datos en tiempo real.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    <div class="flex items-center gap-1.5 px-4 py-2 bg-slate-50 border border-slate-200 rounded-full shadow-sm">
                        <span class="material-symbols-outlined text-[#28628f] text-[18px]">restaurant</span>
                        <span class="text-xs font-bold text-slate-700">Gastronomía Regional</span>
                    </div>
                    <div class="flex items-center gap-1.5 px-4 py-2 bg-slate-50 border border-slate-200 rounded-full shadow-sm">
                        <span class="material-symbols-outlined text-[#28628f] text-[18px]">partly_cloudy_day</span>
                        <span class="text-xs font-bold text-slate-700">Clima en Tiempo Real</span>
                    </div>
                    <div class="flex items-center gap-1.5 px-4 py-2 bg-slate-50 border border-slate-200 rounded-full shadow-sm">
                        <span class="material-symbols-outlined text-[#28628f] text-[18px]">celebration</span>
                        <span class="text-xs font-bold text-slate-700">Festivales Oficiales</span>
                    </div>
                    <div class="flex items-center gap-1.5 px-4 py-2 bg-slate-50 border border-slate-200 rounded-full shadow-sm">
                        <span class="material-symbols-outlined text-[#28628f] text-[18px]">kayaking</span>
                        <span class="text-xs font-bold text-slate-700">Aventura</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ========== DESTINOS ========== --}}
    <section id="destinos-section" class="py-12 max-w-7xl mx-auto px-4 md:px-8">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-black text-slate-800 tracking-tight" style="font-family: 'Inter', sans-serif;">Destinos Imperdibles</h2>
            <a class="text-[#28628f] font-bold text-sm hover:underline flex items-center gap-1 text-decoration-none" href="{{ route('mapa.nacional') }}">
                <span class="material-symbols-outlined text-sm">map</span>
                <span>Ver en Mapa</span>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if(isset($destinos) && $destinos->count() > 0)
                @foreach($destinos as $destino)
                    <div class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-md hover:scale-[1.01] transition-all border border-slate-200 flex flex-col group">
                        <div class="h-60 bg-slate-100 overflow-hidden relative">
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                 src="{{ $destino->imagen_url ? asset('storage/' . $destino->imagen_url) : 'https://images.unsplash.com/photo-1544198365-f5d60b6d8190?auto=format&fit=crop&w=600&q=80' }}"
                                 alt="{{ $destino->nombre }}">
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-full font-bold text-[10px] text-slate-700 uppercase border border-slate-200 tracking-wider">
                                    {{ $destino->categoria ?? 'Turismo' }}
                                </span>
                            </div>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-lg font-bold text-slate-800 group-hover:text-[#28628f] transition-colors leading-tight">{{ $destino->nombre }}</h3>
                                <div class="flex items-center gap-0.5 text-amber-500 shrink-0 ml-2">
                                    <span class="material-symbols-outlined text-[15px]" style="font-variation-settings: 'FILL' 1;">star</span>
                                    <span class="text-sm font-bold text-slate-700">{{ $destino->rango_precio ?? '4.8' }}</span>
                                </div>
                            </div>
                            <p class="text-slate-500 text-sm mb-4 line-clamp-3 leading-relaxed">{{ $destino->descripcion }}</p>
                            <div class="mt-auto pt-3 border-t border-slate-100 flex justify-between items-center">
                                <span class="text-xs font-semibold text-slate-400 flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[14px]">location_on</span>
                                    {{ $destino->ubicacion ? 'Mapeado' : 'Ver ubicación' }}
                                </span>
                                <a class="text-[#28628f] font-bold text-xs inline-flex items-center gap-1 group-hover:translate-x-0.5 transition-transform text-decoration-none"
                                   href="{{ route('destinos.show', ['id' => $destino->id]) }}">
                                    <span>Ver Detalles</span>
                                    <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-1 md:col-span-3 bg-white border border-slate-200 p-12 rounded-2xl text-center">
                    <span class="material-symbols-outlined text-5xl text-slate-300 block mb-3">folder_open</span>
                    <p class="text-slate-400 font-medium">Todavía no hay destinos cargados para esta provincia.</p>
                    <p class="text-slate-300 text-sm mt-1">Pronto estarán disponibles.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- ========== EVENTOS + GASTRONOMÍA ========== --}}
    <section class="bg-white border-t border-slate-200 py-12">
        <div class="max-w-7xl mx-auto px-4 md:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12">

            {{-- Eventos --}}
            <div class="lg:col-span-5 flex flex-col gap-5">
                <h2 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2" style="font-family: 'Inter', sans-serif;">
                    <span class="material-symbols-outlined text-[#28628f]">celebration</span>
                    Próximos Eventos Regionales
                </h2>

                <div class="flex flex-col gap-3">
                    @if(isset($provincia) && $provincia->eventos && $provincia->eventos->count() > 0)
                        @foreach($provincia->eventos as $evento)
                            <div class="flex gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200 hover:border-[#28628f] transition-colors cursor-pointer group">
                                <div class="flex flex-col items-center justify-center bg-[#28628f] text-white w-14 h-14 rounded-xl font-bold shrink-0 shadow-sm">
                                    <span class="text-[10px] uppercase font-semibold leading-none mb-0.5">{{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('M') }}</span>
                                    <span class="text-lg font-black leading-none">{{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d') }}</span>
                                </div>
                                <div class="truncate">
                                    <h4 class="font-bold text-base text-slate-800 group-hover:text-[#28628f] transition-colors truncate">{{ $evento->nombre }}</h4>
                                    <p class="text-slate-400 text-xs mt-0.5 font-medium flex items-center gap-0.5">
                                        <span class="material-symbols-outlined text-xs">location_on</span>
                                        {{ $evento->ubicacion ?? 'Centro' }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Placeholder eventos --}}
                        @foreach([['SEP','07','Fiesta Nacional del Inmigrante','Oberá'],['NOV','14','Música Nacional del Litoral','Posadas'],['DIC','05','Fiesta de la Yerba Mate','Apóstoles']] as $ev)
                            <div class="flex gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200">
                                <div class="flex flex-col items-center justify-center bg-[#28628f] text-white w-14 h-14 rounded-xl font-bold shrink-0 shadow-sm">
                                    <span class="text-[10px] uppercase font-semibold leading-none mb-0.5">{{ $ev[0] }}</span>
                                    <span class="text-lg font-black leading-none">{{ $ev[1] }}</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-base text-slate-800">{{ $ev[2] }}</h4>
                                    <p class="text-slate-400 text-xs mt-0.5 font-medium flex items-center gap-0.5">
                                        <span class="material-symbols-outlined text-xs">location_on</span>
                                        {{ $ev[3] }}, {{ $nombre }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            {{-- Gastronomía --}}
            <div class="lg:col-span-7 flex flex-col gap-5">
                <h2 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-2" style="font-family: 'Inter', sans-serif;">
                    <span class="material-symbols-outlined text-[#28628f]">restaurant</span>
                    Sabores Locales
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if(isset($provincia) && $provincia->gastronomia && $provincia->gastronomia->count() > 0)
                        @foreach($provincia->gastronomia as $plato)
                            <div class="bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden shadow-sm flex flex-col">
                                <div class="h-36 bg-slate-200 overflow-hidden">
                                    <img src="{{ $plato->imagen_url ? asset('storage/' . $plato->imagen_url) : 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=400&q=80' }}"
                                         class="w-full h-full object-cover" alt="{{ $plato->nombre }}">
                                </div>
                                <div class="p-4 flex-grow">
                                    <h3 class="font-bold text-slate-800 text-base mb-1">{{ $plato->nombre }}</h3>
                                    <p class="text-xs text-slate-500 leading-relaxed line-clamp-3">{{ $plato->descripcion }}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Placeholder gastronomía --}}
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                            <div class="w-10 h-10 rounded-xl bg-[#28628f]/10 flex items-center justify-center mb-3">
                                <span class="material-symbols-outlined text-[#28628f]">restaurant</span>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Gastronomía Autóctona</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Descubrí los platos típicos e ingredientes locales que componen la identidad cultural y el patrimonio culinario de esta región.</p>
                        </div>
                        <div class="bg-slate-50 border border-slate-200 rounded-2xl p-5">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center mb-3">
                                <span class="material-symbols-outlined text-amber-500">local_cafe</span>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base mb-1">Platos Tradicionales</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Desde infusiones ancestrales hasta fusiones de recetas de inmigrantes europeos adaptadas a la geografía del norte argentino.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

</div>

@endsection