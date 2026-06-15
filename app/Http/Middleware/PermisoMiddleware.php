<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PermisoMiddleware
{
    public function handle(Request $request, Closure $next, string ...$permisos): \Symfony\Component\HttpFoundation\Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        if ($request->user()->hasRole('Admin')) {
            return $next($request);
        }

        foreach ($permisos as $permiso) {
            if ($request->user()->hasPermiso($permiso)) {
                return $next($request);
            }
        }

        abort(403, 'No tenés permisos para acceder a esta sección.');
    }
}