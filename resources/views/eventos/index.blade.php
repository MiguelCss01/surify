@extends('layouts.app')

@section('title', 'Surify - Eventos y Festividades')

@section('content')
<div class="max-w-[1280px] w-full mx-auto py-4">
    
    <!-- Header de la sección -->
    <div class="mb-8">
        <h1 class="text-4xl font-black text-slate-900 tracking-tighter mb-2">Festivales y Eventos</h1>
        <p class="text-base text-slate-500 max-w-2xl">Planifica tu viaje en torno a las celebraciones culturales y festividades más vibrantes de Argentina.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- ==================== SIDEBAR / LISTADO DE TARJETAS (Izquierda) ==================== -->
        <aside class="col-span-1 lg:col-span-4 flex flex-col gap-4">
            
            <!-- Selector de Mes Estético -->
            <div class="bg-slate-100 rounded-2xl p-4 flex items-center justify-between border border-slate-200/60">
                <button class="w-9 h-9 rounded-full flex items-center justify-center bg-white hover:bg-slate-50 border border-slate-200 transition-colors shadow-2xs">
                    <span class="material-symbols-outlined text-slate-500 text-sm">chevron_left</span>
                </button>
                <div class="flex flex-col items-center select-none">
                    <span class="text-[10px] font-bold text-[#28628f] uppercase tracking-widest">Calendario Anual</span>
                    <h2 class="text-lg font-black text-slate-800">Temporada 2026</h2>
                </div>
                <button class="w-9 h-9 rounded-full flex items-center justify-center bg-white hover:bg-slate-50 border border-slate-200 transition-colors shadow-2xs">
                    <span class="material-symbols-outlined text-slate-500 text-sm">chevron_right</span>
                </button>
            </div>

            <!-- Filtros Rápidos por Provincia -->
            <div class="flex gap-1.5 overflow-x-auto pb-1 scrollbar-none select-none">
                <span class="px-3 py-1.5 rounded-full bg-[#28628f] text-white font-bold text-xs whitespace-nowrap shadow-xs">Todas</span>
                <span class="px-3 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 text-xs font-semibold whitespace-nowrap">Misiones</span>
                <span class="px-3 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 text-xs font-semibold whitespace-nowrap">Córdoba</span>
                <span class="px-3 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 text-xs font-semibold whitespace-nowrap">Mendoza</span>
            </div>

            <!-- Contenedor de Tarjetas Dinámicas -->
            <div class="flex flex-col gap-3 max-h-[580px] overflow-y-auto pr-1">
                @if(isset($eventos) && $eventos->count() > 0)
                    @foreach($eventos as $index => $evento)
                        <!-- Tarjeta Dinámica de la Base de Datos -->
                        <div class="bg-white rounded-2xl p-4 border {{ $index === 0 ? 'border-[#28628f] ring-1 ring-[#28628f]/20' : 'border-slate-200' }} hover:border-[#28628f] hover:shadow-xs transition-all cursor-pointer group relative overflow-hidden">
                            @if($index === 0)
                                <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#28628f]"></div>
                            @endif
                            <div class="flex gap-4">
                                <div class="flex flex-col items-center justify-center bg-slate-50 rounded-xl w-14 h-14 shrink-0 border border-slate-200">
                                    <span class="text-[9px] font-bold text-[#28628f] uppercase leading-none mb-0.5">{{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('M') }}</span>
                                    <span class="text-base font-black text-slate-800 leading-none">{{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d') }}</span>
                                </div>
                                <div class="truncate">
                                    <span class="inline-block px-2 py-0.5 bg-slate-100 rounded-md font-bold text-[9px] text-slate-500 uppercase tracking-wider mb-1">
                                        {{ $evento->tipo ?? 'Festival' }}
                                    </span>
                                    <h3 class="text-base font-bold text-slate-800 group-hover:text-[#28628f] transition-colors truncate leading-tight">{{ $evento->nombre }}</h3>
                                    <p class="text-slate-500 text-xs mt-1 line-clamp-2 leading-relaxed">
                                        {{ $evento->descripcion ?? 'Disfruta de las celebraciones tradicionales en esta gran festividad regional.' }}
                                    </p>
                                    @if($evento->provincia)
                                        <span class="text-[10px] text-slate-400 font-medium flex items-center gap-0.5 mt-2">
                                            <span class="material-symbols-outlined text-xs text-[#28628f]">location_on</span>
                                            {{ $evento->provincia->nombre }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Mocks de Respaldo estéticos si tu compañero aún no cargó la tabla eventos -->
                    <div class="bg-white rounded-2xl p-4 border border-[#28628f] relative overflow-hidden">
                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#28628f]"></div>
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center justify-center bg-slate-50 rounded-xl w-14 h-14 shrink-0 border border-slate-200">
                                <span class="text-[9px] font-bold text-[#28628f] uppercase leading-none mb-0.5">SEP</span>
                                <span class="text-base font-black text-slate-800 leading-none">07</span>
                            </div>
                            <div>
                                <span class="inline-block px-2 py-0.5 bg-slate-100 rounded-md font-bold text-[9px] text-[#28628f] uppercase tracking-wider mb-1">Tradicional</span>
                                <h3 class="text-base font-bold text-slate-800 leading-tight">Fiesta Nacional del Inmigrante</h3>
                                <p class="text-slate-500 text-xs mt-1 line-clamp-2 leading-relaxed">Homenaje a las corrientes migratorias con platos típicos, bailes y trajes tradicionales en Oberá.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl p-4 border border-slate-200 hover:border-[#28628f] transition-all cursor-pointer">
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center justify-center bg-slate-50 rounded-xl w-14 h-14 shrink-0 border border-slate-200">
                                <span class="text-[9px] font-bold text-slate-400 uppercase leading-none mb-0.5">OCT</span>
                                <span class="text-base font-black text-slate-800 leading-none">12</span>
                            </div>
                            <div>
                                <span class="inline-block px-2 py-0.5 bg-slate-100 rounded-md font-bold text-[9px] text-slate-500 uppercase tracking-wider mb-1">Cerveza</span>
                                <h3 class="text-base font-bold text-slate-800 leading-tight">Oktoberfest Argentina</h3>
                                <p class="text-slate-500 text-xs mt-1 line-clamp-2 leading-relaxed">Villa General Belgrano se llena de tradiciones centroeuropeas, música y la mejor cerveza artesanal.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </aside>

        <!-- ==================== VISTA DEL GRID CALENDARIO (Derecha) ==================== -->
        <section class="col-span-1 lg:col-span-8">
            <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
                
                <!-- Encabezado Días de la Semana -->
                <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50 select-none">
                    <div class="py-3 text-center text-xs font-bold text-slate-400">DOM</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">LUN</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">MAR</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">MIE</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">JUE</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">VIE</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">SAB</div>
                </div>
                
                <!-- Grilla del Calendario Estático de la Maqueta -->
                <div class="grid grid-cols-7 grid-rows-5 bg-slate-200 gap-[1px]">
                    <!-- Huecos del mes anterior -->
                    <div class="bg-slate-50 min-h-[110px] p-2"></div>
                    <div class="bg-slate-50 min-h-[110px] p-2"></div>
                    
                    <!-- Días del Mes -->
                    @for($d = 1; $d <= 29; $d++)
                        @if($d == 7)
                            <!-- Día del Festival del Inmigrante (Simulado estéticamente) -->
                            <div class="bg-emerald-50/40 min-h-[110px] p-2 transition-colors relative border-2 border-emerald-500/30 cursor-pointer">
                                <span class="text-xs font-bold text-emerald-700">7</span>
                                <div class="mt-2 bg-emerald-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded truncate shadow-2xs">F. Inmigrante</div>
                            </div>
                        @elseif($d == 12)
                            <!-- Día del Oktoberfest (Simulado estéticamente) -->
                            <div class="bg-amber-50/40 min-h-[110px] p-2 transition-colors relative border-2 border-amber-500/30 cursor-pointer">
                                <span class="text-xs font-bold text-amber-700">12</span>
                                <div class="mt-2 bg-amber-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded truncate shadow-2xs">Oktoberfest</div>
                            </div>
                        @else
                            <div class="bg-white min-h-[110px] p-2 hover:bg-slate-50/80 transition-colors relative">
                                <span class="text-xs font-semibold text-slate-400">{{ $d }}</span>
                            </div>
                        @endif
                    @endfor

                    <!-- Huecos del mes siguiente -->
                    <div class="bg-slate-50 min-h-[110px] p-2"></div>
                    <div class="bg-slate-50 min-h-[110px] p-2"></div>
                </div>
            </div>
        </section>

    </div>
</div>
@endsection