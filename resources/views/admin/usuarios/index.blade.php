@extends('layouts.admin')

@section('title', 'Surify - Gestión de Usuarios')

@section('content')

<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <p class="text-xs font-bold uppercase tracking-widest text-[#28628f] mb-1">Administración</p>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight" style="font-family: 'Inter', sans-serif;">Gestión de Usuarios</h1>
        <p class="text-slate-500 mt-2 text-sm">Administrá los accesos y roles de la plataforma Surify.</p>
    </div>
</div>

{{-- Buscador --}}
<div class="mb-6">
    <form method="GET" action="{{ route('admin.usuarios.index') }}">
        <div class="flex items-center bg-white border border-slate-200 rounded-xl px-4 py-2.5 gap-2 focus-within:border-[#28628f] transition-all max-w-lg shadow-sm">
            <span class="material-symbols-outlined text-slate-400 text-[20px]">search</span>
            <input type="text" name="search" value="{{ $search ?? '' }}"
                placeholder="Buscar por nombre, email o rol..."
                class="bg-transparent border-none p-0 focus:ring-0 text-sm text-slate-700 placeholder:text-slate-300 w-full">
            @if($search)
                <a href="{{ route('admin.usuarios.index') }}" class="text-slate-300 hover:text-slate-500 transition-colors text-decoration-none">
                    <span class="material-symbols-outlined text-[18px]">close</span>
                </a>
            @endif
        </div>
    </form>
</div>

{{-- Tabla --}}
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Usuario</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Email</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Rol Actual</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Registrado</th>
                    <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($usuarios as $usuario)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($usuario->avatar)
                                    <img src="{{ $usuario->avatar }}" class="w-10 h-10 rounded-full border border-slate-200 object-cover" alt="{{ $usuario->name }}">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-[#28628f]/10 flex items-center justify-center text-sm font-black text-[#28628f]">
                                        {{ strtoupper(substr($usuario->name, 0, 2)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $usuario->name }}</p>
                                    <p class="text-xs text-slate-400">ID: {{ $usuario->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-600">{{ $usuario->email }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse($usuario->roles as $rol)
                                    <span class="text-xs font-bold px-2.5 py-1 bg-[#28628f]/10 text-[#28628f] rounded-full">
                                        {{ $rol->nombre }}
                                    </span>
                                @empty
                                    <span class="text-xs text-slate-400 italic">Sin rol asignado</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-500">{{ $usuario->created_at->format('d/m/Y') }}</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                               class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-[#28628f]/10 hover:text-[#28628f] text-slate-500 rounded-xl text-xs font-bold transition-all text-decoration-none">
                                <span class="material-symbols-outlined text-[16px]">manage_accounts</span>
                                Gestionar
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <span class="material-symbols-outlined text-5xl text-slate-300 block mb-3">group</span>
                            <p class="text-slate-400 font-medium">
                                @if($search)
                                    No se encontraron usuarios para "{{ $search }}".
                                @else
                                    No hay usuarios registrados todavía.
                                @endif
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Paginación --}}
    @if($usuarios->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between">
            <p class="text-sm text-slate-500">
                Mostrando {{ $usuarios->firstItem() }}–{{ $usuarios->lastItem() }} de {{ $usuarios->total() }} usuarios
            </p>
            <div class="flex items-center gap-1">
                @if($usuarios->onFirstPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-300">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                    </span>
                @else
                    <a href="{{ $usuarios->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition-all text-decoration-none">
                        <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                    </a>
                @endif

                @foreach($usuarios->getUrlRange(1, $usuarios->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="w-9 h-9 flex items-center justify-center rounded-xl text-xs font-bold transition-all text-decoration-none
                        {{ $page == $usuarios->currentPage() ? 'bg-[#28628f] text-white shadow-sm' : 'border border-slate-200 text-slate-500 hover:bg-slate-50' }}">
                        {{ $page }}
                    </a>
                @endforeach

                @if($usuarios->hasMorePages())
                    <a href="{{ $usuarios->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-500 hover:bg-slate-50 transition-all text-decoration-none">
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </a>
                @else
                    <span class="w-9 h-9 flex items-center justify-center rounded-xl border border-slate-200 text-slate-300">
                        <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                    </span>
                @endif
            </div>
        </div>
    @endif
</div>

@endsection