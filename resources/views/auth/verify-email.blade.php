@extends('layouts.app')

@section('title', 'Verifica tu correo - Surify')

@section('content')
<div class="min-h-[60vh] flex items-center justify-center px-4">
    <div class="max-w-md w-full bg-white rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 p-8 text-center relative overflow-hidden">
        <!-- Decoración de fondo -->
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-[#28628f] via-[#06b6d4] to-[#f97316]"></div>
        
        <div class="w-20 h-20 bg-[#28628f]/10 text-[#28628f] rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner ring-8 ring-[#28628f]/5">
            <span class="material-symbols-outlined" style="font-size: 36px; font-variation-settings: 'FILL' 1;">mark_email_unread</span>
        </div>

        <h2 class="text-2xl font-black text-slate-800 mb-3 tracking-tight" style="font-family: 'Inter', sans-serif;">¡Revisa tu correo!</h2>
        
        <p class="text-slate-500 text-sm mb-8 leading-relaxed">
            Gracias por unirte a Surify. Te enviamos un enlace mágico a tu bandeja de entrada. Por favor, haz clic en él para verificar tu cuenta y empezar a explorar la Argentina.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 text-sm font-semibold flex items-center gap-3 text-left">
                <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                ¡Te hemos enviado un nuevo enlace! Revisa tu bandeja de entrada (y el correo no deseado).
            </div>
        @endif

        <div class="space-y-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-[#28628f] hover:bg-[#1a4669] text-white font-semibold py-3.5 px-4 rounded-2xl transition-all shadow-md hover:shadow-lg active:scale-95 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">send</span>
                    Reenviar correo de verificación
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full bg-slate-50 hover:bg-slate-100 text-slate-500 hover:text-slate-700 font-semibold py-3.5 px-4 rounded-2xl transition-all active:scale-95">
                    Cerrar sesión por ahora
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
