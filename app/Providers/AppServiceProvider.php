<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Admin tiene acceso a todo automáticamente
        Gate::before(function ($user, $ability) {
            if ($user->hasRole('admin') || $user->hasRole('Admin')) {
                return true;
            }
        });

        // Todos los permisos del sistema
        $permisos = [
            'crear_destino',
            'modificar_destino',
            'eliminar_destino',
            'administrar_destinos_sugeridos',
            'crear_evento',
            'modificar_evento',
            'eliminar_evento',
            'administrar_eventos_sugeridos',
            'administrar_resena',
            'administrar_resenas',
            'eliminar_comentario',
            'gestionar_gastronomia',
        ];

        foreach ($permisos as $permiso) {
            Gate::define($permiso, function ($user) use ($permiso) {
                return $user->hasPermiso($permiso);
            });
        }
    }
}