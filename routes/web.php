<?php

use App\Http\Controllers\DestinoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\CombustibleController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// 1. HOME
Route::get('/', function () {
    return view('home');
})->name('home');

// 2. MAPA NACIONAL
Route::get('/mapa', function () {
    $provincias = \App\Models\Provincia::all();
    $destinos = \App\Models\Destino::where('activo', true)->with('provincia')->get()->map(function ($d) {
            $coords = DB::select('SELECT ST_Y(ubicacion::geometry) as lat, ST_X(ubicacion::geometry) as lng FROM destinos WHERE id = ?', [$d->id])[0];
        return [
            'id' => $d->id,
            'nombre' => $d->nombre,
            'descripcion' => $d->descripcion,
            'categoria' => $d->categoria,
            'imagen_url' => $d->imagen_url,
            'provincia' => $d->provincia->nombre ?? '',
            'lat' => $coords->lat,
            'lng' => $coords->lng,
        ];
    });
    return view('mapa_nacional', compact('provincias', 'destinos'));
})->name('mapa.nacional');

// 3. VISTA PROVINCIAL
Route::get('/provincia/{nombre}', [DestinoController::class, 'porProvincia'])->name('provincia.show');

// 4. FICHA DE DESTINO
Route::get('/destinos/{id}', [DestinoController::class, 'show'])->name('destinos.show');

// 5. EVENTOS
Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
Route::get('/eventos/{id}', [EventoController::class, 'show'])->name('eventos.show');

// 6. RESEÑAS
Route::post('/resenas', [ResenaController::class, 'store'])->name('resenas.store');

// 7. DASHBOARD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 8. PERFIL Y HERRAMIENTAS (auth)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    Route::get('/herramientas/combustible', [CombustibleController::class, 'index'])->name('combustible.index');
});

require __DIR__ . '/auth.php';
