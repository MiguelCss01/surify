<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvinciaImagen extends Model
{
    protected $table = 'provincia_imagenes';
    protected $fillable = ['provincia_id', 'url', 'descripcion', 'orden'];
}