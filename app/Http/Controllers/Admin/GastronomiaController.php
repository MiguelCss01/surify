<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gastronomia;
use App\Models\Provincia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GastronomiaController extends Controller
{
    public function index(Request $request)
    {
        $query = Provincia::with(['gastronomia' => function ($q) use ($request) {
            if ($request->filled('buscar')) {
                $q->where('nombre', 'ilike', '%' . $request->buscar . '%');
            }
            if ($request->filled('categoria')) {
                $q->where('categoria', $request->categoria);
            }
        }])->orderBy('nombre');

        if ($request->filled('provincia_id')) {
            $query->where('id', $request->provincia_id);
        }

        $provincias = $query->get();

        return view('admin.gastronomia.index', compact('provincias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'provincia_id' => 'required|exists:provincias,id',
            'nombre'       => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'categoria'    => 'required|string|max:100',
            'imagen'       => 'nullable|image|max:2048',
        ]);

        $imagenUrl = null;
        if ($request->hasFile('imagen')) {
            $imagenUrl = $request->file('imagen')->store('gastronomia', 'public');
        }

        Gastronomia::create([
            'provincia_id' => $request->provincia_id,
            'nombre'       => $request->nombre,
            'descripcion'  => $request->descripcion,
            'categoria'    => $request->categoria,
            'imagen_url'   => $imagenUrl,
        ]);

        return back()->with('success', 'Plato agregado correctamente.');
    }

    public function update(Request $request, Gastronomia $gastronomia)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'required|string',
            'categoria'   => 'required|string|max:100',
            'imagen'      => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            if ($gastronomia->imagen_url) {
                Storage::disk('public')->delete($gastronomia->imagen_url);
            }
            $gastronomia->imagen_url = $request->file('imagen')->store('gastronomia', 'public');
        }

        $gastronomia->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria'   => $request->categoria,
            'imagen_url'  => $gastronomia->imagen_url,
        ]);

        return back()->with('success', 'Plato actualizado correctamente.');
    }

    public function destroy(Gastronomia $gastronomia)
    {
        if ($gastronomia->imagen_url) {
            Storage::disk('public')->delete($gastronomia->imagen_url);
        }
        $gastronomia->delete();
        return back()->with('success', 'Plato eliminado correctamente.');
    }
}
