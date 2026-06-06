<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Muestra la lista de todos los eventos.
     */
    public function index()
    {
        // Eager load el destino de cada evento y ordena por fecha de inicio
        $eventos = Evento::with('destino')->orderBy('fecha_inicio', 'asc')->get();
        
        return view('eventos.index', compact('eventos'));
    }

    /**
     * Muestra la ficha detallada de un evento específico.
     */
    public function show(int $id)
    {
        // Trae el evento con su destino y sus reseñas asociadas (incluyendo usuario e imágenes)
        $evento = Evento::with(['destino', 'resenas.user', 'resenas.imagenes'])->findOrFail($id);
        
        return view('eventos.show', compact('evento'));
    }
}
