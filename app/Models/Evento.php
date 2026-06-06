<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evento extends Model
{
    use HasFactory;

    protected $fillable = [
        'provincia_id',
        'destino_id',
        'nombre',
        'tipo', // Musical, Gastronómico, Deportivo, Cultural
        'fecha_inicio',
        'fecha_fin',
        'ubicacion', // PostGIS POINT
        'rango_precio', // Bajo, Medio, Alto
        'imagen_url',
        'activo',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'activo' => 'boolean',
    ];

    /**
     * Obtiene la provincia a la que pertenece este evento.
     */
    public function provincia(): BelongsTo
    {
        return $this->belongsTo(Provincia::class);
    }

    /**
     * Obtiene el destino al que pertenece este evento (opcional).
     */
    public function destino(): BelongsTo
    {
        return $this->belongsTo(Destino::class);
    }

    /**
     * Obtiene las reseñas asociadas a este evento.
     */
    public function resenas(): HasMany
    {
        return $this->hasMany(Resena::class);
    }

    /**
     * Obtiene los favoritos asociados a este evento.
     */
    public function favoritos(): HasMany
    {
        return $this->hasMany(Favorito::class);
    }
}
