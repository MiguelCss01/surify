<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CombustibleController extends Controller
{
    public function index()
    {
        $destinos = Destino::where('activo', true)
            ->with('provincia')
            ->get()
            ->map(function($d) {
                $coords = DB::select('SELECT ST_Y(ubicacion::geometry) as lat, ST_X(ubicacion::geometry) as lng FROM destinos WHERE id = ?', [$d->id])[0];
                return [
                    'id' => $d->id,
                    'nombre' => $d->nombre,
                    'provincia' => $d->provincia->nombre ?? '',
                    'lat' => $coords->lat,
                    'lng' => $coords->lng,
                ];
            });

        return view('herramientas.combustible', compact('destinos'));
    }
}