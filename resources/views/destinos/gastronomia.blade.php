@extends('layouts.app')

@section('title')
    Surify - Sabores Locales: {{ $provincia->nombre ?? 'Misiones' }}
@endsection

@section('content')
<main class="w-full -mt-8">
    <!-- Botón de retorno a la Provincia -->
    <div class="max-w-7xl mx-auto px-4 md:px-8 pt-4">
        <a href="{{ route('provincia.show', ['slug' => $provincia->slug ?? 'misiones']) }}" class="inline-flex items-center gap-1 text-xs font-bold text-slate-400 hover:text-[#28628f] transition-colors text-decoration-none uppercase tracking-wider mb-4">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            <span>Volver a {{ $provincia->nombre ?? 'Misiones' }}</span>
        </a>
    </div>

    <!-- Hero Section Adaptativo -->
    <section class="w-full h-[450px] min-h-[350px] relative overflow-hidden bg-slate-900 rounded-3xl shadow-sm">
        <div class="absolute inset-0 bg-gradient-to-t from-[#f8fafc] via-transparent to-transparent z-10"></div>
        <img alt="Gastronomía de {{ $provincia->nombre ?? 'Misiones' }}" class="w-full h-full object-cover absolute inset-0 object-center opacity-85" src="https://images.unsplash.com/photo-1626202102521-127db8e2df8a?auto=format&fit=crop&w=1600&q=80"/>
        
        <div class="relative z-20 h-full max-w-7xl mx-auto px-4 md:px-8 flex flex-col justify-end pb-8">
            <div class="inline-flex items-center gap-2 bg-white/90 backdrop-blur-sm px-4 py-2 rounded-full w-fit mb-4 shadow-xs border border-slate-200">
                <span class="material-symbols-outlined text-amber-600 text-sm" style="font-variation-settings: 'FILL' 1;">restaurant</span>
                <span class="text-xs font-bold text-slate-800 tracking-wider uppercase">{{ $provincia->nombre ?? 'Misiones' }}, ARGENTINA</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mb-3 tracking-tighter font-sans">Sabores Locales</h1>
            <p class="text-base text-slate-600 max-w-2xl bg-white/70 backdrop-blur-md p-4 rounded-2xl shadow-xs border border-slate-200/50 leading-relaxed">
                Descubre la rica herencia culinaria de {{ $provincia->nombre ?? 'Misiones' }}. Una fusión mágica de ingredientes autóctonos de la región, tradiciones ancestrales y secretos recetas heredadas de la inmigración.
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 md:px-8 py-12">
        <!-- Platos Imprescindibles (Bento Grid) -->
        <section>
            <div class="flex items-center justify-between mb-8 border-b border-slate-200 pb-4">
                <h2 class="text-2xl font-black text-slate-850 tracking-tight">Platos Imprescindibles de la Región</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Tarjeta Grande (Ej: Chipá) -->
                <div class="md:col-span-2 group rounded-2xl overflow-hidden bg-white border border-slate-200 shadow-2xs hover:shadow-md transition-all duration-300 relative min-h-[320px]">
                    <img alt="Plato tradicional" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-102" src="https://images.unsplash.com/photo-1608797178974-15b35a61d121?auto=format&fit=crop&w=1000&q=80"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/40 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 w-full">
                        <h3 class="text-xl font-bold text-white mb-2 font-sans">{{ $provincia->plato_principal_nombre ?? 'El Chipá Tradicional' }}</h3>
                        <p class="text-slate-200 text-sm max-w-xl leading-relaxed">
                            {{ $provincia->plato_principal_desc ?? 'El icónico pan de queso elaborado con almidón de mandioca local. Crujiente por fuera, suave y chicloso por dentro. El compañero inseparable de cualquier viaje.' }}
                        </p>
                    </div>
                </div>
                
                <!-- Tarjeta Chica (Ej: Sopa Paraguaya) -->
                <div class="group rounded-2xl overflow-hidden bg-white border border-slate-200 shadow-2xs hover:shadow-md transition-all duration-300 relative min-h-[320px]">
                    <img alt="Especialidad local" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-102" src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&w=600&q=80"/>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/30 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 p-6 w-full">
                        <h3 class="text-lg font-bold text-white mb-1 font-sans">{{ $provincia->plato_secundario_nombre ?? 'Sopa Paraguaya' }}</h3>
                        <p class="text-slate-200 text-xs leading-relaxed">
                            {{ $provincia->plato_secundario_desc ?? 'Una deliciosa combinación horneada de harina de maíz, abundante queso fresco, cebollas rehogadas y huevos.' }}
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection