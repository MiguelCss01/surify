<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class EventoVisitado extends Model
{
    protected $table = 'evento_visitados';
    protected $fillable = ['user_id', 'evento_id', 'visitado_en'];
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }
}
