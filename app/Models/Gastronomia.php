<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gastronomia extends Model
{
    use HasFactory;

    protected $table = 'gastronomia'; // Pluralización manual

    protected $fillable = [
        'provincia_id',
        'nombre',
        'descripcion',
        'categoria',
        'imagen_url',
    ];

    /**
     * Obtiene la provincia asociada a este plato o establecimiento gastronómico.
     */
    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }
}
