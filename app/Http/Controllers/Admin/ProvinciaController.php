<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Provincia;
use App\Models\ProvinciaImagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProvinciaController extends Controller
{
    public function update(Request $request, Provincia $provincia)
    {

        $request->validate([
            'nombre'      => 'required|string|max:255',
            'region'      => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'imagenes'    => 'nullable|array',
            'imagenes.*'  => 'image|max:4096',
        ]);

        $provincia->update([
            'nombre'      => $request->nombre,
            'region'      => $request->region,
            'descripcion' => $request->descripcion,
        ]);

        if ($request->hasFile('imagenes')) {
            $orden = $provincia->imagenes()->max('orden') ?? 0;
            foreach ($request->file('imagenes') as $img) {
                $url = $img->store('provincias', 'public');
                ProvinciaImagen::create([
                    'provincia_id' => $provincia->id,
                    'url'          => $url,
                    'orden'        => ++$orden,
                ]);
            }
        }

        return back()->with('success', "Provincia {$provincia->nombre} actualizada.");
    }

    public function destroyImagen(ProvinciaImagen $imagen)
    {
        Storage::disk('public')->delete($imagen->url);
        $imagen->delete();
        return response()->json(['ok' => true]);
    }
}
