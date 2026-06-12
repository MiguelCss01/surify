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

        $usuarios = User::with('roles')
            ->when($search, function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15);

        return view('admin.usuarios.index', compact('usuarios', 'search'));
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