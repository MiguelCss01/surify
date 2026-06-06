<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DestinoVisitado extends Model
{
    use HasFactory;

    protected $table = 'destinos_visitados'; // Pluralización manual

    protected $fillable = [
        'user_id',
        'destino_id',
        'visitado_en',
    ];

    protected $casts = [
        'visitado_en' => 'date',
    ];

    /**
     * Obtiene el usuario que visitó el destino.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el destino que fue visitado.
     */
    public function destino(): BelongsTo
    {
        return $this->belongsTo(Destino::class);
    }
}
