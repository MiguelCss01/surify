@extends('layouts.app')

@section('title', 'Recuperar Contraseña - Surify')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 p-8 text-center relative overflow-hidden">
        <!-- Decoración de fondo -->
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#28628f] via-[#06b6d4] to-[#f97316]"></div>
        
        <div class="w-20 h-20 bg-[#28628f]/10 text-[#28628f] rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner ring-8 ring-[#28628f]/5">
            <span class="material-symbols-outlined" style="font-size: 36px; font-variation-settings: 'FILL' 1;">lock_reset</span>
        </div>

        <h2 class="text-2xl font-black text-slate-800 mb-3 tracking-tight" style="font-family: 'Inter', sans-serif;">¿Olvidaste tu contraseña?</h2>
        
        <p class="text-slate-500 text-sm mb-8 leading-relaxed">
            No te preocupes, a todos nos pasa. Ingresa el correo con el que te registraste y te enviaremos un enlace para que elijas una nueva.
        </p>

        @if (session('status'))
            <div class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm font-semibold flex items-center gap-3 text-left">
                <span class="material-symbols-outlined text-emerald-500 shrink-0">check_circle</span>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="text-left space-y-5">
            @csrf

            <!-- Correo Electrónico -->
            <div>
                <label for="email" class="block text-sm font-bold text-slate-700 mb-2">Correo Electrónico</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="material-symbols-outlined text-slate-400 text-[20px]">mail</span>
                    </div>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-2 focus:ring-[#28628f]/20 focus:border-[#28628f] transition-all outline-none"
                        placeholder="tu@correo.com">
                </div>
                @error('email')
                    <p class="mt-2 text-sm text-rose-500 font-medium flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">error</span>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-[#28628f] hover:bg-[#1a4669] text-white font-semibold py-3.5 px-4 rounded-2xl transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">send</span>
                Enviar enlace de recuperación
            </button>

            <div class="pt-2 text-center">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-500 hover:text-[#28628f] transition-colors">
                    Volver al inicio de sesión
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
