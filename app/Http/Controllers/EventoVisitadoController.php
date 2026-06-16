<?php

namespace App\Http\Controllers;

use App\Models\EventoVisitado;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventoVisitadoController extends Controller
{
    public function toggle(Request $request)
    {
        $data = $request->validate(['evento_id' => 'required|exists:eventos,id']);

        $userId = $request->user()->id;
        $eventoId = $data['evento_id'];

        $visitado = EventoVisitado::where('user_id', $userId)
            ->where('evento_id', $eventoId)
            ->first();

        if ($visitado) {
            $visitado->delete();
            $esVisitado = false;
        } else {
            EventoVisitado::create([
                'user_id'      => $userId,
                'evento_id'    => $eventoId,
                'visitado_en'  => now()->toDateString(),
            ]);
            $esVisitado = true;
        }

        return response()->json(['visitado' => $esVisitado]);
    }
    
}
