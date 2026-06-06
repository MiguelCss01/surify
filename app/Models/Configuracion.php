<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configuracion extends Model
{
    use HasFactory;

    protected $table = 'configuraciones'; // Laravel pluralizaría a 'configuracions', así que forzamos 'configuraciones'.

    protected $fillable = [
        'clave',
        'valor',
        'descripcion',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
    ];
}
