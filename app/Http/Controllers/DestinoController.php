<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Provincia;
use Illuminate\Http\Request;

class DestinoController extends Controller
{
    // Vista Provincial: Filtra por nombre de provincia
    public function porProvincia(string $nombre) 
    {
        // Intentamos buscar por la nueva relación con la tabla de Provincias
        $provincia = Provincia::where('nombre', $nombre)
            ->orWhere('nombre', 'like', '%' . $nombre . '%')
            ->first();

        if ($provincia) {
            // Si existe la provincia en la DB, traemos sus destinos asociados
            $destinos = $provincia->destinos;
        } else {
            // Fallback: Si no existe el registro en 'provincias', usamos el campo viejo de texto 'provincia'
            $destinos = Destino::where('provincia', $nombre)->get();
        }

        return view('provincia', compact('destinos', 'provincia', 'nombre'));
    }

    // Ficha de Destino: Trae un solo destino por ID
    public function show(int $id) 
    {
        // Usamos Eager Loading para traer el destino con su provincia, eventos y reseñas (incluyendo quién escribió cada reseña y sus fotos)
        $destino = Destino::with(['provincia', 'eventos', 'resenas.user', 'resenas.imagenes'])->findOrFail($id);
        
        return view('destinos.show', compact('destino'));
    }
}