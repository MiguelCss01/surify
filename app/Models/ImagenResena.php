<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImagenResena extends Model
{
    use HasFactory;

    protected $table = 'imagenes_resenas'; // Pluralización manual

    protected $fillable = [
        'resena_id',
        'url',
    ];

    /**
     * Obtiene la reseña a la que pertenece esta imagen.
     */
    public function resena(): BelongsTo
    {
        return $this->belongsTo(Resena::class, 'resena_id');
    }
}
