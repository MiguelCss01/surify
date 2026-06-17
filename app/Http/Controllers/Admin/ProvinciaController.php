<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provincia;
use App\Models\ProvinciaImagen;
use Illuminate\Http\Request;

class ProvinciaController extends Controller
{
    public function update(Request $request, Provincia $provincia)
    {
        $request->validate([
            'nombre'        => 'required|string|max:255',
            'region'        => 'nullable|string|max:255',
            'descripcion'   => 'nullable|string',
            'imagenes_urls' => 'nullable|array',
            'imagenes_urls.*' => 'nullable|url|max:2048',
        ]);

        $provincia->update([
            'nombre'      => $request->nombre,
            'region'      => $request->region,
            'descripcion' => $request->descripcion,
        ]);

        if ($request->filled('imagenes_urls')) {
            $orden = $provincia->imagenes()->max('orden') ?? 0;
            foreach ($request->imagenes_urls as $url) {
                if (!empty($url)) {
                    ProvinciaImagen::create([
                        'provincia_id' => $provincia->id,
                        'url'          => $url,
                        'orden'        => ++$orden,
                    ]);
                }
            }
        }

        return back()->with('success', "Provincia {$provincia->nombre} actualizada.");
    }

    public function destroyImagen(ProvinciaImagen $imagen)
    {
        $imagen->delete();

        return response()->json(['ok' => true]);
    }
}