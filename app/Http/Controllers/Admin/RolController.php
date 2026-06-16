<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permiso;
use App\Models\Role;
use Illuminate\Http\Request;

class RolController extends Controller
{


    /**
     * Intercambia temporalmente la vista entre administrador y turista usando sesiones.
     */
    public function cambiarModoVista(Request $request)
    {
        if (session('modo_usuario')) {
            session()->forget('modo_usuario');
        } else {
            session(['modo_usuario' => true]);
        }
        return redirect()->back();
    }

    // Lista todos los roles
    public function index()
    {
        $roles = Role::withCount(['users', 'permisos'])->get();
        $totalPermisos = Permiso::count();
        $totalUsuarios = \App\Models\User::count();

        return view('admin.roles.index', compact('roles', 'totalPermisos', 'totalUsuarios'));
    }

    // Muestra el formulario para crear un rol
    public function create()
    {
        $permisos = Permiso::all();
        return view('admin.roles.create', compact('permisos'));
    }

    // Guarda el nuevo rol
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles',
            'descripcion' => 'nullable|string',
        ]);

        $rol = Role::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        if ($request->has('permisos')) {
            $rol->permisos()->sync($request->permisos);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Rol creado correctamente.');
    }

    // Muestra el formulario para editar un rol
    public function edit(Role $role)
    {
        $permisos = Permiso::all();
        $permisosActivos = $role->permisos->pluck('id')->toArray();
        return view('admin.roles.edit', compact('role', 'permisos', 'permisosActivos'));
    }

    // Actualiza el rol
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $role->id,
            'descripcion' => 'nullable|string',
        ]);

        $role->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        $role->permisos()->sync($request->permisos ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Rol actualizado correctamente.');
    }

    // Elimina el rol
    public function destroy(Role $role)
    {
        $role->permisos()->detach();
        $role->users()->detach();
        $role->delete();

        return redirect()->route('admin.roles.index')->with('success', 'Rol eliminado correctamente.');
    }
}
