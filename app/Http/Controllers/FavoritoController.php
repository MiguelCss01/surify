<?php

namespace App\Http\Controllers;

use App\Models\Favorito;
use Illuminate\Http\Request;

class FavoritoController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate(['destino_id' => 'required|exists:destinos,id']);

        $favorito = Favorito::where('user_id', auth()->id())
            ->where('destino_id', $request->destino_id)
            ->first();

        if ($favorito) {
            $favorito->delete();
            $esFavorito = false;
        } else {
            Favorito::create([
                'user_id' => auth()->id(),
                'destino_id' => $request->destino_id,
            ]);
            $esFavorito = true;
        }

        return response()->json(['favorito' => $esFavorito]);
    }
}