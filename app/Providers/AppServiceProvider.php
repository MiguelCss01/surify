<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; // 🌟 IMPORTANTE: Agregamos la fachada Gate

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 🛡️ PARACAÍDAS DE SEGURIDAD: Evita que el Admin se quede encerrado en modo turista
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('Admin')) {
                // Si la URL actual contiene "admin" o "dashboard", rompemos la simulación
                if (str_contains(request()->url(), 'admin') || str_contains(request()->url(), 'dashboard')) {
                    if (session('modo_vista') === 'turista') {
                        session()->forget('modo_vista');
                    }
                    return true; // Habilita todos los @can automáticamente en zona de admin
                }
            }
        });
    }
}