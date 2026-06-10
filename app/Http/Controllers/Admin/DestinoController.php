<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destino;
use App\Models\Provincia;
use Illuminate\Http\Request;

class DestinoController extends Controller
{
    public function index()
    {
        $destinos = Destino::with('provincia')->latest()->paginate(12);
        return view('admin.destinos.index', compact('destinos'));
    }

    public function create()
    {
        $provincias = Provincia::orderBy('nombre')->get();
        return view('admin.destinos.create', compact('provincias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'provincia_id' => 'required|exists:provincias,id',
            'descripcion'  => 'nullable|string',
            'categoria'    => 'nullable|string|max:255',
            'rango_precio' => 'nullable|string|max:255',
            'imagen_url'   => 'nullable|string|max:255',
        ]);

        Destino::create([
            'nombre'       => $request->nombre,
            'provincia_id' => $request->provincia_id,
            'descripcion'  => $request->descripcion,
            'categoria'    => $request->categoria,
            'rango_precio' => $request->rango_precio,
            'imagen_url'   => $request->imagen_url,
            'activo'       => $request->has('activo'),
        ]);

        return redirect()->route('admin.destinos.index')
            ->with('success', 'Destino creado correctamente.');
    }

    public function edit(Destino $destino)
    {
        $provincias = Provincia::orderBy('nombre')->get();
        return view('admin.destinos.edit', compact('destino', 'provincias'));
    }

    public function update(Request $request, Destino $destino)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'provincia_id' => 'required|exists:provincias,id',
            'descripcion'  => 'nullable|string',
            'categoria'    => 'nullable|string|max:255',
            'rango_precio' => 'nullable|string|max:255',
            'imagen_url'   => 'nullable|string|max:255',
        ]);

        $destino->update([
            'nombre'       => $request->nombre,
            'provincia_id' => $request->provincia_id,
            'descripcion'  => $request->descripcion,
            'categoria'    => $request->categoria,
            'rango_precio' => $request->rango_precio,
            'imagen_url'   => $request->imagen_url,
            'activo'       => $request->has('activo'),
        ]);

        return redirect()->route('admin.destinos.index')
            ->with('success', 'Destino actualizado correctamente.');
    }

    public function destroy(Destino $destino)
    {
        $destino->delete();
        return redirect()->route('admin.destinos.index')
            ->with('success', 'Destino eliminado correctamente.');
    }
}