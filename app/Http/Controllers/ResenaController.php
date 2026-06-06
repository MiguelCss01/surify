<?php

namespace App\Http\Controllers;

use App\Models\Resena;
use Illuminate\Http\Request;

class ResenaController extends Controller
{
    /**
     * Guarda una nueva reseña en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos recibidos
        $validated = $request->validate([
            'destino_id' => 'nullable|exists:destinos,id',
            'evento_id' => 'nullable|exists:eventos,id',
            'calificacion' => 'required|integer|min:1|max:5',
            'comentario' => 'required|string|min:5|max:1000',
            'imagenes' => 'nullable|array',
            'imagenes.*' => 'url', // O validación de archivos si se suben como files, de momento validamos strings/urls
        ]);

        // Aseguramos que el usuario esté autenticado
        if (!auth()->check()) {
            return redirect()->back()->with('error', 'Debes iniciar sesión para dejar una reseña.');
        }

        // Creamos la reseña
        $resena = new Resena();
        $resena->user_id = auth()->id();
        $resena->destino_id = $validated['destino_id'] ?? null;
        $resena->evento_id = $validated['evento_id'] ?? null;
        $resena->calificacion = $validated['calificacion'];
        $resena->comentario = $validated['comentario'];
        
        // Si hay imágenes se guardan como array (gracias al cast array en el modelo, Laravel lo codifica en JSON solo)
        if (isset($validated['imagenes'])) {
            $resena->imagenes = $validated['imagenes'];
        }

        $resena->save();

        return redirect()->back()->with('success', '¡Gracias por compartir tu experiencia!');
    }
}
