@extends('layouts.app')

@section('title', 'Surify - ' . $evento->nombre)

@section('content')

{{-- Hero --}}
<section class="relative h-[450px] w-full overflow-hidden -mx-4 sm:-mx-6 lg:-mx-8 -mt-8 mb-8 rounded-3xl">
    <img src="{{ $evento->imagen_url
        ? (str_starts_with($evento->imagen_url, 'http') ? $evento->imagen_url : Storage::url($evento->imagen_url))
        : 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=1200' }}"
        class="w-full h-full object-cover" alt="{{ $evento->nombre }}">
    <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,0,0,0.1), rgba(0,0,0,0.65));"></div>
    <div class="absolute bottom-0 left-0 p-8 max-w-3xl">
        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 mb-4">
            <a href="{{ route('eventos.index') }}"
                class="text-white/70 text-xs font-bold uppercase tracking-widest hover:text-white transition-colors text-decoration-none flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">celebration</span>
                Eventos
            </a>
            @if($evento->provincia)
            <span class="text-white/40">•</span>
            <a href="{{ route('provincia.show', $evento->provincia->nombre) }}"
                class="text-white/70 text-xs font-bold uppercase tracking-widest hover:text-white transition-colors text-decoration-none">
                {{ $evento->provincia->nombre }}
            </a>
            @endif
        </div>

        {{-- Badge tipo --}}
        <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-bold rounded-full uppercase tracking-wider mb-3">
            {{ $evento->tipo ?? 'Festival' }}
        </span>

        <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight leading-none mb-4">
            {{ $evento->nombre }}
        </h1>

        <div class="flex flex-wrap items-center gap-3">
            {{-- Fechas --}}
            <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-bold rounded-full">
                <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                {{ $evento->fecha_inicio->translatedFormat('d \d\e F') }}
                @if($evento->fecha_fin && $evento->fecha_fin != $evento->fecha_inicio)
                — {{ $evento->fecha_fin->translatedFormat('d \d\e F Y') }}
                @else
                {{ $evento->fecha_inicio->translatedFormat('Y') }}
                @endif
            </span>

            {{-- Precio --}}
            @if($evento->rango_precio)
            <span class="flex items-center gap-1.5 px-3 py-1.5 bg-white/20 backdrop-blur-sm border border-white/30 text-white text-xs font-bold rounded-full">
                <span class="material-symbols-outlined text-[14px]">payments</span>
                {{ $evento->rango_precio }}
            </span>
            @endif

            {{-- Estado --}}
            @if($evento->pasado)
            <span class="px-3 py-1.5 bg-slate-500/60 text-white text-xs font-bold rounded-full">
                Evento pasado
            </span>
            @else
            <span class="px-3 py-1.5 bg-emerald-500/80 text-white text-xs font-bold rounded-full animate-pulse">
                Próximamente
            </span>
            @endif
        </div>
    </div>
</section>

{{-- Contenido --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

    {{-- Columna principal --}}
    <div class="lg:col-span-8 flex flex-col gap-6">

        {{-- Descripción --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#28628f]">info</span>
                Sobre este evento
            </h2>
            <p class="text-slate-600 leading-relaxed text-base">
                {{ $evento->descripcion ?? 'Información del evento próximamente.' }}
            </p>
        </section>

        {{-- Destino asociado --}}
        @if($evento->destino)
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-xl font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#28628f]">location_on</span>
                Dónde se realiza
            </h2>
            <a href="{{ route('destinos.show', $evento->destino->id) }}"
                class="flex items-center gap-4 p-4 bg-slate-50 rounded-xl border border-slate-200 hover:border-[#28628f] hover:shadow-sm transition-all text-decoration-none group">
                @if($evento->destino->imagen_url)
                <img src="{{ $evento->destino->imagen_url }}"
                    class="w-16 h-16 rounded-xl object-cover border border-slate-200 shrink-0" alt="{{ $evento->destino->nombre }}">
                @else
                <div class="w-16 h-16 rounded-xl bg-[#28628f]/10 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[#28628f] text-[28px]">place</span>
                </div>
                @endif
                <div>
                    <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider mb-0.5">Destino</p>
                    <h3 class="font-bold text-slate-800 group-hover:text-[#28628f] transition-colors">{{ $evento->destino->nombre }}</h3>
                    @if($evento->destino->categoria)
                    <span class="text-xs text-slate-500">{{ $evento->destino->categoria }}</span>
                    @endif
                </div>
                <span class="material-symbols-outlined text-slate-300 group-hover:text-[#28628f] ml-auto transition-colors">arrow_forward</span>
            </a>
        </section>
        @endif

        @auth
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col gap-3">
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider">Acciones</h3>

            {{-- Favorito --}}
            <button id="btn-favorito"
                onclick="toggleFavorito({{ $evento->id }})"
                class="{{ $esFavorito ?? false ? 'bg-rose-500 text-white border-rose-500' : 'bg-white text-slate-600 border-slate-200 hover:border-rose-400 hover:text-rose-500' }} w-full px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 justify-center border">
                <span id="icon-favorito" class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' {{ $esFavorito ?? false ? '1' : '0' }}">
                    favorite
                </span>
                <span id="texto-favorito">{{ $esFavorito ?? false ? 'En favoritos ♥' : 'Agregar a favoritos' }}</span>
            </button>

            {{-- Visitado --}}
            <button id="btn-visitado"
                onclick="toggleVisitado({{ $evento->id }})"
                class="{{ $esVisitado ? 'bg-emerald-500 text-white border-emerald-500' : 'bg-white text-slate-600 border-slate-200 hover:border-[#28628f] hover:text-[#28628f]' }} w-full px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 justify-center border">
                <span id="icon-visitado" class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' {{ $esVisitado ? '1' : '0' }}">
                    verified
                </span>
                <span id="texto-visitado">{{ $esVisitado ? 'Visitado ✓' : 'Marcar como visitado' }}</span>
            </button>
        </div>
        @endauth


        {{-- Compartir --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-3">Compartir evento</h3>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                <a href="https://wa.me/?text={{ urlencode('¡Mirá ' . $evento->nombre . ' en Surify! ' . url()->current()) }}"
                    target="_blank"
                    class="flex items-center justify-center gap-2 py-2.5 rounded-xl bg-green-50 border border-green-200 text-green-600 text-xs font-bold hover:bg-green-100 transition-all text-decoration-none">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.107.547 4.068 1.504 5.774L.057 23.428a.75.75 0 00.921.921l5.656-1.447A11.93 11.93 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.907 0-3.695-.504-5.243-1.387l-.375-.217-3.888.995.995-3.888-.217-.375A9.96 9.96 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                    </svg>
                    WhatsApp
                </a>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode('¡Descubrí ' . $evento->nombre . ' en Surify! 🇦🇷') }}&url={{ urlencode(url()->current()) }}"
                    target="_blank"
                    class="flex items-center justify-center gap-2 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-100 transition-all text-decoration-none">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.742l7.737-8.835L1.254 2.25H8.08l4.259 5.629 5.905-5.629zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                    </svg>
                    Twitter
                </a>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                    target="_blank"
                    class="flex items-center justify-center gap-2 py-2.5 rounded-xl bg-blue-50 border border-blue-200 text-blue-600 text-xs font-bold hover:bg-blue-100 transition-all text-decoration-none">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                    </svg>
                    Facebook
                </a>
                <button onclick="copiarLink()" id="btn-copiar"
                    class="flex items-center justify-center gap-2 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-700 text-xs font-bold hover:bg-slate-100 transition-all">
                    <span class="material-symbols-outlined text-[16px]">link</span>
                    <span id="texto-copiar">Copiar link</span>
                </button>
            </div>
        </section>
    </div>

    {{-- Sidebar --}}
    <aside class="lg:col-span-4 flex flex-col gap-6">

        {{-- Info rápida --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Información</h3>
            <div class="flex flex-col gap-4">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-[#28628f] text-[20px] mt-0.5">calendar_today</span>
                    <div>
                        <p class="text-xs text-slate-400">Fecha de inicio</p>
                        <p class="text-sm font-bold text-slate-700">{{ $evento->fecha_inicio->translatedFormat('d \d\e F \d\e Y') }}</p>
                    </div>
                </div>
                @if($evento->fecha_fin && $evento->fecha_fin != $evento->fecha_inicio)
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-[#28628f] text-[20px] mt-0.5">event</span>
                    <div>
                        <p class="text-xs text-slate-400">Fecha de fin</p>
                        <p class="text-sm font-bold text-slate-700">{{ $evento->fecha_fin->translatedFormat('d \d\e F \d\e Y') }}</p>
                    </div>
                </div>
                @endif
                @if($evento->tipo)
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-[#28628f] text-[20px] mt-0.5">category</span>
                    <div>
                        <p class="text-xs text-slate-400">Tipo</p>
                        <p class="text-sm font-bold text-slate-700">{{ $evento->tipo }}</p>
                    </div>
                </div>
                @endif
                @if($evento->provincia)
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-[#28628f] text-[20px] mt-0.5">location_on</span>
                    <div>
                        <p class="text-xs text-slate-400">Provincia</p>
                        <a href="{{ route('provincia.show', $evento->provincia->nombre) }}"
                            class="text-sm font-bold text-[#28628f] hover:underline text-decoration-none">
                            {{ $evento->provincia->nombre }}
                        </a>
                    </div>
                </div>
                @endif
                @if($evento->rango_precio)
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-[#28628f] text-[20px] mt-0.5">payments</span>
                    <div>
                        <p class="text-xs text-slate-400">Precio estimado</p>
                        <p class="text-sm font-bold text-slate-700">{{ $evento->rango_precio }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        {{-- Botones favorito y visitado --}}
        @auth
        @php
        $esFavorito = auth()->user()->favoritos->where('evento_id', $evento->id)->count() > 0;
        $esVisitado = auth()->user()->eventosVisitados->where('evento_id', $evento->id)->count() > 0;
        @endphp
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-4">
            <div class="flex items-center gap-2">
                <button id="btn-fav-evento" onclick="toggleFavoritoEvento({{ $evento->id }})"
                    class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl border-2 transition-all font-semibold text-sm
            {{ $esFavorito ? 'border-rose-400 bg-rose-50 text-rose-500' : 'border-slate-200 text-slate-400 hover:border-rose-400 hover:text-rose-400' }}">
                    <span id="icono-fav-evento" class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings: 'FILL' {{ $esFavorito ? 1 : 0 }};">favorite</span>
                    <span id="texto-fav-evento">{{ $esFavorito ? 'Guardado' : 'Favorito' }}</span>
                </button>

                <button id="btn-vis-evento" onclick="toggleVisitadoEvento({{ $evento->id }})"
                    class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl border-2 transition-all font-semibold text-sm
            {{ $esVisitado ? 'border-emerald-400 bg-emerald-50 text-emerald-500' : 'border-slate-200 text-slate-400 hover:border-emerald-400 hover:text-emerald-400' }}">
                    <span id="icono-vis-evento" class="material-symbols-outlined text-[18px]"
                        style="font-variation-settings: 'FILL' {{ $esVisitado ? 1 : 0 }};">check_circle</span>
                    <span id="texto-vis-evento">{{ $esVisitado ? 'Asistí' : 'Marcar asistido' }}</span>
                </button>
            </div>
        </div>
        @endauth

        {{-- Eventos relacionados --}}
        @if($eventosRelacionados->count() > 0)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Otros eventos</h3>
            <div class="flex flex-col gap-3">
                @foreach($eventosRelacionados as $rel)
                <a href="{{ route('eventos.show', $rel->id) }}"
                    class="flex gap-3 p-3 rounded-xl hover:bg-slate-50 border border-transparent hover:border-slate-200 transition-all text-decoration-none group">
                    <div class="flex flex-col items-center justify-center bg-slate-100 rounded-xl w-12 h-12 shrink-0 border border-slate-200">
                        <span class="text-[9px] font-bold text-[#28628f] uppercase leading-none mb-0.5">{{ $rel->fecha_inicio->translatedFormat('M') }}</span>
                        <span class="text-sm font-black text-slate-800 leading-none">{{ $rel->fecha_inicio->format('d') }}</span>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-sm font-bold text-slate-700 group-hover:text-[#28628f] transition-colors truncate">{{ $rel->nombre }}</h4>
                        <p class="text-xs text-slate-400 truncate">{{ $rel->provincia->nombre ?? '' }}</p>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Volver --}}
        <a href="{{ route('eventos.index') }}"
            class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 justify-center text-decoration-none">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Volver a Eventos
        </a>
    </aside>
</div>

<script>
    function toggleFavoritoEvento(eventoId) {
        fetch('/favoritos/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    evento_id: eventoId
                })
            })
            .then(r => r.json())
            .then(data => {
                const btn = document.getElementById('btn-fav-evento');
                const icono = document.getElementById('icono-fav-evento');
                const texto = document.getElementById('texto-fav-evento');
                if (data.favorito) {
                    btn.classList.add('border-rose-400', 'bg-rose-50', 'text-rose-500');
                    btn.classList.remove('border-slate-200', 'text-slate-400');
                    icono.style.fontVariationSettings = "'FILL' 1";
                    texto.textContent = 'Guardado';
                } else {
                    btn.classList.remove('border-rose-400', 'bg-rose-50', 'text-rose-500');
                    btn.classList.add('border-slate-200', 'text-slate-400');
                    icono.style.fontVariationSettings = "'FILL' 0";
                    texto.textContent = 'Favorito';
                }
            });
    }

    function toggleVisitadoEvento(eventoId) {
        fetch('/eventos/visitados/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    evento_id: eventoId
                })
            })
            .then(r => r.json())
            .then(data => {
                const btn = document.getElementById('btn-vis-evento');
                const icono = document.getElementById('icono-vis-evento');
                const texto = document.getElementById('texto-vis-evento');
                if (data.visitado) {
                    btn.classList.add('border-emerald-400', 'bg-emerald-50', 'text-emerald-500');
                    btn.classList.remove('border-slate-200', 'text-slate-400');
                    icono.style.fontVariationSettings = "'FILL' 1";
                    texto.textContent = 'Asistí';
                } else {
                    btn.classList.remove('border-emerald-400', 'bg-emerald-50', 'text-emerald-500');
                    btn.classList.add('border-slate-200', 'text-slate-400');
                    icono.style.fontVariationSettings = "'FILL' 0";
                    texto.textContent = 'Marcar asistido';
                }
            });
    }

    function copiarLink() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            document.getElementById('texto-copiar').textContent = '¡Copiado!';
            document.getElementById('btn-copiar').classList.add('border-emerald-300', 'bg-emerald-50', 'text-emerald-600');
            setTimeout(function() {
                document.getElementById('texto-copiar').textContent = 'Copiar link';
                document.getElementById('btn-copiar').classList.remove('border-emerald-300', 'bg-emerald-50', 'text-emerald-600');
            }, 2000);
        });
    }

    function toggleVisitado(eventoId) {
        fetch('{{ route("eventos.visitados.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    evento_id: eventoId
                })
            })
            .then(r => r.json())
            .then(data => {
                const btn = document.getElementById('btn-visitado');
                const icon = document.getElementById('icon-visitado');
                const texto = document.getElementById('texto-visitado');

                if (data.visitado) {
                    btn.className = 'bg-emerald-500 text-white border-emerald-500 w-full px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 justify-center border';
                    icon.style.fontVariationSettings = "'FILL' 1";
                    texto.textContent = 'Visitado ✓';
                } else {
                    btn.className = 'bg-white text-slate-600 border-slate-200 hover:border-[#28628f] hover:text-[#28628f] w-full px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 justify-center border';
                    icon.style.fontVariationSettings = "'FILL' 0";
                    texto.textContent = 'Marcar como visitado';
                }
            });
    }

    function toggleFavorito(eventoId) {
        fetch('{{ route("favoritos.toggle") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    evento_id: eventoId
                })
            })
            .then(r => r.json())
            .then(data => {
                const btn = document.getElementById('btn-favorito');
                const icon = document.getElementById('icon-favorito');
                const texto = document.getElementById('texto-favorito');

                if (data.favorito) {
                    btn.className = 'bg-rose-500 text-white border-rose-500 w-full px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 justify-center border';
                    icon.style.fontVariationSettings = "'FILL' 1";
                    texto.textContent = 'En favoritos ♥';
                } else {
                    btn.className = 'bg-white text-slate-600 border-slate-200 hover:border-rose-400 hover:text-rose-500 w-full px-6 py-3 rounded-xl font-bold transition-all flex items-center gap-2 justify-center border';
                    icon.style.fontVariationSettings = "'FILL' 0";
                    texto.textContent = 'Agregar a favoritos';
                }
            });
    }
</script>

@endsection