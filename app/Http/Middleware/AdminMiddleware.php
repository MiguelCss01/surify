<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar si el usuario está autenticado y tiene el rol 'Admin'
        if ($request->user() && $request->user()->hasRole('Admin')) {
            return $next($request);
        }

        // Si no es admin, abortamos con un error 403 (Acceso Denegado)
        abort(403, 'Acceso denegado. Se requieren permisos de administrador.');
    }
}
