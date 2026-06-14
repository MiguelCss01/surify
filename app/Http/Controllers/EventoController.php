<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use Illuminate\Http\Request;

class EventoController extends Controller
{
    /**
     * Muestra la lista de todos los eventos.
     */
    public function index(Request $request)
    {
        $query = Evento::with(['destino', 'provincia'])->orderBy('fecha_inicio', 'asc');

        // Filtro por provincia
        if ($request->filled('provincia_id')) {
            $query->where('provincia_id', $request->provincia_id);
        }

        // Filtro por año/mes
        $año = $request->get('año', now()->year);
        $mes = $request->get('mes', now()->month);

        $eventos = $query->whereYear('fecha_inicio', $año)
            ->whereMonth('fecha_inicio', $mes)
            ->get();

        $provincias = \App\Models\Provincia::orderBy('nombre')->get();

        return view('eventos.index', compact('eventos', 'provincias', 'año', 'mes'));
    }
}
