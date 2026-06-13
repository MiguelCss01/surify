<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Provincia;
use Illuminate\Http\Request;

class EventoSugerenciaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'rango_precio' => 'nullable|string',
            'provincia_id' => 'nullable|exists:provincias,id',
            'imagenes.*' => 'nullable|image|max:2048',
        ]);

        $imagen_url = null;
        if ($request->hasFile('imagenes') && $request->file('imagenes')[0]->isValid()) {
            $path = $request->file('imagenes')[0]->store('eventos', 'public');
            $imagen_url = \Storage::url($path);
        }

        Evento::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'rango_precio' => $request->rango_precio,
            'provincia_id' => $request->provincia_id,
            'imagen_url' => $imagen_url,
            'activo' => false,
            'sugerido_por' => auth()->id(),
        ]);

        return back()->with('success', '¡Gracias! Tu sugerencia de festival fue enviada y será revisada por el equipo.');
    }
}