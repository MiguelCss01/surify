<?php

use App\Http\Controllers\DestinoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\CombustibleController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\DestinoController as AdminDestinoController;
use App\Http\Controllers\Admin\ResenaController as AdminResenaController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('roles', RolController::class);
    Route::resource('destinos', AdminDestinoController::class);
    
    // Reseñas
    Route::get('/resenas', [AdminResenaController::class, 'index'])->name('resenas.index');
    Route::patch('/resenas/{resena}/aprobar', [AdminResenaController::class, 'aprobar'])->name('resenas.aprobar');
    Route::patch('/resenas/{resena}/rechazar', [AdminResenaController::class, 'rechazar'])->name('resenas.rechazar');
    Route::delete('/resenas/{resena}', [AdminResenaController::class, 'destroy'])->name('resenas.destroy');
});
// ==================== PÚBLICO ====================
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/mapa', function () {
    $provincias = \App\Models\Provincia::all();
    return view('mapa_nacional', compact('provincias'));
})->name('mapa.nacional');

Route::get('/provincia/{nombre}', [DestinoController::class, 'porProvincia'])->name('provincia.show');
Route::get('/destinos/{id}', [DestinoController::class, 'show'])->name('destinos.show');

Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');
Route::get('/eventos/{id}', [EventoController::class, 'show'])->name('eventos.show');

// ==================== AUTH ====================
Route::middleware('auth')->group(function () {
    Route::post('/resenas', [ResenaController::class, 'store'])->name('resenas.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    Route::get('/herramientas/combustible', [CombustibleController::class, 'index'])->name('combustible.index');
});

// ==================== DASHBOARD ====================
Route::get('/dashboard', function () {
    $provincias = \App\Models\Provincia::withCount('destinos')->get();
    $countDestinos = \App\Models\Destino::count();
    $countUsuarios = \App\Models\User::count();
    $countEventos = \App\Models\Evento::count();
    $countRoles = \App\Models\Role::count();
    $countPermisos = \App\Models\Permiso::count();

    return view('dashboard', compact(
        'provincias', 'countDestinos', 'countUsuarios',
        'countEventos', 'countRoles', 'countPermisos'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';