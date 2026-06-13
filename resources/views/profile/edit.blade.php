@extends('layouts.app')

@section('title', 'Mi Perfil - Surify')

@section('content')

<style>
    .hero-gradient {
        background: linear-gradient(to bottom, rgba(247, 249, 252, 0.2), rgba(247, 249, 252, 1));
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(12px);
    }

    .scroll-hide::-webkit-scrollbar {
        display: none;
    }

    html {
        scroll-behavior: smooth;
    }
</style>

{{-- Hero Section --}}
<section class="relative h-[400px] w-full overflow-hidden -mx-4 sm:-mx-6 lg:-mx-8 -mt-8">
    <img id="hero-bg" src="" class="w-full h-full object-cover" alt="Hero">

    {{-- Botón cambiar portada --}}
    <button onclick="document.getElementById('modal-portada').classList.remove('hidden')"
        class="absolute top-4 right-4 z-20 bg-black/50 hover:bg-black/70 text-white text-xs font-semibold px-3 py-2 rounded-full flex items-center gap-1 transition-all">
        <span class="material-symbols-outlined text-[16px]">wallpaper</span>
        Cambiar portada
    </button>

    {{-- Botón configuración --}}
    <button onclick="abrirConfig()"
        class="absolute top-4 left-4 z-20 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-all group">
        <span id="settings-btn-icon" class="material-symbols-outlined text-[20px] transition-transform duration-500">settings</span>
    </button>

    <div class="absolute inset-0 hero-gradient"></div>
    <div class="absolute inset-0 flex flex-col items-center justify-center mt-8">

        {{-- Foto de perfil clickeable --}}
        <div class="relative group cursor-pointer" onclick="document.getElementById('avatar-input').click()">
            @if(auth()->user()->avatar)
            <img src="{{ auth()->user()->avatar }}"
                class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white object-cover shadow-2xl" alt="Avatar">
            @else
            <div class="w-32 h-32 md:w-40 md:h-40 rounded-full bg-[#28628f] text-white flex items-center justify-center text-4xl font-black border-4 border-white shadow-2xl">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            @endif
            <div class="absolute inset-0 rounded-full bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="material-symbols-outlined text-white text-3xl">photo_camera</span>
            </div>
            <div class="absolute bottom-2 right-2 bg-[#28628f] text-white rounded-full p-1 border-4 border-white">
                <span class="material-symbols-outlined text-[14px]" style="font-variation-settings: 'FILL' 1;">verified</span>
            </div>
        </div>

        {{-- Form oculto avatar --}}
        <form method="POST" action="{{ route('profile.avatar') }}" enctype="multipart/form-data" id="avatar-form">
            @csrf
            <input type="file" id="avatar-input" name="avatar" accept="image/*" class="hidden"
                onchange="document.getElementById('avatar-form').submit()">
        </form>

        <h1 class="text-3xl font-black text-slate-800 mt-3" style="font-family: 'Inter', sans-serif;">{{ auth()->user()->name }}</h1>
        <p class="text-sm text-slate-500">{{ auth()->user()->email }}</p>
        <p class="text-xs text-[#28628f] font-bold uppercase tracking-widest mt-1">
            Miembro desde {{ auth()->user()->created_at->translatedFormat('F Y') }}
        </p>
    </div>
</section>

{{-- Stats --}}
<div class="max-w-2xl mx-auto -mt-6 relative z-10 mb-8 px-4">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl p-6 grid grid-cols-3 gap-4 text-center">
        <div>
            <div class="text-2xl font-bold text-[#28628f]">0</div>
            <div class="text-xs text-slate-500 mt-1">Lugares visitados</div>
        </div>
        <div class="border-x border-slate-200">
            <div class="text-2xl font-bold text-[#28628f]">0</div>
            <div class="text-xs text-slate-500 mt-1">Reseñas publicadas</div>
        </div>
        <div>
            <div class="text-2xl font-bold text-[#28628f]">0</div>
            <div class="text-xs text-slate-500 mt-1">Fotos subidas</div>
        </div>
    </div>
</div>

{{-- Contenido principal --}}
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

    {{-- Columna izquierda --}}
    <div class="lg:col-span-8 space-y-6">

        {{-- Insignias --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-yellow-500" style="font-variation-settings: 'FILL' 1;">military_tech</span>
                Mis Insignias
            </h2>
            <div class="flex gap-4 overflow-x-auto pb-2 scroll-hide">
                @foreach([
                ['north', 'Viajero del Norte'],
                ['landscape', 'Explorador Patagónico'],
                ['forum', 'Comentador Activo'],
                ['hiking', 'Montañista Pro'],
                ['restaurant', 'Catador de Asados'],
                ] as $badge)
                <div class="flex-shrink-0 flex flex-col items-center gap-2 opacity-40 grayscale">
                    <div class="w-20 h-20 bg-slate-200 rounded-full flex items-center justify-center border-2 border-dashed border-slate-400">
                        <span class="material-symbols-outlined text-3xl text-slate-500">{{ $badge[0] }}</span>
                    </div>
                    <span class="text-xs text-slate-500 text-center max-w-[80px]">{{ $badge[1] }}</span>
                </div>
                @endforeach
            </div>
        </section>

        {{-- Lugares visitados --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-slate-800">Mis lugares visitados</h2>
                <div class="flex gap-2">
                    <button class="p-2 rounded-full border border-slate-200 hover:bg-slate-100 transition-colors"><span class="material-symbols-outlined text-sm">chevron_left</span></button>
                    <button class="p-2 rounded-full border border-slate-200 hover:bg-slate-100 transition-colors"><span class="material-symbols-outlined text-sm">chevron_right</span></button>
                </div>
            </div>
            <div class="text-center py-8 text-slate-400 text-sm border-2 border-dashed border-slate-200 rounded-xl">
                <span class="material-symbols-outlined text-3xl mb-2 block">explore</span>
                Aún no marcaste ningún destino como visitado
            </div>
        </section>

        {{-- Festividades --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-yellow-500" style="font-variation-settings: 'FILL' 1;">celebration</span>
                    Festividades
                </h2>
                <div class="flex gap-2">
                    <button class="p-2 rounded-full border border-slate-200 hover:bg-slate-100 transition-colors"><span class="material-symbols-outlined text-sm">chevron_left</span></button>
                    <button class="p-2 rounded-full border border-slate-200 hover:bg-slate-100 transition-colors"><span class="material-symbols-outlined text-sm">chevron_right</span></button>
                </div>
            </div>
            <div class="text-center py-8 text-slate-400 text-sm border-2 border-dashed border-slate-200 rounded-xl">
                <span class="material-symbols-outlined text-3xl mb-2 block">celebration</span>
                Aún no asististe a ninguna festividad
            </div>
        </section>

        {{-- Favoritos --}}
        <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-slate-800">Mis favoritos</h2>
                <div class="flex gap-2">
                    <button onclick="prevFavoritos()" class="p-2 rounded-full border border-slate-200 hover:bg-slate-100 transition-colors">
                        <span class="material-symbols-outlined text-sm">chevron_left</span>
                    </button>
                    <button onclick="nextFavoritos()" class="p-2 rounded-full border border-slate-200 hover:bg-slate-100 transition-colors">
                        <span class="material-symbols-outlined text-sm">chevron_right</span>
                    </button>
                </div>
            </div>

            @php
            $favoritos = auth()->user()->favoritos()->with('destino.provincia')->get()->filter(fn($f) => $f->destino);
            @endphp

            @if($favoritos->count() > 0)
            <div id="favoritos-container" class="grid grid-cols-2 gap-3">
                @foreach($favoritos as $index => $favorito)
                <a href="{{ route('destinos.show', $favorito->destino->id) }}"
                    class="favorito-item relative bg-slate-100 rounded-xl overflow-hidden group text-decoration-none {{ $index >= 4 ? 'hidden' : '' }}"
                    data-index="{{ $index }}">
                    <div class="h-24 overflow-hidden">
                        <img src="{{ $favorito->destino->imagen_url ?? 'https://images.unsplash.com/photo-1501854140801-50d01698950b?w=400' }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                            alt="{{ $favorito->destino->nombre }}">
                    </div>
                    <div class="p-2 flex justify-between items-center">
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 truncate">{{ $favorito->destino->nombre }}</h4>
                            <p class="text-[10px] text-slate-400">{{ $favorito->destino->provincia->nombre ?? '' }}</p>
                        </div>
                        <span class="material-symbols-outlined text-rose-500 text-[16px]" style="font-variation-settings: 'FILL' 1;">favorite</span>
                    </div>
                </a>
                @endforeach
            </div>

            <p class="text-xs text-slate-400 text-center mt-3" id="favoritos-counter">
                Mostrando 1-{{ min(4, $favoritos->count()) }} de {{ $favoritos->count() }}
            </p>
            @else
            <div class="text-center py-8 text-slate-400 text-sm border-2 border-dashed border-slate-200 rounded-xl">
                <span class="material-symbols-outlined text-3xl mb-2 block">bookmark</span>
                Aún no guardaste ningún favorito
            </div>
            @endif
        </section>

        <script>
            var favoritosActual = 0;
            var favoritosPorPagina = 4;
            var totalFavoritos = document.querySelectorAll('.favorito-item').length;

            function mostrarFavoritos() {
                document.querySelectorAll('.favorito-item').forEach(function(item) {
                    var index = parseInt(item.dataset.index);
                    if (index >= favoritosActual && index < favoritosActual + favoritosPorPagina) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
                var desde = favoritosActual + 1;
                var hasta = Math.min(favoritosActual + favoritosPorPagina, totalFavoritos);
                var counter = document.getElementById('favoritos-counter');
                if (counter) counter.textContent = 'Mostrando ' + desde + '-' + hasta + ' de ' + totalFavoritos;
            }

            function nextFavoritos() {
                if (favoritosActual + favoritosPorPagina < totalFavoritos) {
                    favoritosActual += favoritosPorPagina;
                    mostrarFavoritos();
                }
            }

            function prevFavoritos() {
                if (favoritosActual - favoritosPorPagina >= 0) {
                    favoritosActual -= favoritosPorPagina;
                    mostrarFavoritos();
                }
            }
        </script>

    </div>

    {{-- Columna derecha - Actividad --}}
    <aside class="lg:col-span-4">
        <div class="glass-card rounded-2xl border border-slate-200 shadow-md p-6 sticky top-24">
            <h2 class="text-lg font-bold text-slate-800 mb-6">Mi actividad reciente</h2>
            <div class="relative space-y-6 before:content-[''] before:absolute before:left-3 before:top-2 before:bottom-2 before:w-[2px] before:bg-slate-200">
                <div class="relative pl-10">
                    <div class="absolute left-0 top-1 w-6 h-6 rounded-full bg-[#28628f]/20 flex items-center justify-center z-10">
                        <span class="material-symbols-outlined text-[#28628f] text-[14px]" style="font-variation-settings: 'FILL' 1;">person_add</span>
                    </div>
                    <p class="text-sm text-slate-700">Cuenta creada en Surify</p>
                    <p class="text-xs text-slate-400 mt-1">{{ auth()->user()->created_at->diffForHumans() }}</p>
                </div>
            </div>
            <p class="text-xs text-slate-400 text-center mt-6">La actividad se irá registrando a medida que uses Surify</p>
        </div>
    </aside>

</div>

{{-- Modal configuración --}}
<div id="modal-configuracion" class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between p-6 border-b border-slate-100 sticky top-0 bg-white rounded-t-2xl z-10">
            <h3 class="text-lg font-bold text-[#28628f] flex items-center gap-2">
                <span class="material-symbols-outlined">settings</span>
                Configuración
            </h3>
            <button onclick="cerrarConfig()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div class="p-6 space-y-8">
            {{-- Cuenta --}}
            <section class="bg-slate-50 rounded-xl p-4 border border-slate-200 flex items-center gap-4">
                @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}" class="w-14 h-14 rounded-full object-cover border-2 border-[#28628f]/30" alt="Avatar">
                @else
                <div class="w-14 h-14 rounded-full bg-[#28628f] text-white flex items-center justify-center text-xl font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                @endif
                <div>
                    <p class="font-bold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">{{ auth()->user()->email }}</p>
                </div>
            </section>

            {{-- Información personal --}}
            <section>
                <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 px-1">Información personal</h4>
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </section>

            {{-- Cambiar contraseña --}}
            <section>
                <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 px-1">Cambiar contraseña</h4>
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </section>

            {{-- Conexiones sociales --}}
            <section>
                <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 px-1">Conexiones Sociales</h4>
                <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden divide-y divide-slate-200">
                    <div class="flex items-center justify-between p-4 hover:bg-slate-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-500">photo_camera</span>
                            <span class="text-sm text-slate-700">Instagram</span>
                        </div>
                        <button class="text-[#28628f] text-xs font-semibold hover:underline">Vincular</button>
                    </div>
                    <div class="flex items-center justify-between p-4 hover:bg-slate-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-500">terminal</span>
                            <span class="text-sm text-slate-700">X / Twitter</span>
                        </div>
                        <button class="text-[#28628f] text-xs font-semibold hover:underline">Vincular</button>
                    </div>
                    <div class="flex items-center justify-between p-4 hover:bg-slate-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-500">public</span>
                            <span class="text-sm text-slate-700">Facebook</span>
                        </div>
                        <button class="text-[#28628f] text-xs font-semibold hover:underline">Vincular</button>
                    </div>
                </div>
            </section>
            {{-- Números de emergencia --}}
            <section>
                <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 px-1">Números de Emergencia Argentina</h4>
                <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden divide-y divide-slate-200">
                    @foreach([
                    ['911', 'Policía / Emergencias', 'local_police', 'text-blue-600', 'bg-blue-50'],
                    ['100', 'Bomberos', 'local_fire_department', 'text-orange-500', 'bg-orange-50'],
                    ['107', 'SAME / Ambulancia', 'emergency', 'text-red-500', 'bg-red-50'],
                    ['144', 'Violencia de Género', 'support_agent', 'text-purple-500', 'bg-purple-50'],
                    ['102', 'Niñez y Adolescencia', 'child_care', 'text-emerald-500', 'bg-emerald-50'],
                    ['103', 'Defensa Civil', 'shield', 'text-slate-600', 'bg-slate-100'],
                    ['134', 'Gas / Fugas', 'gas_meter', 'text-yellow-600', 'bg-yellow-50'],
                    ['135', 'Centro de Asistencia al Suicida', 'psychology', 'text-pink-500', 'bg-pink-50'],
                    ] as [$numero, $descripcion, $icono, $color, $bgColor])
                    <div class="flex items-center justify-between p-4 hover:bg-slate-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg {{ $bgColor }} flex items-center justify-center">
                                <span class="material-symbols-outlined {{ $color }} text-[18px]">{{ $icono }}</span>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-slate-700">{{ $descripcion }}</p>
                                <p class="text-xs text-slate-400">Llamada gratuita las 24hs</p>
                            </div>
                        </div>
                        <a href="tel:{{ $numero }}"
                            class="text-lg font-black text-[#28628f] hover:underline">
                            {{ $numero }}
                        </a>
                    </div>
                    @endforeach
                </div>
            </section>
            {{-- Privacidad y seguridad --}}
            <section>
                <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 px-1">Privacidad & Seguridad</h4>
                <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden divide-y divide-slate-200">
                    <button class="w-full flex items-center justify-between p-4 hover:bg-slate-100 transition-colors text-left">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-500">visibility</span>
                            <div>
                                <p class="text-sm text-slate-700">Visibilidad del Perfil</p>
                                <p class="text-xs text-slate-400">Público</p>
                            </div>
                        </div>
                        <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                    </button>
                    <button class="w-full flex items-center justify-between p-4 hover:bg-slate-100 transition-colors text-left">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-500">verified_user</span>
                            <p class="text-sm text-slate-700">Autenticación de Dos Factores</p>
                        </div>
                        <span class="text-red-400 text-xs font-semibold">Desactivado</span>
                    </button>
                </div>
            </section>

            {{-- Preferencias --}}
            <section>
                <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 px-1">Preferencias</h4>
                <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden divide-y divide-slate-200">
                    <div class="p-4">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="material-symbols-outlined text-slate-500">light_mode</span>
                            <span class="text-sm text-slate-700">Tema</span>
                        </div>
                        <div class="grid grid-cols-3 gap-2">
                            <button class="py-2 px-3 rounded-lg border border-slate-300 text-slate-500 text-xs hover:border-[#28628f] transition-all theme-btn">Oscuro</button>
                            <button class="py-2 px-3 rounded-lg border border-[#28628f] bg-[#28628f]/10 text-[#28628f] text-xs font-bold transition-all theme-btn">Claro</button>
                            <button class="py-2 px-3 rounded-lg border border-slate-300 text-slate-500 text-xs hover:border-[#28628f] transition-all theme-btn">Sistema</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 hover:bg-slate-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-500">notifications</span>
                            <span class="text-sm text-slate-700">Notificaciones de festividades</span>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#28628f]"></div>
                        </label>
                    </div>
                </div>
            </section>

            {{-- Soporte --}}
            <section>
                <h4 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 px-1">Soporte</h4>
                <div class="bg-slate-50 rounded-xl border border-slate-200 overflow-hidden divide-y divide-slate-200">
                    <button class="w-full flex items-center justify-between p-4 hover:bg-slate-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-500">help_center</span>
                            <span class="text-sm text-slate-700">Centro de Ayuda</span>
                        </div>
                        <span class="material-symbols-outlined text-slate-400">open_in_new</span>
                    </button>
                    <button class="w-full flex items-center justify-between p-4 hover:bg-slate-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-500">description</span>
                            <span class="text-sm text-slate-700">Términos de Servicio</span>
                        </div>
                        <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                    </button>
                    <button class="w-full flex items-center justify-between p-4 hover:bg-slate-100 transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="material-symbols-outlined text-slate-500">policy</span>
                            <span class="text-sm text-slate-700">Política de Privacidad</span>
                        </div>
                        <span class="material-symbols-outlined text-slate-400">chevron_right</span>
                    </button>
                </div>
            </section>

            {{-- Zona de peligro --}}
            <section>
                <h4 class="text-sm font-bold text-red-400 uppercase tracking-wider mb-4 px-1">Zona de peligro</h4>
                <div class="bg-red-50 rounded-xl border border-red-100 p-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </section>

        </div>
    </div>
</div>

{{-- Modal portadas --}}
<div id="modal-portada" class="hidden fixed inset-0 z-50 bg-black/60 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-800">Elegí tu foto de portada</h3>
            <button onclick="document.getElementById('modal-portada').classList.add('hidden')"
                class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @foreach([
            ['https://señalcalafate.com/download/multimedia.normal.b4444966a274ae56.Z2xhY2lhcl9ub3JtYWwud2VicA==.webp', 'Glaciar Perito Moreno'],
            ['https://www.amerian.com/wp-content/uploads/2021/11/vista-panoramica-cataratas-pirayu-hotel-resort-puerto-iguazu-misiones-argentina.jpeg', 'Cataratas del Iguazú'],
            ['https://turismo-en-argentina.com/wp-content/uploads/2020/07/14074819238_6c00f7f002_o-1024x575.jpg', 'Cerro de los 7 Colores'],
            ['https://todopatagonia.net/wp-content/uploads/2016/10/Patagonia-Argentina.jpg.webp', 'Montañas Patagónicas'],
            ['https://cilsa.org/wp-content/uploads/2024/06/Fortin-soledad-atardecer-8-747x498.jpg', 'Bañado La Estrella'],
            ['https://turismo-en-argentina.com/wp-content/uploads/2020/07/Valle-de-la-luna-1-2-1024x576.jpg', 'Valle de la Luna'],
            ] as [$url, $nombre])
            <div class="relative cursor-pointer rounded-xl overflow-hidden border-2 border-transparent hover:border-[#28628f] transition-all"
                onclick="elegirPortada('{{ $url }}')">
                <img src="{{ $url }}" class="w-full h-24 object-cover" alt="{{ $nombre }}">
                <div class="absolute bottom-0 left-0 right-0 bg-black/50 text-white text-xs text-center py-1 font-semibold">
                    {{ $nombre }}
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    const PORTADA_DEFAULT = 'https://señalcalafate.com/download/multimedia.normal.b4444966a274ae56.Z2xhY2lhcl9ub3JtYWwud2VicA==.webp';
    const portadaGuardada = localStorage.getItem('surify-portada-{{ auth()->id() }}');
    const heroBg = document.getElementById('hero-bg');
    heroBg.src = portadaGuardada || PORTADA_DEFAULT;

    function abrirConfig() {
        const icon = document.getElementById('settings-btn-icon');
        icon.style.transform = 'rotate(180deg)';
        document.getElementById('modal-configuracion').classList.remove('hidden');
    }

    function cerrarConfig() {
        const icon = document.getElementById('settings-btn-icon');
        icon.style.transform = 'rotate(0deg)';
        document.getElementById('modal-configuracion').classList.add('hidden');
    }

    function elegirPortada(url) {
        document.getElementById('hero-bg').src = url;
        localStorage.setItem('surify-portada-{{ auth()->id() }}', url);
        document.getElementById('modal-portada').classList.add('hidden');
    }

    function mostrarFavoritos() {
        var container = document.getElementById('favoritos-container');
        container.style.opacity = '0';
        container.style.transform = 'translateX(20px)';

        setTimeout(function() {
            document.querySelectorAll('.favorito-item').forEach(function(item) {
                var index = parseInt(item.dataset.index);
                if (index >= favoritosActual && index < favoritosActual + favoritosPorPagina) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });

            container.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
            container.style.opacity = '1';
            container.style.transform = 'translateX(0)';

            var desde = favoritosActual + 1;
            var hasta = Math.min(favoritosActual + favoritosPorPagina, totalFavoritos);
            var counter = document.getElementById('favoritos-counter');
            if (counter) counter.textContent = 'Mostrando ' + desde + '-' + hasta + ' de ' + totalFavoritos;
        }, 150);
    }

    function nextFavoritos() {
        if (favoritosActual + favoritosPorPagina < totalFavoritos) {
            var container = document.getElementById('favoritos-container');
            container.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
            container.style.opacity = '0';
            container.style.transform = 'translateX(-20px)';
            favoritosActual += favoritosPorPagina;
            mostrarFavoritos();
        }
    }

    function prevFavoritos() {
        if (favoritosActual - favoritosPorPagina >= 0) {
            var container = document.getElementById('favoritos-container');
            container.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
            container.style.opacity = '0';
            container.style.transform = 'translateX(20px)';
            favoritosActual -= favoritosPorPagina;
            mostrarFavoritos();
        }
    }

    document.querySelectorAll('.group').forEach(badge => {
        badge.addEventListener('mouseenter', () => {
            badge.style.transform = 'translateY(-4px)';
        });
        badge.addEventListener('mouseleave', () => {
            badge.style.transform = 'translateY(0)';
        });
    });

    document.querySelectorAll('.theme-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.theme-btn').forEach(b => {
                b.classList.remove('border-[#28628f]', 'bg-[#28628f]/10', 'text-[#28628f]', 'font-bold');
                b.classList.add('border-slate-300', 'text-slate-500');
            });
            this.classList.remove('border-slate-300', 'text-slate-500');
            this.classList.add('border-[#28628f]', 'bg-[#28628f]/10', 'text-[#28628f]', 'font-bold');
        });
    });
</script>

@endsection