<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    /**
     * Obtiene los usuarios que tienen asignado este rol.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * Obtiene los permisos asociados a este rol.
     */
    public function permisos(): BelongsToMany
    {
        return $this->belongsToMany(Permiso::class, 'role_permiso');
    }
}
