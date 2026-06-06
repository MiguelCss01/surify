<?php
use App\Http\Controllers\DestinoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ResenaController;
use Illuminate\Support\Facades\Route;

//para mostrar la vista home.blade.php (osea lo primero que se ve)
Route::get('/', function () {
    return view('home'); 
})->name('home');

// 2. MAPA NACIONAL: Pantalla donde elegís la provincia
Route::get('/mapa', function () {
    $provincias = \App\Models\Provincia::all();
    return view('mapa_nacional', compact('provincias')); 
})->name('mapa.nacional');

// 3. VISTA PROVINCIAL: Cuando ya elegiste una provincia y ves la lista
// Se llama al controlador para que filtre los destinos de esa provincia
Route::get('/provincia/{nombre}', [DestinoController::class, 'porProvincia'])->name('provincia.show');

// 4. FICHA DE DESTINO: El detalle final (el ID 3, etc.)
Route::get('/destinos/{id}', [DestinoController::class, 'show'])->name('destinos.show');

// 3. Rutas para Eventos y Festividades
// Mostrar el calendario o lista de todos los eventos
Route::get('/eventos', [EventoController::class, 'index'])->name('eventos.index');

// Mostrar el detalle de una festividad específica
Route::get('/eventos/{id}', [EventoController::class, 'show'])->name('eventos.show');


// 4. Rutas para la Participación Comunitaria (Reseñas)
// Esta ruta es de tipo "POST" porque es para ENVIAR datos (guardar un comentario), no para ver una pantalla.
Route::post('/resenas', [ResenaController::class, 'store'])->name('resenas.store');