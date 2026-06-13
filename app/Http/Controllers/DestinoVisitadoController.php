<?php

namespace App\Http\Controllers;

use App\Models\DestinoVisitado;
use Illuminate\Http\Request;

class DestinoVisitadoController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate(['destino_id' => 'required|exists:destinos,id']);

        $visitado = DestinoVisitado::where('user_id', auth()->id())
            ->where('destino_id', $request->destino_id)
            ->first();

        if ($visitado) {
            $visitado->delete();
            $esVisitado = false;
        } else {
            DestinoVisitado::create([
                'user_id' => auth()->id(),
                'destino_id' => $request->destino_id,
                'visitado_en' => now()->toDateString(),
            ]);
            $esVisitado = true;
        }

        return response()->json(['visitado' => $esVisitado]);
    }
}