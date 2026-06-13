@extends('layouts.app')

@section('title', 'Surify - Eventos y Festividades')

@section('content')
<div class="max-w-[1280px] w-full mx-auto py-4">

    <!-- Header de la sección -->
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

            <div class="flex gap-1.5 overflow-x-auto pb-1 scrollbar-none select-none">
                <span class="px-3 py-1.5 rounded-full bg-[#28628f] text-white font-bold text-xs whitespace-nowrap shadow-xs">Todas</span>
                <span class="px-3 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 text-xs font-semibold whitespace-nowrap">Misiones</span>
                <span class="px-3 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 text-xs font-semibold whitespace-nowrap">Córdoba</span>
                <span class="px-3 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 text-xs font-semibold whitespace-nowrap">Mendoza</span>
            </div>

            <div class="flex flex-col gap-3 max-h-[580px] overflow-y-auto pr-1">
                @if(isset($eventos) && $eventos->count() > 0)
                    @foreach($eventos as $index => $evento)
                    <div onclick="abrirModalEvento({{ $evento->id }}, '{{ addslashes($evento->nombre) }}', '{{ addslashes($evento->tipo ?? 'Festival') }}', '{{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d/m/Y') }}', '{{ $evento->fecha_fin ? \Carbon\Carbon::parse($evento->fecha_fin)->format('d/m/Y') : '' }}', '{{ addslashes($evento->descripcion ?? '') }}', '{{ addslashes($evento->imagen_url ?? '') }}', '{{ addslashes($evento->provincia->nombre ?? '') }}', '{{ addslashes($evento->destino->nombre ?? '') }}', '{{ addslashes($evento->rango_precio ?? '') }}')"
                         class="bg-white rounded-2xl p-4 border {{ $index === 0 ? 'border-[#28628f] ring-1 ring-[#28628f]/20' : 'border-slate-200' }} hover:border-[#28628f] hover:shadow-xs transition-all cursor-pointer group relative overflow-hidden">
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
                @endif
            </div>
        </aside>

        <!-- CALENDARIO -->
        <section class="col-span-1 lg:col-span-8">
            <div class="bg-white rounded-2xl shadow-xs border border-slate-200 overflow-hidden">
                <div class="grid grid-cols-7 border-b border-slate-200 bg-slate-50 select-none">
                    <div class="py-3 text-center text-xs font-bold text-slate-400">DOM</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">LUN</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">MAR</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">MIE</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">JUE</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">VIE</div>
                    <div class="py-3 text-center text-xs font-bold text-slate-400">SAB</div>
                </div>
                <div class="grid grid-cols-7 grid-rows-5 bg-slate-200 gap-[1px]">
                    <div class="bg-slate-50 min-h-[110px] p-2"></div>
                    <div class="bg-slate-50 min-h-[110px] p-2"></div>
                    @for($d = 1; $d <= 29; $d++)
                        @php
                            $eventoDelDia = isset($eventos) ? $eventos->first(function($e) use ($d) {
                                return \Carbon\Carbon::parse($e->fecha_inicio)->day == $d;
                            }) : null;
                        @endphp
                        @if($eventoDelDia)
                            <div onclick="abrirModalEvento({{ $eventoDelDia->id }}, '{{ addslashes($eventoDelDia->nombre) }}', '{{ addslashes($eventoDelDia->tipo ?? 'Festival') }}', '{{ \Carbon\Carbon::parse($eventoDelDia->fecha_inicio)->format('d/m/Y') }}', '{{ $eventoDelDia->fecha_fin ? \Carbon\Carbon::parse($eventoDelDia->fecha_fin)->format('d/m/Y') : '' }}', '{{ addslashes($eventoDelDia->descripcion ?? '') }}', '{{ addslashes($eventoDelDia->imagen_url ?? '') }}', '{{ addslashes($eventoDelDia->provincia->nombre ?? '') }}', '{{ addslashes($eventoDelDia->destino->nombre ?? '') }}', '{{ addslashes($eventoDelDia->rango_precio ?? '') }}')"
                                 class="bg-emerald-50/40 min-h-[110px] p-2 transition-colors relative border-2 border-emerald-500/30 cursor-pointer hover:bg-emerald-50">
                                <span class="text-xs font-bold text-emerald-700">{{ $d }}</span>
                                <div class="mt-2 bg-emerald-600 text-white text-[10px] font-bold px-1.5 py-0.5 rounded truncate shadow-2xs">{{ Str::limit($eventoDelDia->nombre, 12) }}</div>
                            </div>
                        @else
                            <div class="bg-white min-h-[110px] p-2 hover:bg-slate-50/80 transition-colors relative">
                                <span class="text-xs font-semibold text-slate-400">{{ $d }}</span>
                            </div>
                        @endif
                    @endfor
                    <div class="bg-slate-50 min-h-[110px] p-2"></div>
                    <div class="bg-slate-50 min-h-[110px] p-2"></div>
                </div>
            </div>
        </section>
    </div>
</div>

{{-- Modal detalle evento --}}
<div id="modal-evento" class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">

        {{-- Imagen --}}
        <div class="relative h-56 bg-slate-200 rounded-t-2xl overflow-hidden">
            <img id="modal-evento-img" src="" alt="" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <button onclick="document.getElementById('modal-evento').classList.add('hidden')"
                    class="absolute top-4 right-4 bg-black/40 hover:bg-black/60 text-white rounded-full p-1.5 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
            <div class="absolute bottom-4 left-4">
                <span id="modal-evento-tipo" class="bg-white/20 backdrop-blur-sm text-white text-xs font-bold px-3 py-1 rounded-full border border-white/30"></span>
            </div>
        </div>

        <div class="p-6 space-y-4">
            <div>
                <h2 id="modal-evento-nombre" class="text-2xl font-black text-slate-800 tracking-tight"></h2>
                <div class="flex items-center gap-3 mt-2 flex-wrap">
                    <span id="modal-evento-provincia" class="text-xs font-semibold text-[#28628f] flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">location_on</span>
                    </span>
                    <span id="modal-evento-destino" class="text-xs text-slate-400"></span>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Fecha inicio</p>
                    <p id="modal-evento-fecha-inicio" class="text-sm font-bold text-slate-700"></p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Fecha fin</p>
                    <p id="modal-evento-fecha-fin" class="text-sm font-bold text-slate-700">—</p>
                </div>
                <div class="bg-slate-50 rounded-xl p-3 border border-slate-100">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Precio</p>
                    <p id="modal-evento-precio" class="text-sm font-bold text-slate-700">—</p>
                </div>
            </div>

            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2">Descripción</p>
                <p id="modal-evento-descripcion" class="text-sm text-slate-600 leading-relaxed"></p>
            </div>
        </div>
    </div>
</div>

{{-- Modal sugerir festival --}}
<div id="modal-sugerir-evento" class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">

        <div class="px-6 py-5 border-b border-slate-100 bg-slate-50 rounded-t-2xl">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-slate-800">Sugerir un Festival</h2>
                <button onclick="document.getElementById('modal-sugerir-evento').classList.add('hidden')"
                        class="text-slate-400 hover:text-slate-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <p class="text-sm text-slate-500 mt-1">Tu sugerencia será revisada por el equipo antes de publicarse.</p>
        </div>

        <form action="{{ route('eventos.sugerir') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Nombre del festival *</label>
                    <input type="text" name="nombre" required placeholder="Ej: Fiesta de la Vendimia"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#28628f]">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Tipo</label>
                    <select name="tipo" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#28628f]">
                        <option value="Cultural">Cultural</option>
                        <option value="Musical">Musical</option>
                        <option value="Gastronómico">Gastronómico</option>
                        <option value="Deportivo">Deportivo</option>
                        <option value="Tradicional">Tradicional</option>
                        <option value="Religioso">Religioso</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Fecha inicio *</label>
                    <input type="date" name="fecha_inicio" required
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#28628f]">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Fecha fin</label>
                    <input type="date" name="fecha_fin"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#28628f]">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Provincia</label>
                <select name="provincia_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#28628f]">
                    <option value="">Seleccioná una provincia</option>
                    @foreach(\App\Models\Provincia::orderBy('nombre')->get() as $prov)
                        <option value="{{ $prov->id }}">{{ $prov->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Rango de precio</label>
                <div class="flex gap-2">
                    @foreach(['$' => 'Gratuito / Bajo', '$$' => 'Medio', '$$$' => 'Alto'] as $valor => $etiqueta)
                    <label class="flex-1 cursor-pointer">
                        <input type="radio" name="rango_precio" value="{{ $valor }}" class="sr-only peer">
                        <div class="text-center py-2 rounded-xl border-2 border-slate-200 text-xs font-bold text-slate-500 peer-checked:border-[#28628f] peer-checked:text-[#28628f] peer-checked:bg-[#28628f]/5 transition-all">
                            {{ $valor }} {{ $etiqueta }}
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Descripción *</label>
                <textarea name="descripcion" rows="4" required
                          placeholder="Contá de qué trata el festival, qué actividades hay, por qué vale la pena visitarlo..."
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#28628f] resize-none"></textarea>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Fotos (opcional)</label>
                <div onclick="document.getElementById('fotos-evento-input').click()"
                     class="border-2 border-dashed border-slate-200 rounded-xl p-6 flex flex-col items-center justify-center bg-slate-50 hover:bg-slate-100 transition-colors cursor-pointer">
                    <span class="material-symbols-outlined text-[#28628f] text-[32px] mb-2">upload_file</span>
                    <p class="text-sm font-semibold text-slate-700">Subí fotos del festival</p>
                    <p class="text-xs text-slate-400 mt-1">Hasta 3 fotos</p>
                </div>
                <input type="file" id="fotos-evento-input" name="imagenes[]" multiple accept="image/*"
                       class="hidden" onchange="previewFotosEvento(this)">
                <div id="fotos-evento-preview" class="flex gap-3 overflow-x-auto pb-2 mt-2 hidden"></div>
            </div>

            <div class="flex flex-col md:flex-row-reverse gap-3 pt-2">
                <button type="submit"
                        class="w-full md:w-auto px-8 py-3 bg-[#28628f] text-white font-bold rounded-full hover:bg-[#1a4669] transition-all shadow-md">
                    Enviar sugerencia
                </button>
                <button type="button" onclick="document.getElementById('modal-sugerir-evento').classList.add('hidden')"
                        class="w-full md:w-auto px-8 py-3 border border-[#28628f] text-[#28628f] font-bold rounded-full hover:bg-blue-50 transition-all">
                    Cancelar
                </button>
            </div>
        </form>
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