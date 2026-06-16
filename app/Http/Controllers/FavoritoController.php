<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'destino_id' => 'nullable|exists:destinos,id',
            'evento_id'  => 'nullable|exists:eventos,id',
        ]);

        $query = Favorito::where('user_id', auth()->id());

        if ($request->filled('destino_id')) {
            $query->where('destino_id', $request->destino_id);
        } elseif ($request->filled('evento_id')) {
            $query->where('evento_id', $request->evento_id);
        }

        $favorito = $query->first();

        if ($favorito) {
            $favorito->delete();
            $esFavorito = false;
        } else {
            Favorito::create([
                'user_id'    => auth()->id(),
                'destino_id' => $request->destino_id,
                'evento_id'  => $request->evento_id,
            ]);
            $esFavorito = true;
        }

        return response()->json(['favorito' => $esFavorito]);
    }
}