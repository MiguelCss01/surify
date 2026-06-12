@extends('layouts.admin')

@section('title', 'Surify - Crear Rol')

@section('content')

<div class="mb-8">
    <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center gap-1 text-slate-400 hover:text-[#28628f] text-sm font-medium transition-colors text-decoration-none mb-4">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
        Volver a Roles
    </a>
    <h1 class="text-4xl font-black text-slate-900 tracking-tight" style="font-family: 'Inter', sans-serif;">Crear Nuevo Rol</h1>
    <p class="text-slate-500 mt-2 text-sm">Definí el nombre, descripción y permisos del nuevo rol.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Formulario --}}
    <div class="lg:col-span-2">
        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                <h2 class="text-base font-black text-slate-700 mb-5 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#28628f]">info</span>
                    Información del Rol
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Nombre del Rol *</label>
                        <input type="text" name="nombre" value="{{ old('nombre') }}" required
                            placeholder="Ej: AdminReseñas, EditorDestinos..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:ring-[#28628f] focus:border-[#28628f] @error('nombre') border-rose-400 @enderror">
                        @error('nombre')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Descripción</label>
                        <textarea name="descripcion" rows="3"
                            placeholder="Describí qué puede hacer este rol..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:ring-[#28628f] focus:border-[#28628f]">{{ old('descripcion') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Permisos --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                <h2 class="text-base font-black text-slate-700 mb-2 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#28628f]">key</span>
                    Permisos del Rol
                </h2>
                <p class="text-xs text-slate-400 mb-5">Seleccioná los permisos que va a tener este rol. Podés modificarlos en cualquier momento.</p>

                @if($permisos->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($permisos as $permiso)
                            <label class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200 hover:border-[#28628f] cursor-pointer transition-all has-[:checked]:border-[#28628f] has-[:checked]:bg-[#28628f]/5">
                                <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}"
                                    {{ in_array($permiso->id, old('permisos', [])) ? 'checked' : '' }}
                                    class="mt-0.5 rounded text-[#28628f] focus:ring-[#28628f]">
                                <div>
                                    <p class="text-sm font-bold text-slate-700">{{ $permiso->nombre }}</p>
                                    @if($permiso->descripcion)
                                        <p class="text-xs text-slate-400 mt-0.5">{{ $permiso->descripcion }}</p>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-slate-400">
                        <span class="material-symbols-outlined text-4xl block mb-2 text-slate-300">key_off</span>
                        <p class="text-sm">No hay permisos cargados todavía.</p>
                    </div>
                @endif
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="flex-1 bg-[#28628f] text-white py-3 rounded-xl font-bold text-sm hover:bg-[#1a4669] transition-all shadow-sm">
                    Crear Rol
                </button>
                <a href="{{ route('admin.roles.index') }}"
                   class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-all text-decoration-none">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    {{-- Tip panel --}}
    <div class="lg:col-span-1">
        <div class="bg-slate-800 rounded-2xl p-6 text-white sticky top-24">
            <span class="material-symbols-outlined text-amber-400 text-3xl block mb-3">lightbulb</span>
            <h3 class="font-black text-base mb-3">Tips para crear roles</h3>
            <ul class="space-y-3 text-sm text-slate-300">
                <li class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-[16px] text-[#28628f] mt-0.5 shrink-0">check_circle</span>
                    Usá nombres descriptivos como <span class="text-white font-bold">AdminReseñas</span> o <span class="text-white font-bold">EditorDestinos</span>.
                </li>
                <li class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-[16px] text-[#28628f] mt-0.5 shrink-0">check_circle</span>
                    Asigná solo los permisos necesarios — podés agregarle más después.
                </li>
                <li class="flex items-start gap-2">
                    <span class="material-symbols-outlined text-[16px] text-[#28628f] mt-0.5 shrink-0">check_circle</span>
                    Los permisos se pueden activar o desactivar desde "Editar Permisos" en cualquier momento.
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection