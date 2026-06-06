<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorito extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'destino_id',
        'evento_id',
    ];

    /**
     * Obtiene el usuario dueño del favorito.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el destino marcado como favorito, si aplica.
     */
    public function destino(): BelongsTo
    {
        return $this->belongsTo(Destino::class);
    }

    /**
     * Obtiene el evento marcado como favorito, si aplica.
     */
    public function evento(): BelongsTo
    {
        return $this->belongsTo(Evento::class);
    }
}
