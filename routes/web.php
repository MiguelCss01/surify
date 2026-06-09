<?php

use App\Http\Controllers\DestinoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResenaController;
use Illuminate\Support\Facades\Route;

// para mostrar la vista home.blade.php (osea lo primero que se ve)
Route::get('/', function () {
    return view('home'); 
})->name('home');

// 2. MAPA NACIONAL: Pantalla donde elegís la provincia
Route::get('/mapa', function () {
    $provincias = \App\Models\Provincia::all();
    return view('mapa_nacional', compact('provincias')); 
})->name('mapa.nacional');

// 3. VISTA PROVINCIAL: Cuando ya elegiste una provincia y ves la lista
Route::get('/provincia/{nombre}', [DestinoController::class, 'porProvincia'])->name('provincia.show');

// 4. FICHA DE DESTINO: El detalle final
Route::get('/destinos/{id}', [DestinoController::class, 'show'])->name('destinos.show');

// 5. Rutas para Eventos y Festividades
Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
Route::get('/eventos/{id}', [EventoController::class, 'show'])->name('eventos.show');

// 6. Rutas para la Participación Comunitaria (Reseñas)
Route::post('/resenas', [ResenaController::class, 'store'])->name('resenas.store');


// --- RUTAS DE AUTENTICACIÓN Y PERFIL (BREEZE) ---

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// 7. Herramientas (solo usuarios registrados)
use App\Http\Controllers\CombustibleController;

Route::middleware('auth')->group(function () {
    Route::get('/herramientas/combustible', [CombustibleController::class, 'index'])->name('combustible.index');
});

// Ruta temporal - módulo Combustible (pendiente de implementar)
Route::middleware('auth')->get('/combustible', function () {
    return view('dashboard'); // redirige al dashboard hasta que esté listo
})->name('combustible.index');

require __DIR__.'/auth.php';
