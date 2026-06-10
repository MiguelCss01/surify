@extends('layouts.app')

@section('title', 'Surify - Gestión de Destinos')

@section('content')

<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <p class="text-xs font-bold uppercase tracking-widest text-[#28628f] mb-1">Administración</p>
        <h1 class="text-4xl font-black text-slate-900 tracking-tight" style="font-family: 'Inter', sans-serif;">Destinos Turísticos</h1>
        <p class="text-slate-500 mt-2 text-sm">Gestioná todos los destinos de la plataforma Surify.</p>
    </div>
    <a href="{{ route('admin.destinos.create') }}"
       class="inline-flex items-center gap-2 bg-[#28628f] text-white px-5 py-3 rounded-xl font-bold text-sm hover:bg-[#1a4669] transition-all shadow-sm shrink-0 text-decoration-none">
        <span class="material-symbols-outlined text-[18px]">add_location</span>
        Nuevo Destino
    </a>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-100 bg-slate-50">
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Destino</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Provincia</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Categoría</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Precio</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Estado</th>
                    <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-400">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($destinos as $destino)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-100 overflow-hidden shrink-0">
                                    @if($destino->imagen_url)
                                        <img src="{{ $destino->imagen_url }}" class="w-full h-full object-cover" alt="{{ $destino->nombre }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <span class="material-symbols-outlined text-slate-300 text-[18px]">landscape</span>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800">{{ $destino->nombre }}</p>
                                    <p class="text-xs text-slate-400">ID: {{ $destino->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-600">{{ $destino->provincia?->nombre ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold px-2.5 py-1 bg-[#28628f]/10 text-[#28628f] rounded-full">
                                {{ $destino->categoria ?? 'Sin categoría' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm text-slate-600">{{ $destino->rango_precio ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($destino->activo)
                                <span class="text-xs font-bold px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100">Activo</span>
                            @else
                                <span class="text-xs font-bold px-2.5 py-1 bg-slate-100 text-slate-400 rounded-full border border-slate-200">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('destinos.show', $destino->id) }}"
                                   class="w-9 h-9 bg-slate-100 hover:bg-[#28628f]/10 hover:text-[#28628f] text-slate-400 rounded-lg flex items-center justify-center transition-all text-decoration-none"
                                   title="Ver destino">
                                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                                </a>
                                <a href="{{ route('admin.destinos.edit', $destino) }}"
                                   class="w-9 h-9 bg-slate-100 hover:bg-[#28628f]/10 hover:text-[#28628f] text-slate-400 rounded-lg flex items-center justify-center transition-all text-decoration-none"
                                   title="Editar">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                </a>
                                <form method="POST" action="{{ route('admin.destinos.destroy', $destino) }}"
                                      onsubmit="return confirm('¿Seguro que querés eliminar {{ $destino->nombre }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-9 h-9 bg-slate-100 hover:bg-rose-50 hover:text-rose-500 text-slate-400 rounded-lg flex items-center justify-center transition-all"
                                        title="Eliminar">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <span class="material-symbols-outlined text-5xl text-slate-300 block mb-3">landscape</span>
                            <p class="text-slate-400 font-medium">No hay destinos cargados todavía.</p>
                            <a href="{{ route('admin.destinos.create') }}" class="inline-flex items-center gap-1 mt-3 text-[#28628f] font-bold text-sm hover:underline text-decoration-none">
                                <span class="material-symbols-outlined text-[16px]">add</span> Crear el primer destino
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($destinos->hasPages())
        <div class="px-6 py-4 border-t border-slate-100">
            {{ $destinos->links() }}
        </div>
    @endif
</div>

@endsection