@extends('layouts.app')

@section('title', 'Surify Admin - Editar Evento')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">

    {{-- Botón Volver --}}
    <div class="mb-6">
        <a href="{{ route('admin.eventos.index') }}" class="inline-flex items-center gap-1 text-slate-400 hover:text-[#28628f] text-sm font-medium transition-colors text-decoration-none">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Volver a Eventos
        </a>
    </div>

    {{-- Control de Permisos a nivel de Vista --}}
   @if(auth()->user()->hasRole('admin') || auth()->user()->hasPermiso('modificar_evento'))
    
    {{-- Encabezado --}}
    <div class="mb-8">
        <p class="text-xs font-bold uppercase tracking-widest text-amber-500 mb-1">Agenda Cultural</p>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight" style="font-family: 'Inter', sans-serif;">Editar Evento</h1>
        <p class="text-slate-500 mt-2 text-sm">Modificá los datos del festival o evento: <span class="font-bold text-[#28628f]">{{ $evento->nombre }}</span>.</p>
    </div>

    {{-- Formulario Principal --}}
    <form action="{{ route('admin.eventos.update', $evento->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">
            
            <h2 class="text-base font-black text-slate-700 mb-2 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#28628f]">info</span>
                Información Básica
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Nombre del Evento --}}
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Nombre del evento *</label>
                    <input type="text" name="nombre" value="{{ old('nombre', $evento->nombre) }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:border-[#28628f] focus:ring-1 focus:ring-[#28628f]">
                    @error('nombre') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Ubicación/Destino Vinculado --}}
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Destino asociado *</label>
                    <select name="destino_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:border-[#28628f]">
                        <option value="">Seleccioná un destino</option>
                        @foreach($destinos as $destino)
                            <option value="{{ $destino->id }}" {{ old('destino_id', $evento->destino_id) == $destino->id ? 'selected' : '' }}>
                                {{ $destino->nombre }} ({{ $destino->provincia?->nombre }})
                            </option>
                        @endforeach
                    </select>
                    @error('destino_id') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Fecha de Inicio --}}
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Fecha de inicio *</label>
                    <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $evento->fecha_inicio?->format('Y-m-d')) }}" required
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:border-[#28628f]">
                    @error('fecha_inicio') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Fecha de Fin --}}
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Fecha de fin (Opcional)</label>
                    <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $evento->fecha_fin?->format('Y-m-d')) }}"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:border-[#28628f]">
                    @error('fecha_fin') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Costo / Tipo de Entrada --}}
                <div class="space-y-1">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Entrada *</label>
                    <select name="precio_tipo" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:border-[#28628f]">
                        <option value="Gratuito" {{ old('precio_tipo', $evento->precio_tipo) == 'Gratuito' ? 'selected' : '' }}>💚 Gratuito</option>
                        <option value="Pago" {{ old('precio_tipo', $evento->precio_tipo) == 'Pago' ? 'selected' : '' }}>🔴 Pago / Con entrada</option>
                    </select>
                </div>
            </div>

            {{-- Descripción del Evento --}}
            <div class="space-y-1">
                <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Descripción del evento *</label>
                <textarea name="descripcion" rows="4" required placeholder="Contale a los turistas de qué se trata el festival, horarios, artistas principales..."
                    class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:outline-none focus:border-[#28628f] resize-none">{{ old('descripcion', $evento->descripcion) }}</textarea>
                @error('descripcion') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        {{-- Panel de Imagen --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <h2 class="text-base font-black text-slate-700 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#28628f]">image</span>
                Imagen Ilustrativa
            </h2>
            
            <div class="flex flex-col sm:flex-row items-center gap-5">
                {{-- Miniatura de imagen actual --}}
                <div class="w-32 h-24 rounded-xl bg-slate-100 overflow-hidden border border-slate-200 shrink-0 flex items-center justify-center">
                    @if($evento->imagen_url)
                        <img src="{{ asset('storage/' . $evento->imagen_url) }}" class="w-full h-full object-cover" alt="Actual">
                    @else
                        <span class="material-symbols-outlined text-slate-300 text-3xl">celebration</span>
                    @endif
                </div>
                
                {{-- Input de archivo --}}
                <div class="space-y-1 flex-1 w-full">
                    <label class="text-xs font-bold text-slate-400 uppercase tracking-wider block">Subir nueva imagen (Dejar vacío para conservar la actual)</label>
                    <input type="file" name="imagen" accept="image/*"
                        class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#28628f]">
                    @error('imagen') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Botonera de Envío --}}
        <div class="flex gap-4">
            <button type="submit"
                class="flex-1 bg-[#28628f] text-white font-bold py-3 rounded-xl hover:bg-[#1a4669] transition-all shadow-sm text-sm">
                Guardar cambios del evento
            </button>
            <a href="{{ route('admin.eventos.index') }}"
                class="px-8 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl text-sm hover:bg-slate-200 transition-all text-decoration-none text-center">
                Cancelar
            </a>
        </div>
    </form>

    @else
    {{-- Pantalla de bloqueo si simula vista de usuario o no tiene permisos --}}
    <div class="bg-white border border-slate-200 rounded-2xl p-16 text-center shadow-sm">
        <span class="material-symbols-outlined text-5xl text-amber-500 block mb-3" style="font-variation-settings: 'FILL' 1;">security</span>
        <h3 class="text-xl font-black text-slate-800">Acceso Restringido</h3>
        <p class="text-slate-400 text-sm mt-1 max-w-md mx-auto">Tu rol actual o el modo de simulación activado no te permite modificar eventos de la agenda.</p>
        <a href="{{ route('admin.eventos.index') }}" class="inline-flex items-center gap-1 mt-5 text-[#28628f] font-bold text-sm hover:underline text-decoration-none">
            Volver al listado seguro
        </a>
    </div>
    @endif

</div>
@endsection