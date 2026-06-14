@extends('layouts.app')

@section('title', 'Surify - Eventos y Festividades')

@extends('layouts.app')

@section('title', 'Surify - Eventos y Festividades')

@section('content')
<div class="max-w-[1280px] w-full mx-auto py-4">

    <div class="mb-8 flex items-start justify-between">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter mb-2">Festivales y Eventos</h1>
            <p class="text-base text-slate-500 max-w-2xl">Planifica tu viaje en torno a las celebraciones culturales y festividades más vibrantes de Argentina.</p>
        </div>
        @auth
        <button onclick="document.getElementById('modal-sugerir-evento').classList.remove('hidden')"
            class="bg-[#28628f] text-white px-5 py-2.5 rounded-xl font-bold hover:bg-[#1a4669] transition-all shadow-sm flex items-center gap-2 shrink-0">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Sugerir festival
        </button>
        @endauth
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        <!-- SIDEBAR -->
        <aside class="col-span-1 lg:col-span-4 flex flex-col gap-4">

            {{-- Navegación mes --}}
            @php
            $mesAnterior = \Carbon\Carbon::create($año, $mes, 1)->subMonth();
            $mesSiguiente = \Carbon\Carbon::create($año, $mes, 1)->addMonth();
            @endphp
            <div class="bg-slate-100 rounded-2xl p-4 flex items-center justify-between border border-slate-200/60">
                <a href="{{ route('eventos.index', ['año' => $mesAnterior->year, 'mes' => $mesAnterior->month, 'provincia_id' => request('provincia_id')]) }}"
                    class="w-9 h-9 rounded-full flex items-center justify-center bg-white hover:bg-slate-50 border border-slate-200 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-slate-500 text-sm">chevron_left</span>
                </a>
                <div class="flex flex-col items-center select-none">
                    <span class="text-[10px] font-bold text-[#28628f] uppercase tracking-widest">Calendario Anual</span>
                    <h2 class="text-lg font-black text-slate-800">{{ ucfirst(\Carbon\Carbon::create($año, $mes, 1)->translatedFormat('F Y')) }}</h2>
                </div>
                <a href="{{ route('eventos.index', ['año' => $mesSiguiente->year, 'mes' => $mesSiguiente->month, 'provincia_id' => request('provincia_id')]) }}"
                    class="w-9 h-9 rounded-full flex items-center justify-center bg-white hover:bg-slate-50 border border-slate-200 transition-colors shadow-sm">
                    <span class="material-symbols-outlined text-slate-500 text-sm">chevron_right</span>
                </a>
            </div>

            {{-- Filtros provincia --}}
            <div class="flex gap-1.5 overflow-x-auto pb-1 scrollbar-none select-none">
                <a href="{{ route('eventos.index', ['año' => $año, 'mes' => $mes]) }}"
                    class="px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap {{ !request('provincia_id') ? 'bg-[#28628f] text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600' }}">
                    Todas
                </a>
                @foreach($provincias as $prov)
                <a href="{{ route('eventos.index', ['año' => $año, 'mes' => $mes, 'provincia_id' => $prov->id]) }}"
                    class="px-3 py-1.5 rounded-full text-xs font-bold whitespace-nowrap {{ request('provincia_id') == $prov->id ? 'bg-[#28628f] text-white shadow-sm' : 'bg-white border border-slate-200 text-slate-600' }}">
                    {{ $prov->nombre }}
                </a>
                @endforeach
            </div>

            {{-- Lista eventos --}}
            <div class="flex flex-col gap-3 max-h-[580px] overflow-y-auto pr-1">
                @forelse($eventos as $index => $evento)
                <div onclick="abrirModalEvento({{ $evento->id }}, '{{ addslashes($evento->nombre) }}', '{{ addslashes($evento->tipo ?? 'Festival') }}', '{{ $evento->fecha_inicio->format('d/m/Y') }}', '{{ $evento->fecha_fin ? $evento->fecha_fin->format('d/m/Y') : '' }}', '{{ addslashes($evento->descripcion ?? '') }}', '{{ addslashes($evento->imagen_url ?? '') }}', '{{ addslashes($evento->provincia->nombre ?? '') }}', '{{ addslashes($evento->destino->nombre ?? '') }}', '{{ addslashes($evento->rango_precio ?? '') }}')"
                    class="bg-white rounded-2xl p-4 border {{ $index === 0 ? 'border-[#28628f] ring-1 ring-[#28628f]/20' : 'border-slate-200' }} hover:border-[#28628f] hover:shadow-xs transition-all cursor-pointer group relative overflow-hidden">
                    @if($index === 0)
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-[#28628f]"></div>
                    @endif
                    <div class="flex gap-4">
                        <div class="flex flex-col items-center justify-center bg-slate-50 rounded-xl w-14 h-14 shrink-0 border border-slate-200">
                            <span class="text-[9px] font-bold text-[#28628f] uppercase leading-none mb-0.5">{{ $evento->fecha_inicio->translatedFormat('M') }}</span>
                            <span class="text-base font-black text-slate-800 leading-none">{{ $evento->fecha_inicio->format('d') }}</span>
                        </div>
                        <div class="truncate">
                            <span class="inline-block px-2 py-0.5 bg-slate-100 rounded-md font-bold text-[9px] text-slate-500 uppercase tracking-wider mb-1">
                                {{ $evento->tipo ?? 'Festival' }}
                            </span>
                            <h3 class="text-base font-bold text-slate-800 group-hover:text-[#28628f] transition-colors truncate leading-tight">{{ $evento->nombre }}</h3>
                            <p class="text-slate-500 text-xs mt-1 line-clamp-2 leading-relaxed">{{ $evento->descripcion ?? 'Disfruta de las celebraciones tradicionales.' }}</p>
                            @if($evento->provincia)
                            <span class="text-[10px] text-slate-400 font-medium flex items-center gap-0.5 mt-2">
                                <span class="material-symbols-outlined text-xs text-[#28628f]">location_on</span>
                                {{ $evento->provincia->nombre }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="bg-white rounded-2xl p-6 border border-slate-200 text-center text-slate-400 text-sm">
                    No hay eventos para este mes.
                </div>
                @endforelse
            </div>
        </aside>

        <!-- CALENDARIO -->
        <section class="col-span-1 lg:col-span-8">
            <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
                <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50 select-none">
                    @foreach(['DOM','LUN','MAR','MIE','JUE','VIE','SAB'] as $dia)
                    <div class="py-3 text-center text-xs font-bold text-slate-400">{{ $dia }}</div>
                    @endforeach
                </div>
                @php
                $primerDia = \Carbon\Carbon::create($año, $mes, 1);
                $diasEnMes = $primerDia->daysInMonth;
                $iniciaSemana = $primerDia->dayOfWeek; // 0=domingo
                @endphp
                <div class="grid grid-cols-7 bg-slate-200 gap-[1px]">
                    {{-- Celdas vacías al inicio --}}
                    @for($i = 0; $i < $iniciaSemana; $i++)
                        <div class="bg-slate-50 min-h-[100px] p-2">
                </div>
                @endfor

                {{-- Días del mes --}}
                @for($d = 1; $d <= $diasEnMes; $d++)
                    @php
                    $eventoDelDia=$eventos->first(function($e) use ($d) {
                    $inicio = $e->fecha_inicio->day;
                    $fin = $e->fecha_fin ? $e->fecha_fin->day : $inicio;
                    return $d >= $inicio && $d <= $fin;
                        });
                        $hoy=now()->day == $d && now()->month == $mes && now()->year == $año;
                        @endphp
                        @if($eventoDelDia)
                        <div onclick="abrirModalEvento({{ $eventoDelDia->id }}, '{{ addslashes($eventoDelDia->nombre) }}', '{{ addslashes($eventoDelDia->tipo ?? 'Festival') }}', '{{ $eventoDelDia->fecha_inicio->format('d/m/Y') }}', '{{ $eventoDelDia->fecha_fin ? $eventoDelDia->fecha_fin->format('d/m/Y') : '' }}', '{{ addslashes($eventoDelDia->descripcion ?? '') }}', '{{ addslashes($eventoDelDia->imagen_url ?? '') }}', '{{ addslashes($eventoDelDia->provincia->nombre ?? '') }}', '{{ addslashes($eventoDelDia->destino->nombre ?? '') }}', '{{ addslashes($eventoDelDia->rango_precio ?? '') }}')"
                            class="bg-emerald-50/40 min-h-[100px] p-2 border-2 border-emerald-500/30 cursor-pointer hover:bg-emerald-50 transition-colors">
                            <span class="text-xs font-bold text-emerald-700">{{ $d }}</span>
                            <div class="mt-1 bg-emerald-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded truncate">{{ Str::limit($eventoDelDia->nombre, 12) }}</div>
                        </div>
                        @else
                        <div class="bg-white min-h-[100px] p-2 hover:bg-slate-50/80 transition-colors {{ $hoy ? 'ring-2 ring-inset ring-[#28628f]' : '' }}">
                            <span class="text-xs font-semibold {{ $hoy ? 'text-[#28628f] font-black' : 'text-slate-400' }}">{{ $d }}</span>
                        </div>
                        @endif
                        @endfor

                        {{-- Celdas vacías al final --}}
                        @php $celdasRestantes = (7 - ($iniciaSemana + $diasEnMes) % 7) % 7; @endphp
                        @for($i = 0; $i < $celdasRestantes; $i++)
                            <div class="bg-slate-50 min-h-[100px] p-2">
            </div>
            @endfor
    </div>
</div>
</section>
</div>
</div>

<script>
    function abrirModalEvento(id, nombre, tipo, fechaInicio, fechaFin, descripcion, imagen, provincia, destino, precio) {
        document.getElementById('modal-evento-nombre').textContent = nombre;
        document.getElementById('modal-evento-tipo').textContent = tipo;
        document.getElementById('modal-evento-fecha-inicio').textContent = fechaInicio;
        document.getElementById('modal-evento-fecha-fin').textContent = fechaFin || '—';
        document.getElementById('modal-evento-descripcion').textContent = descripcion || 'Sin descripción disponible.';
        document.getElementById('modal-evento-precio').textContent = precio || '—';

        const provinciaEl = document.getElementById('modal-evento-provincia');
        provinciaEl.innerHTML = `<span class="material-symbols-outlined text-[14px]">location_on</span> ${provincia}`;

        const destinoEl = document.getElementById('modal-evento-destino');
        destinoEl.textContent = destino ? `• ${destino}` : '';

        const img = document.getElementById('modal-evento-img');
        img.src = imagen || 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=800';

        document.getElementById('modal-evento').classList.remove('hidden');
    }

    function previewFotosEvento(input) {
        const preview = document.getElementById('fotos-evento-preview');
        preview.innerHTML = '';
        preview.classList.remove('hidden');
        Array.from(input.files).slice(0, 3).forEach(function(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative w-24 h-24 flex-shrink-0 rounded-xl overflow-hidden border border-slate-200';
                div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
</script>

@endsection