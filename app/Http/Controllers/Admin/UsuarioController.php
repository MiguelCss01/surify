<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $rolFiltro = $request->get('rol');

        $usuarios = User::with('roles')
            ->when($search, function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
            })
            ->when($rolFiltro, function ($q) use ($rolFiltro) {
                $q->whereHas('roles', function ($r) use ($rolFiltro) {
                    $r->whereRaw('roles.id = ?', [$rolFiltro]);
                });
            })
            ->latest()
            ->paginate(15);

        $roles = Role::orderBy('nombre')->get();

        return view('admin.usuarios.index', compact('usuarios', 'search', 'roles'));
    }

    public function edit(User $usuario)
    {
        $roles = Role::withCount('permisos')->get();
        $rolesActivos = $usuario->roles->pluck('id')->toArray();
        return view('admin.usuarios.edit', compact('usuario', 'roles', 'rolesActivos'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id',
        ]);

        $usuario->roles()->sync($request->roles ?? []);

        return redirect()->route('admin.usuarios.index')
            ->with('success', "Roles de {$usuario->name} actualizados correctamente.");
    }
}
