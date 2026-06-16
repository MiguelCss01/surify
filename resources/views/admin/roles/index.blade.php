@extends('layouts.admin')

@section('title', 'Surify - Gestión de Roles')

@section('content')

<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <p class="text-xs font-bold uppercase tracking-widest text-[#28628f] mb-1">Administración de Accesos</p>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight" style="font-family: 'Inter', sans-serif;">Roles y Permisos</h1>
        <p class="text-slate-500 mt-2 text-sm max-w-xl">Definí niveles de acceso y gestioná los permisos de cada rol dentro de la plataforma Surify.</p>
    </div>
    <a href="{{ route('admin.roles.create') }}"
       class="inline-flex items-center gap-2 bg-[#28628f] text-white px-5 py-3 rounded-xl font-bold text-sm hover:bg-[#1a4669] transition-all shadow-sm shrink-0 text-decoration-none">
        <span class="material-symbols-outlined text-[18px]">add_circle</span>
        Nuevo Rol
    </a>
</div>

{{-- Métricas --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Total Roles</p>
        <p class="text-4xl font-black text-[#28628f]">{{ str_pad($roles->count(), 2, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Usuarios Activos</p>
        <p class="text-4xl font-black text-amber-500">{{ str_pad($totalUsuarios, 2, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <p class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">Permisos Totales</p>
        <p class="text-4xl font-black text-slate-700">{{ str_pad($totalPermisos, 2, '0', STR_PAD_LEFT) }}</p>
    </div>
    <div class="bg-[#28628f]/5 rounded-2xl border border-[#28628f]/20 p-5 flex items-center justify-center">
        <div class="text-center">
            <span class="material-symbols-outlined text-[#28628f] text-4xl block mb-1" style="font-variation-settings: 'FILL' 1;">security</span>
            <p class="text-[#28628f] text-xs font-bold">Sistema Seguro</p>
        </div>
    </div>
</div>

{{-- Grid de roles --}}
<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6 mb-10">
    @forelse($roles as $rol)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 hover:shadow-md hover:-translate-y-1 transition-all group">
            <div class="flex justify-between items-start mb-5">
                <div class="w-14 h-14 bg-[#28628f]/10 text-[#28628f] rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-3xl" style="font-variation-settings: 'FILL' 1;">admin_panel_settings</span>
                </div>
                <span class="bg-slate-100 text-slate-500 px-3 py-1 rounded-full text-xs font-bold border border-slate-200">
                    {{ $rol->users_count }} {{ $rol->users_count === 1 ? 'usuario' : 'usuarios' }}
                </span>
            </div>

            <h3 class="text-lg font-black text-slate-800 mb-1" style="font-family: 'Inter', sans-serif;">{{ $rol->nombre }}</h3>
            <p class="text-slate-500 text-sm line-clamp-2 mb-6">{{ $rol->descripcion ?? 'Sin descripción.' }}</p>

            <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100 mb-5">
                <div>
                    <p class="text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-0.5">Permisos</p>
                    <p class="text-xl font-black text-[#28628f]">{{ $rol->permisos_count }}</p>
                </div>
                <div>
                    <p class="text-[10px] font-bold uppercase text-slate-400 tracking-wider mb-0.5">Usuarios</p>
                    <p class="text-xl font-black text-slate-700">{{ $rol->users_count }}</p>
                </div>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('admin.roles.edit', $rol) }}"
                   class="flex-1 bg-slate-100 hover:bg-[#28628f] hover:text-white text-slate-600 py-2.5 rounded-xl text-xs font-bold flex items-center justify-center gap-2 transition-all text-decoration-none">
                    <span class="material-symbols-outlined text-[16px]">key</span>
                    Editar Permisos
                </a>
                <form method="POST" action="{{ route('admin.roles.destroy', $rol) }}"
                      onsubmit="return confirm('¿Seguro que querés eliminar el rol {{ $rol->nombre }}?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-11 h-11 bg-slate-100 hover:bg-rose-50 hover:text-rose-500 text-slate-400 rounded-xl flex items-center justify-center transition-all">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="col-span-1 lg:col-span-3 bg-white border border-slate-200 rounded-2xl p-12 text-center">
            <span class="material-symbols-outlined text-5xl text-slate-300 block mb-3">admin_panel_settings</span>
            <p class="text-slate-400 font-medium">No hay roles creados todavía.</p>
            <a href="{{ route('admin.roles.create') }}" class="inline-flex items-center gap-2 mt-4 text-[#28628f] font-bold text-sm hover:underline text-decoration-none">
                <span class="material-symbols-outlined text-[16px]">add</span> Crear el primer rol
            </a>
        </div>
    @endforelse

    {{-- Card para crear nuevo rol --}}
    <a href="{{ route('admin.roles.create') }}"
       class="border-2 border-dashed border-slate-300 rounded-2xl p-6 flex flex-col items-center justify-center text-center hover:border-[#28628f]/50 transition-all cursor-pointer group text-decoration-none">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-3 group-hover:bg-[#28628f]/10 transition-colors">
            <span class="material-symbols-outlined text-slate-400 group-hover:text-[#28628f] text-3xl">add</span>
        </div>
        <h4 class="font-bold text-slate-400 group-hover:text-[#28628f] transition-colors">Crear Rol Personalizado</h4>
        <p class="text-slate-300 text-xs mt-1 max-w-[180px]">Definí permisos específicos para un nuevo perfil.</p>
    </a>
</div>

@endsection