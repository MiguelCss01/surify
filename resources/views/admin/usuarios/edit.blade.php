@extends('layouts.admin')

@section('title', 'Surify - Asignación de Roles')

@section('content')

{{-- Header --}}
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <div class="flex items-center gap-2 text-slate-400 mb-3 text-xs font-semibold">
            <a href="{{ route('admin.usuarios.index') }}" class="hover:text-[#28628f] transition-colors text-decoration-none">Usuarios</a>
            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
            <span class="text-[#28628f]">{{ $usuario->name }}</span>
        </div>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight" style="font-family: 'Inter', sans-serif;">Asignación de Roles</h1>
        <p class="text-slate-500 mt-2 text-sm">Gestioná los roles y accesos de <span class="font-bold text-[#28628f]">{{ $usuario->name }}</span>.</p>
    </div>
</div>

{{-- Card del usuario --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6 flex items-center justify-between flex-wrap gap-4">
    <div class="flex items-center gap-5">
        <div class="relative">
            @if($usuario->avatar)
                <img src="{{ $usuario->avatar }}" class="w-20 h-20 rounded-2xl border-2 border-[#28628f]/20 object-cover" alt="{{ $usuario->name }}">
            @else
                <div class="w-20 h-20 rounded-2xl bg-[#28628f]/10 flex items-center justify-center text-2xl font-black text-[#28628f]">
                    {{ strtoupper(substr($usuario->name, 0, 2)) }}
                </div>
            @endif
            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-white rounded-full"></div>
        </div>
        <div>
            <h2 class="text-xl font-black text-slate-800" style="font-family: 'Inter', sans-serif;">{{ $usuario->name }}</h2>
            <p class="text-sm text-slate-500 mt-0.5">{{ $usuario->email }}</p>
            <div class="flex flex-wrap gap-1 mt-2">
                @forelse($usuario->roles as $rol)
                    <span class="text-xs font-bold px-2.5 py-1 bg-[#28628f]/10 text-[#28628f] rounded-full">{{ $rol->nombre }}</span>
                @empty
                    <span class="text-xs text-slate-400 italic">Sin rol asignado</span>
                @endforelse
            </div>
        </div>
    </div>
    <div class="flex items-center gap-6 text-right">
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-0.5">Miembro desde</p>
            <p class="text-sm font-bold text-slate-700">{{ $usuario->created_at->format('d/m/Y') }}</p>
        </div>
        <div class="w-px h-10 bg-slate-200"></div>
        <div>
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-0.5">Roles activos</p>
            <p class="text-sm font-bold text-[#28628f]">{{ $usuario->roles->count() }}</p>
        </div>
    </div>
</div>

{{-- Formulario --}}
<form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-6">
        <h2 class="text-base font-black text-slate-700 mb-2 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#28628f]">admin_panel_settings</span>
            Roles Disponibles
        </h2>
        <p class="text-xs text-slate-400 mb-5">Asigná uno o más roles al usuario. Cada rol tiene sus propios permisos definidos.</p>

        @if($roles->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                @foreach($roles as $rol)
                    <label class="flex items-start gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200 hover:border-[#28628f] cursor-pointer transition-all has-[:checked]:border-[#28628f] has-[:checked]:bg-[#28628f]/5">
                        <input type="checkbox" name="roles[]" value="{{ $rol->id }}"
                            {{ in_array($rol->id, old('roles', $rolesActivos)) ? 'checked' : '' }}
                            class="mt-0.5 rounded text-[#28628f] focus:ring-[#28628f]">
                        <div class="flex-grow">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-black text-slate-700">{{ $rol->nombre }}</p>
                                <span class="text-xs font-bold text-[#28628f] bg-[#28628f]/10 px-2 py-0.5 rounded-full">
                                    {{ $rol->permisos_count }} permisos
                                </span>
                            </div>
                            @if($rol->descripcion)
                                <p class="text-xs text-slate-400 mt-1">{{ $rol->descripcion }}</p>
                            @endif
                        </div>
                    </label>
                @endforeach
            </div>
        @else
            <div class="text-center py-10">
                <span class="material-symbols-outlined text-4xl text-slate-300 block mb-2">admin_panel_settings</span>
                <p class="text-sm text-slate-400">No hay roles creados todavía.</p>
                <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-1 mt-3 text-[#28628f] font-bold text-sm hover:underline text-decoration-none">
                    <span class="material-symbols-outlined text-[16px]">add</span> Crear primer rol
                </a>
            </div>
        @endif
    </div>

    {{-- Zona de peligro --}}
    <div class="bg-white rounded-2xl border border-rose-100 shadow-sm p-6 mb-6">
        <h2 class="text-base font-black text-rose-500 mb-2 flex items-center gap-2">
            <span class="material-symbols-outlined">warning</span>
            Zona de Peligro
        </h2>
        <p class="text-xs text-slate-500 mb-4">Si quitás todos los roles, el usuario quedará como visitante sin acceso al panel.</p>
        <button type="button"
            onclick="document.querySelectorAll('input[name=\'roles[]\']').forEach(c => c.checked = false)"
            class="inline-flex items-center gap-2 border border-rose-200 text-rose-500 px-4 py-2.5 rounded-xl font-bold text-xs hover:bg-rose-50 transition-all">
            <span class="material-symbols-outlined text-[16px]">remove_moderator</span>
            Quitar todos los roles
        </button>
    </div>

    {{-- Botones --}}
    <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
        <a href="{{ route('admin.usuarios.index') }}"
           class="w-full sm:w-auto px-8 py-3 rounded-full border border-slate-200 text-slate-500 font-bold text-sm hover:bg-slate-50 transition-all text-center text-decoration-none">
            Cancelar
        </a>
        <button type="submit"
            class="w-full sm:w-auto px-10 py-3 rounded-full bg-[#28628f] text-white font-bold text-sm hover:bg-[#1a4669] transition-all shadow-sm flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[18px]">save</span>
            Guardar Cambios
        </button>
    </div>
</form>

@endsection