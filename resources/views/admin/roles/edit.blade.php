@extends('layouts.app')

@section('title', 'Surify - Editar Rol')

@section('content')

<div class="mb-8">
    <a href="{{ route('admin.roles.index') }}" class="inline-flex items-center gap-1 text-slate-400 hover:text-[#28628f] text-sm font-medium transition-colors text-decoration-none mb-4">
        <span class="material-symbols-outlined text-[16px]">arrow_back</span>
        Volver a Roles
    </a>
    <h1 class="text-4xl font-black text-slate-900 tracking-tight" style="font-family: 'Inter', sans-serif;">Editar Rol</h1>
    <p class="text-slate-500 mt-2 text-sm">Modificá el nombre, descripción y permisos del rol <span class="font-bold text-[#28628f]">{{ $role->nombre }}</span>.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Formulario --}}
    <div class="lg:col-span-2">
        <form method="POST" action="{{ route('admin.roles.update', $role) }}">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                <h2 class="text-base font-black text-slate-700 mb-5 flex items-center gap-2">
                    <span class="material-symbols-outlined text-[#28628f]">info</span>
                    Información del Rol
                </h2>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Nombre del Rol *</label>
                        <input type="text" name="nombre" value="{{ old('nombre', $role->nombre) }}" required
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:ring-[#28628f] focus:border-[#28628f] @error('nombre') border-rose-400 @enderror">
                        @error('nombre')
                            <p class="text-rose-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Descripción</label>
                        <textarea name="descripcion" rows="3"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 focus:ring-[#28628f] focus:border-[#28628f]">{{ old('descripcion', $role->descripcion) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Permisos --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-base font-black text-slate-700 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[#28628f]">key</span>
                        Permisos del Rol
                    </h2>
                    <span class="text-xs font-bold text-[#28628f] bg-[#28628f]/10 px-3 py-1 rounded-full">
                        {{ count($permisosActivos) }} activos
                    </span>
                </div>
                <p class="text-xs text-slate-400 mb-5">Activá o desactivá permisos según lo que necesite este rol.</p>

                @if($permisos->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($permisos as $permiso)
                            <label class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl border border-slate-200 hover:border-[#28628f] cursor-pointer transition-all has-[:checked]:border-[#28628f] has-[:checked]:bg-[#28628f]/5">
                                <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}"
                                    {{ in_array($permiso->id, old('permisos', $permisosActivos)) ? 'checked' : '' }}
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
                    Guardar Cambios
                </button>
                <a href="{{ route('admin.roles.index') }}"
                   class="px-6 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold text-sm hover:bg-slate-200 transition-all text-decoration-none">
                    Cancelar
                </a>
            </div>
        </form>
    </div>

    {{-- Info del rol --}}
    <div class="lg:col-span-1 space-y-4">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="text-sm font-black text-slate-700 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-[#28628f] text-[18px]">group</span>
                Usuarios con este rol
            </h3>
            @if($role->users->count() > 0)
                <div class="space-y-2">
                    @foreach($role->users->take(5) as $user)
                        <div class="flex items-center gap-3">
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" class="w-8 h-8 rounded-full border border-slate-200" alt="{{ $user->name }}">
                            @else
                                <div class="w-8 h-8 rounded-full bg-[#28628f]/10 flex items-center justify-center text-xs font-bold text-[#28628f]">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            @endif
                            <span class="text-sm text-slate-700 font-medium">{{ $user->name }}</span>
                        </div>
                    @endforeach
                    @if($role->users->count() > 5)
                        <p class="text-xs text-slate-400 mt-2">+{{ $role->users->count() - 5 }} usuarios más</p>
                    @endif
                </div>
            @else
                <p class="text-sm text-slate-400">Ningún usuario tiene este rol todavía.</p>
            @endif
        </div>

        <div class="bg-slate-800 rounded-2xl p-6 text-white">
            <span class="material-symbols-outlined text-rose-400 text-3xl block mb-3">warning</span>
            <h3 class="font-black text-base mb-2">Zona de peligro</h3>
            <p class="text-slate-400 text-xs mb-4">Eliminar este rol lo quitará de todos los usuarios que lo tengan asignado.</p>
            <form method="POST" action="{{ route('admin.roles.destroy', $role) }}"
                  onsubmit="return confirm('¿Seguro que querés eliminar el rol {{ $role->nombre }}? Esta acción no se puede deshacer.')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-rose-500 hover:bg-rose-600 text-white py-2.5 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[16px]">delete</span>
                    Eliminar Rol
                </button>
            </form>
        </div>
    </div>
</div>

@endsection