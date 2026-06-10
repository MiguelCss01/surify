@extends('layouts.app')

@section('title')
    Surify - Festivales en {{ $provincia->nombre ?? 'Misiones' }}
@endsection

@section('content')
<main class="mx-auto py-4 space-y-12">
    <div class="pt-2">
        <!-- CORRECCIÓN: El retorno ahora viaja por 'nombre' en vez de 'slug' para emparejar con web.php -->
        <a href="{{ route('provincia.show', ['nombre' => $provincia ? $provincia->nombre : 'Misiones']) }}" class="inline-flex items-center gap-1 text-xs font-bold text-slate-400 hover:text-[#28628f] transition-colors text-decoration-none uppercase tracking-wider mb-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span>Volver a {{ $provincia->nombre ?? 'Misiones' }}</span>
        </a>
    </div>

    <header class="space-y-4">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
            <div class="space-y-1">
                <span class="text-[#28628f] font-bold text-xs tracking-widest uppercase">Argentina • {{ $provincia->nombre ?? 'Misiones' }}</span>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter leading-none">Festivales en {{ $provincia->nombre ?? 'Misiones' }}</h1>
            </div>
            <p class="text-base text-slate-500 max-w-md leading-relaxed">
                Sumergite en la vibrante cultura de la región a través de sus festividades más emblemáticas y tradicionales.
            </p>
        </div>
    </header>

    <section class="bg-slate-100 rounded-2xl p-4 border border-slate-200/60">
        <div class="flex flex-col lg:flex-row items-center gap-4">
            <div class="relative flex-grow w-full">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                <input class="w-full bg-white border border-slate-200 rounded-xl pl-12 py-3 text-sm focus:ring-2 focus:ring-[#28628f]/20 focus:border-[#28628f] placeholder:text-slate-400" placeholder="Buscar festival..." type="text"/>
            </div>
            <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto">
                <div class="flex items-center gap-1 bg-white px-4 py-2.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition-colors select-none">
                    <span class="material-symbols-outlined text-slate-400 text-sm">calendar_month</span>
                    <span class="text-xs font-bold text-slate-700">Cualquier fecha</span>
                    <span class="material-symbols-outlined text-slate-400 text-sm">expand_more</span>
                </div>
                <div class="h-8 w-[1px] bg-slate-200 hidden lg:block"></div>
                <div class="flex items-center gap-1.5 overflow-x-auto scrollbar-none whitespace-nowrap">
                    <button class="px-4 py-2 rounded-full bg-[#28628f] text-white font-bold text-xs shadow-xs">Todos</button>
                    <button class="px-4 py-2 rounded-full bg-white text-slate-600 font-semibold text-xs border border-slate-200 hover:border-[#28628f] transition-all">Música</button>
                    <button class="px-4 py-2 rounded-full bg-white text-slate-600 font-semibold text-xs border border-slate-200 hover:border-[#28628f] transition-all">Gastronomía</button>
                    <button class="px-4 py-2 rounded-full bg-white text-slate-600 font-semibold text-xs border border-slate-200 hover:border-[#28628f] transition-all">Cultura</button>
                </div>
            </div>
        </div>
    </section>

    <section class="space-y-4">
        <h2 class="text-xl font-black text-slate-800 tracking-tight">Eventos Destacados</h2>
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
            
            @if(isset($festivales) && $festivales->count() >= 2)
                @php $principal = $festivales->first(); @endphp
                <div class="md:col-span-8 group relative overflow-hidden rounded-2xl bg-slate-900 shadow-2xs hover:shadow-md transition-all duration-300 min-h-[420px] flex flex-col justify-end">
                    <img class="absolute inset-0 w-full h-full object-cover group-hover:scale-102 transition-transform duration-700 brightness-[0.7]" src="{{ asset('storage/' . $principal->imagen_url) }}" alt="{{ $principal->nombre }}">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                    <div class="p-6 space-y-3 relative z-10">
                        <div class="flex justify-between items-start gap-4">
                            <div class="space-y-1">
                                <span class="bg-white/20 backdrop-blur-md border border-white/20 px-3 py-1 rounded-full text-[10px] font-bold text-white uppercase tracking-wider">{{ $principal->localidad ?? 'Oberá' }}, {{ $provincia->nombre ?? 'Misiones' }}</span>
                                <h3 class="text-2xl font-black text-white tracking-tight">{{ $principal->nombre }}</h3>
                            </div>
                            <div class="flex items-center gap-1 bg-amber-400 text-slate-900 px-2.5 py-1 rounded-lg shrink-0">
                                <span class="material-symbols-outlined text-xs" style="font-variation-settings: 'FILL' 1;">star</span>
                                <span class="text-xs font-bold">4.9</span>
                            </div>
                        </div>
                        <p class="text-slate-200 text-sm max-w-2xl leading-relaxed">
                            {{ $principal->descripcion }}
                        </p>
                        <div class="flex items-center justify-between pt-2 border-t border-white/10">
                            <span class="flex items-center gap-1 text-slate-300 font-semibold text-xs">
                                <span class="material-symbols-outlined text-sm">calendar_today</span> 
                                {{ \Carbon\Carbon::parse($principal->fecha_inicio)->format('d M') }} - {{ \Carbon\Carbon::parse($principal->fecha_fin)->format('d M') }}
                            </span>
                            <a href="{{ route('eventos.show', ['id' => $principal->id]) }}" class="bg-white text-slate-900 px-4 py-2.5 rounded-xl font-bold text-xs hover:bg-slate-100 active:scale-95 transition-all text-decoration-none shadow-xs">Ver detalles</a>
                        </div>
                    </div>
                </div>

                @php $secundario = $festivales->skip(1)->first(); @endphp
                <div class="md:col-span-4 group relative flex flex-col rounded-2xl bg-white border border-slate-200 overflow-hidden shadow-2xs hover:shadow-md transition-all duration-300">
                    <div class="h-48 w-full overflow-hidden relative">
                        <img class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-700" src="{{ asset('storage/' . $secundario->imagen_url) }}" alt="{{ $secundario->nombre }}">
                    </div>
                    <div class="p-5 flex-grow flex flex-col gap-2 bg-white">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $secundario->localidad ?? 'Posadas' }}</span>
                        <h3 class="text-base font-bold text-slate-800 group-hover:text-[#28628f] transition-colors leading-tight">{{ $secundario->nombre }}</h3>
                        <p class="text-slate-500 text-xs line-clamp-3 leading-relaxed">
                            {{ $secundario->descripcion }}
                        </p>
                        <div class="pt-4 flex flex-col gap-2 mt-auto border-t border-slate-100">
                            <span class="flex items-center gap-1 text-slate-500 font-semibold text-xs">
                                <span class="material-symbols-outlined text-sm text-[#28628f]">calendar_today</span> 
                                {{ \Carbon\Carbon::parse($secundario->fecha_inicio)->format('d M') }}
                            </span>
                            <a href="{{ route('eventos.show', ['id' => $secundario->id]) }}" class="w-full border border-[#28628f] text-[#28628f] px-4 py-2.5 rounded-xl font-bold text-xs text-center hover:bg-[#28628f]/5 transition-colors text-decoration-none mt-1">Ver detalles</a>
                        </div>
                    </div>
                </div>
            @else
                <div class="md:col-span-8 group relative overflow-hidden rounded-2xl bg-slate-900 min-h-[400px] flex flex-col justify-end">
                    <img class="absolute inset-0 w-full h-full object-cover brightness-[0.7]" src="https://images.unsplash.com/photo-1514525253161-7a46d19cd819?q=80&w=1000&auto=format&fit=crop" alt="Fiesta del Inmigrante">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/20 to-transparent"></div>
                    <div class="p-6 space-y-2 relative z-10">
                        <span class="bg-white/20 backdrop-blur-md border border-white/20 px-3 py-1 rounded-full text-[10px] font-bold text-white uppercase tracking-wider">Oberá, {{ $provincia->nombre ?? 'Misiones' }}</span>
                        <h3 class="text-2xl font-black text-white tracking-tight">Fiesta Nacional del Inmigrante</h3>
                        <p class="text-slate-200 text-sm max-w-xl leading-relaxed">Una celebración única que rinde homenaje a las colectividades que forjaron la identidad regional con platos típicos, danzas tradicionales y ferias artesanales.</p>
                        <div class="pt-3 flex justify-between items-center border-t border-white/10">
                            <span class="text-slate-300 font-semibold text-xs">05 - 15 Septiembre</span>
                            <button class="bg-white text-slate-900 px-4 py-2 rounded-xl font-bold text-xs shadow-xs">Ver detalles</button>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-4 group relative flex flex-col rounded-2xl bg-white border border-slate-200 overflow-hidden shadow-2xs">
                    <div class="h-44 w-full overflow-hidden">
                        <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?q=80&w=600&auto=format&fit=crop" alt="Música del Litoral">
                    </div>
                    <div class="p-5 flex-grow flex flex-col gap-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Posadas</span>
                        <h3 class="text-base font-bold text-slate-800 leading-tight">Festival Nacional de la Música del Litoral</h3>
                        <p class="text-slate-500 text-xs line-clamp-3 leading-relaxed">El anfiteatro Manuel Antonio Ramírez se viste de gala a la vera del río Paraná para recibir a los máximos exponentes del folklore y el chamamé.</p>
                        <button class="w-full border border-[#28628f] text-[#28628f] px-4 py-2 rounded-xl font-bold text-xs text-center hover:bg-[#28628f]/5 transition-colors mt-auto">Ver detalles</button>
                    </div>
                </div>
            @endif

        </div>
    </section>

    <section class="space-y-4">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-black text-slate-800 tracking-tight">Próximos Eventos Regionales</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            
            <article class="group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-2xs hover:shadow-xs transition-all duration-300">
                <div class="aspect-[4/3] overflow-hidden relative bg-slate-100">
                    <img class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500" src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=600&auto=format&fit=crop" alt="Sabores de la Selva"/>
                    <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm border border-slate-200/60 px-3 py-1 rounded-full font-bold text-[10px] text-slate-600 uppercase tracking-wider">Gastronomía</div>
                </div>
                <div class="p-5 space-y-2 bg-white">
                    <h4 class="text-base font-bold text-slate-800 group-hover:text-[#28628f] transition-colors leading-tight">Sabores de la Selva</h4>
                    <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed">Feria gastronómica de vanguardia con productos autóctonos en el corazón de Puerto Iguazú.</p>
                    <div class="pt-3 flex items-center justify-between border-t border-slate-100">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-800">Puerto Iguazú</span>
                            <span class="text-slate-400 text-[11px] font-medium">15 - 17 Octubre</span>
                        </div>
                        <button class="text-[#28628f] material-symbols-outlined hover:bg-[#28628f]/5 p-2 rounded-full transition-colors">arrow_forward</button>
                    </div>
                </div>
            </article>

            <article class="group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-2xs hover:shadow-xs transition-all duration-300">
                <div class="aspect-[4/3] overflow-hidden relative bg-slate-100">
                    <img class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500" src="https://images.unsplash.com/photo-1513519245088-0e12902e5a38?q=80&w=600&auto=format&fit=crop" alt="Feria de Maestros"/>
                    <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm border border-slate-200/60 px-3 py-1 rounded-full font-bold text-[10px] text-slate-600 uppercase tracking-wider">Artesanías</div>
                </div>
                <div class="p-5 space-y-2 bg-white">
                    <h4 class="text-base font-bold text-slate-800 group-hover:text-[#28628f] transition-colors leading-tight">Feria de Maestros Artesanos</h4>
                    <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed">Exhibición internacional de obras talladas a mano en maderas nativas y cerámicas guaraníes.</p>
                    <div class="pt-3 flex items-center justify-between border-t border-slate-100">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-800">Eldorado</span>
                            <span class="text-slate-400 text-[11px] font-medium">22 - 24 Octubre</span>
                        </div>
                        <button class="text-[#28628f] material-symbols-outlined hover:bg-[#28628f]/5 p-2 rounded-full transition-colors">arrow_forward</button>
                    </div>
                </div>
            </article>

            <article class="group bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-2xs hover:shadow-xs transition-all duration-300">
                <div class="aspect-[4/3] overflow-hidden relative bg-slate-100">
                    <img class="w-full h-full object-cover group-hover:scale-103 transition-transform duration-500" src="https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?q=80&w=600&auto=format&fit=crop" alt="Carnavales Misioneros"/>
                    <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm border border-slate-200/60 px-3 py-1 rounded-full font-bold text-[10px] text-slate-600 uppercase tracking-wider">Carnaval</div>
                </div>
                <div class="p-5 space-y-2 bg-white">
                    <h4 class="text-base font-bold text-slate-800 group-hover:text-[#28628f] transition-colors leading-tight">Carnavales Misioneros</h4>
                    <p class="text-slate-500 text-xs line-clamp-2 leading-relaxed">El ritmo y las comparsas se apoderan de las calles costaneras con desfiles llenos de brillo.</p>
                    <div class="pt-3 flex items-center justify-between border-t border-slate-100">
                        <div class="flex flex-col">
                            <span class="text-xs font-bold text-slate-800">San Ignacio</span>
                            <span class="text-slate-400 text-[11px] font-medium">Febrero 2027</span>
                        </div>
                        <button class="text-[#28628f] material-symbols-outlined hover:bg-[#28628f]/5 p-2 rounded-full transition-colors">arrow_forward</button>
                    </div>
                </div>
            </article>

        </div>
    </section>
</main>
@endsection