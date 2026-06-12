@extends('layouts.app')

@section('title', 'Surify - ' . $destino->nombre)

@section('content')

{{-- Hero --}}
<section class="relative h-[450px] w-full overflow-hidden -mx-4 sm:-mx-6 lg:-mx-8 -mt-8 mb-8">
    <img src="{{ $destino->imagen_url ?? 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=1200' }}"
         class="w-full h-full object-cover" alt="{{ $destino->nombre }}">
    <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.6));"></div>
    <div class="absolute bottom-0 left-0 p-8 max-w-3xl">
        <div class="flex items-center gap-2 mb-3">
            <a href="{{ route('provincia.show', $destino->provincia->nombre) }}"
               class="text-white/80 text-xs font-bold uppercase tracking-widest hover:text-white transition-colors text-decoration-none flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">location_on</span>
                {{ $destino->provincia->nombre ?? 'Argentina' }}
            </a>
            <span class="text-white/40">•</span>
            <span class="text-white/80 text-xs font-bold uppercase tracking-widest">{{ $destino->categoria }}</span>
        </div>
        <h1 class="text-5xl font-black text-white tracking-tight leading-none mb-3" style="font-family: 'Inter', sans-serif;">
            {{ $destino->nombre }}
        </h1>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1.5 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full border border-white/30">
                {{ $destino->rango_precio ?? '$' }}
            </span>
            @if($destino->resenas->count() > 0)
                <div class="flex items-center gap-1">
                    <span class="material-symbols-outlined text-amber-400 text-[16px]" style="font-variation-settings: 'FILL' 1;">star</span>
                    <span class="text-white text-sm font-bold">{{ number_format($destino->resenas->avg('calificacion'), 1) }}</span>
                    <span class="text-white/60 text-xs">({{ $destino->resenas->count() }} reseñas)</span>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Contenido principal --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    {{-- Columna izquierda --}}
    <div class="lg:col-span-8 flex flex-col gap-8">

        {{-- Descripción --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#28628f]">info</span>
                Sobre este destino
            </h2>
            <p class="text-slate-600 leading-relaxed">{{ $destino->descripcion }}</p>
        </section>

        {{-- Eventos --}}
        @if($destino->eventos->count() > 0)
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#28628f]">celebration</span>
                Eventos en este destino
            </h2>
            <div class="flex flex-col gap-3">
                @foreach($destino->eventos as $evento)
                <div class="flex gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200 hover:border-[#28628f] transition-colors">
                    <div class="flex flex-col items-center justify-center bg-[#28628f] text-white w-14 h-14 rounded-xl font-bold shrink-0">
                        <span class="text-[10px] uppercase font-semibold leading-none mb-0.5">{{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('M') }}</span>
                        <span class="text-lg font-black leading-none">{{ \Carbon\Carbon::parse($evento->fecha_inicio)->format('d') }}</span>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-800">{{ $evento->nombre }}</h4>
                        <p class="text-slate-400 text-xs mt-0.5">{{ $evento->descripcion }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        {{-- Reseñas --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#28628f]">rate_review</span>
                Reseñas de la Comunidad
                @if($destino->resenas->count() > 0)
                    <span class="text-sm font-normal text-slate-400">({{ $destino->resenas->count() }})</span>
                @endif
            </h2>

            @if($destino->resenas->where('aprobada', true)->count() > 0)
                <div class="flex flex-col gap-4">
                    @foreach($destino->resenas->where('aprobada', true) as $resena)
                    <div class="p-5 bg-slate-50 rounded-xl border border-slate-200">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#28628f] text-white flex items-center justify-center font-bold text-sm shrink-0 overflow-hidden">
                                @if($resena->anonima)
                                    <span class="material-symbols-outlined text-[18px]">person</span>
                                @elseif($resena->user?->avatar)
                                    <img src="{{ $resena->user->avatar }}" class="w-full h-full object-cover" alt="">
                                @else
                                    {{ strtoupper(substr($resena->user?->name ?? '?', 0, 1)) }}
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="font-bold text-slate-800 text-sm">
                                        {{ $resena->anonima ? 'Viajero Anónimo' : ($resena->user?->name ?? 'Usuario') }}
                                    </span>
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="material-symbols-outlined text-[14px] {{ $i <= $resena->calificacion ? 'text-amber-400' : 'text-slate-200' }}"
                                                  style="font-variation-settings: 'FILL' 1;">star</span>
                                        @endfor
                                    </div>
                                </div>
                                @if($resena->titulo)
                                    <p class="font-semibold text-slate-700 text-sm mb-1">{{ $resena->titulo }}</p>
                                @endif
                                <p class="text-slate-500 text-sm leading-relaxed">{{ $resena->comentario }}</p>
                                <p class="text-xs text-slate-300 mt-2">{{ $resena->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 border-2 border-dashed border-slate-200 rounded-xl">
                    <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">chat_bubble_outline</span>
                    <p class="text-slate-400 font-medium">Todavía no hay reseñas para este destino.</p>
                    <p class="text-slate-300 text-sm mt-1">¡Sé el primero en comentar!</p>
                </div>
            @endif
        </section>

    </div>

    {{-- Columna derecha --}}
    <aside class="lg:col-span-4 flex flex-col gap-6">

        {{-- Info rápida --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Información</h3>
            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#28628f] text-[20px]">location_on</span>
                    <div>
                        <p class="text-xs text-slate-400">Provincia</p>
                        <p class="text-sm font-bold text-slate-700">{{ $destino->provincia->nombre ?? '—' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#28628f] text-[20px]">category</span>
                    <div>
                        <p class="text-xs text-slate-400">Categoría</p>
                        <p class="text-sm font-bold text-slate-700">{{ $destino->categoria ?? '—' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-[#28628f] text-[20px]">payments</span>
                    <div>
                        <p class="text-xs text-slate-400">Rango de precio</p>
                        <p class="text-sm font-bold text-slate-700">{{ $destino->rango_precio ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Escribir reseña --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 text-center">
            <span class="material-symbols-outlined text-4xl text-[#28628f] block mb-3">rate_review</span>
            <h3 class="text-base font-bold text-slate-800 mb-2">¿Visitaste este lugar?</h3>
            <p class="text-slate-500 text-sm mb-5">Compartí tu experiencia con otros viajeros.</p>

            @auth
                <button onclick="document.getElementById('modal-resena-destino').classList.remove('hidden')"
                        class="bg-[#28628f] text-white px-6 py-2.5 rounded-xl font-bold hover:bg-[#1a4669] transition-all shadow-sm inline-flex items-center gap-2 w-full justify-center">
                    <span class="material-symbols-outlined text-[18px]">edit</span>
                    Escribir reseña
                </button>
            @else
                <a href="{{ route('login') }}"
                   class="bg-[#28628f] text-white px-6 py-2.5 rounded-xl font-bold hover:bg-[#1a4669] transition-all shadow-sm inline-flex items-center gap-2 w-full justify-center text-decoration-none">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    Iniciá sesión para comentar
                </a>
            @endauth
        </div>

        {{-- Volver --}}
        <a href="{{ route('provincia.show', $destino->provincia->nombre) }}"
           class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 justify-center text-decoration-none">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Volver a {{ $destino->provincia->nombre ?? 'la provincia' }}
        </a>

    </aside>
</div>

{{-- Modal reseña --}}
<div id="modal-resena-destino" class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-5 border-b border-slate-100">
            <div class="flex items-center justify-between mb-1">
                <h2 class="text-xl font-bold text-slate-800">Reseña: {{ $destino->nombre }}</h2>
                <button onclick="document.getElementById('modal-resena-destino').classList.add('hidden')"
                        class="text-slate-400 hover:text-slate-600 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <p class="text-sm text-slate-500">{{ $destino->provincia->nombre ?? '' }}</p>
        </div>

        <form action="{{ route('resenas.store') }}" method="POST" class="p-6 space-y-6">
            @csrf
            <input type="hidden" name="destino_id" value="{{ $destino->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Calificación</label>
                    <div class="flex gap-1" id="estrellas-destino">
                        @for($i = 1; $i <= 5; $i++)
                        <button type="button" onclick="setCalificacionDestino({{ $i }})"
                                class="estrella-destino material-symbols-outlined text-[32px] text-amber-400 cursor-pointer"
                                style="font-variation-settings: 'FILL' 1;" data-valor="{{ $i }}">star</button>
                        @endfor
                    </div>
                    <input type="hidden" name="calificacion" id="calificacion-destino" value="5">
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Título (opcional)</label>
                    <input type="text" name="titulo" placeholder="Resumí tu visita"
                           class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#28628f]">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Comentario</label>
                <textarea name="comentario" rows="4" required placeholder="Contá tu experiencia..."
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#28628f] resize-none"></textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="anonima" value="1" id="anonima-destino"
                       class="w-5 h-5 rounded border-slate-300 text-[#28628f]">
                <label for="anonima-destino" class="text-sm text-slate-600 cursor-pointer">Publicar de forma anónima</label>
            </div>

            <div class="flex flex-col md:flex-row-reverse gap-3">
                <button type="submit"
                        class="w-full md:w-auto px-8 py-3 bg-[#28628f] text-white font-bold rounded-xl hover:bg-[#1a4669] transition-all">
                    Publicar Reseña
                </button>
                <button type="button" onclick="document.getElementById('modal-resena-destino').classList.add('hidden')"
                        class="w-full md:w-auto px-8 py-3 border border-[#28628f] text-[#28628f] font-bold rounded-xl hover:bg-blue-50 transition-all">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function setCalificacionDestino(valor) {
    document.getElementById('calificacion-destino').value = valor;
    document.querySelectorAll('.estrella-destino').forEach(function(e) {
        const v = parseInt(e.dataset.valor);
        e.style.fontVariationSettings = v <= valor ? "'FILL' 1" : "'FILL' 0";
        e.classList.toggle('text-amber-400', v <= valor);
        e.classList.toggle('text-slate-300', v > valor);
    });
}
</script>

@endsection