<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Provincia;
use App\Models\Destino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // 📸 Importante para borrar fotos viejas

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

    public function create()
    {
        // 🌟 CORREGIDO: Cargamos los destinos y también las provincias para el select del formulario
        $destinos = Destino::orderBy('nombre')->get();
        $provincias = Provincia::orderBy('nombre')->get();
        
        return view('admin.eventos.create', compact('destinos', 'provincias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'destino_id'   => 'required|exists:destinos,id',
            'precio_tipo'  => 'required|string|max:255',
            'descripcion'  => 'required|string',
            'imagen'       => 'nullable|image|max:2048',
        ]);

        $destino = Destino::find($request->destino_id);
        $provinciaId = $destino ? $destino->provincia_id : null;

        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('eventos', 'public');
        }

        Evento::create([
            'nombre'       => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'provincia_id' => $provinciaId,
            'destino_id'   => $request->destino_id,
            'rango_precio' => $request->precio_tipo,
            'imagen_url'   => $rutaImagen,
            'descripcion'  => $request->descripcion,
            'activo'       => true,
        ]);

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento creado correctamente.');
    }

    public function edit(Evento $evento)
    {
        // 🌟 CORREGIDO: Inyectamos provincias acá también por si la vista de edición las necesita para el select
        $destinos = Destino::orderBy('nombre')->get();
        $provincias = Provincia::orderBy('nombre')->get(); 
        
        return view('admin.eventos.edit', compact('evento', 'destinos', 'provincias'));
    }

    public function update(Request $request, Evento $evento)
    {
        $request->validate([
            'nombre'       => 'required|string|max:255',
            'fecha_inicio' => 'required|date',
            'fecha_fin'    => 'nullable|date|after_or_equal:fecha_inicio',
            'destino_id'   => 'required|exists:destinos,id',
            'precio_tipo'  => 'required|string|max:255', 
            'descripcion'  => 'required|string',         
            'imagen'       => 'nullable|image|max:2048', 
        ]);

        $destino = Destino::find($request->destino_id);
        $provinciaId = $destino ? $destino->provincia_id : null;

        $rutaImagen = $evento->imagen_url;

        if ($request->hasFile('imagen')) {
            if ($evento->imagen_url && Storage::disk('public')->exists($evento->imagen_url)) {
                Storage::disk('public')->delete($evento->imagen_url);
            }
            $rutaImagen = $request->file('imagen')->store('eventos', 'public');
        }

        $evento->update([
            'nombre'       => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'provincia_id' => $provinciaId, 
            'destino_id'   => $request->destino_id,
            'rango_precio' => $request->precio_tipo, 
            'imagen_url'   => $rutaImagen,           
            'descripcion'  => $request->descripcion,
            'activo'       => true,                  
        ]);

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento actualizado correctamente.');
    }

    public function destroy(Evento $evento)
    {
        if ($evento->imagen_url && Storage::disk('public')->exists($evento->imagen_url)) {
            Storage::disk('public')->delete($evento->imagen_url);
        }

        $evento->delete();
        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento eliminado correctamente.');
    }
}