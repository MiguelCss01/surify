<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evento;
use App\Models\Provincia;
use App\Models\Destino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // 🌟 Importante para borrar fotos viejas

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
            'precio_tipo'  => 'required|string|max:255', // Viene del formulario
            'descripcion'  => 'required|string',         // Viene del formulario
            'imagen'       => 'nullable|image|max:2048', // Validación de archivo real (Max 2MB)
        ]);

        // Buscamos la provincia automáticamente según el destino elegido para mantener consistencia
        $destino = Destino::find($request->destino_id);
        $provinciaId = $destino ? $destino->provincia_id : null;

        // Mantener la imagen actual por defecto
        $rutaImagen = $evento->imagen_url;

        // 📸 Procesamiento de la nueva foto si se subió una
        if ($request->hasFile('imagen')) {
            // Borrar la foto anterior del disco local si existía para no llenar el hosting de basura
            if ($evento->imagen_url && Storage::disk('public')->exists($evento->imagen_url)) {
                Storage::disk('public')->delete($evento->imagen_url);
            }
            // Guardar la nueva en storage/app/public/eventos
            $rutaImagen = $request->file('imagen')->store('eventos', 'public');
        }

        $evento->update([
            'nombre'       => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin'    => $request->fecha_fin,
            'provincia_id' => $provinciaId, // Seteado dinámicamente
            'destino_id'   => $request->destino_id,
            'rango_precio' => $request->precio_tipo, // Adaptado al nombre de tu BD
            'imagen_url'   => $rutaImagen,           // Guardamos la ruta del storage
            'descripcion'  => $request->descripcion,
            'activo'       => true,                  // Por defecto activo al editar
        ]);

        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento actualizado correctamente.');
    }

    public function create()
    {
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

    public function destroy(Evento $evento)
    {
        // Al borrar el evento, limpiamos su foto del almacenamiento
        if ($evento->imagen_url && Storage::disk('public')->exists($evento->imagen_url)) {
            Storage::disk('public')->delete($evento->imagen_url);
        }

        $evento->delete();
        return redirect()->route('admin.eventos.index')
            ->with('success', 'Evento eliminado correctamente.');
    }
}
