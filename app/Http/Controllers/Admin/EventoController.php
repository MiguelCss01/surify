<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Provincia;
use App\Models\Destino;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    public function index(Request $request)
    {
        $filtro = $request->get('filtro', 'todos');

        $query = Evento::with(['provincia', 'destino'])->orderBy('fecha_inicio', 'asc');

        if ($request->filled('buscar')) {
            $query->where('nombre', 'ilike', '%' . $request->buscar . '%');
        }

        if ($request->filled('provincia_id')) {
            $query->where('provincia_id', $request->provincia_id);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        $eventos = $query->get();

        if ($filtro === 'proximos') {
            $eventos = $eventos->filter(fn($e) => !$e->pasado);
        } elseif ($filtro === 'pasados') {
            $eventos = $eventos->filter(fn($e) => $e->pasado);
        }

        $countTodos = Evento::count();
        $countProximos = Evento::get()->filter(fn($e) => !$e->pasado)->count();
        $countPasados = Evento::get()->filter(fn($e) => $e->pasado)->count();
        $provincias = Provincia::orderBy('nombre')->get();

        return view('admin.eventos.index', compact(
            'eventos',
            'filtro',
            'countTodos',
            'countProximos',
            'countPasados',
            'provincias'
        ));
    }

    public function edit(Evento $evento)
    {
        $provincias = Provincia::orderBy('nombre')->get();
        $destinos = Destino::orderBy('nombre')->get();
        return view('admin.eventos.edit', compact('evento', 'provincias', 'destinos'));
    }

    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'tipo'         => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'provincia_id' => 'nullable|exists:provincias,id',
            'destino_id'   => 'nullable|exists:destinos,id',
            'rango_precio' => 'nullable|string|max:255',
            'imagen_url'   => 'nullable|string|max:255',
        ]);

        $evento->update([
            'nombre'       => $request->nombre,
            'tipo'         => $request->tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'provincia_id' => $request->provincia_id,
            'destino_id'   => $request->destino_id,
            'rango_precio' => $request->rango_precio,
            'imagen_url'   => $request->imagen_url,
            'activo'       => $request->has('activo'),
        ]);

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento actualizado correctamente.');
    }

    public function create()
    {
        $provincias = Provincia::orderBy('nombre')->get();
        $destinos = Destino::orderBy('nombre')->get();
        return view('admin.eventos.create', compact('provincias', 'destinos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'tipo'         => 'nullable|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'provincia_id' => 'nullable|exists:provincias,id',
            'destino_id'   => 'nullable|exists:destinos,id',
            'rango_precio' => 'nullable|string|max:255',
            'imagen_url'   => 'nullable|string|max:255',
            'descripcion'  => 'nullable|string',
        ]);

        Evento::create([
            'nombre'       => $request->nombre,
            'tipo'         => $request->tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'provincia_id' => $request->provincia_id,
            'destino_id'   => $request->destino_id,
            'rango_precio' => $request->rango_precio,
            'imagen_url'   => $request->imagen_url,
            'descripcion'  => $request->descripcion,
            'activo'       => $request->has('activo'),
        ]);

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento creado correctamente.');
    }
    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento eliminado correctamente.');
    }
}
