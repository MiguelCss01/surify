<?php

use App\Http\Controllers\DestinoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\CombustibleController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\DestinoController as AdminDestinoController;
use App\Http\Controllers\Admin\ResenaController as AdminResenaController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\EventoController as AdminEventoController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// ==================== ADMIN ====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('roles', RolController::class);
    Route::resource('destinos', AdminDestinoController::class);
    Route::resource('usuarios', UsuarioController::class)->only(['index', 'edit', 'update']);

    Route::get('/resenas', [AdminResenaController::class, 'index'])->name('resenas.index');
    Route::patch('/resenas/{resena}/aprobar', [AdminResenaController::class, 'aprobar'])->name('resenas.aprobar');
    Route::patch('/resenas/{resena}/rechazar', [AdminResenaController::class, 'rechazar'])->name('resenas.rechazar');
    Route::delete('/resenas/{resena}', [AdminResenaController::class, 'destroy'])->name('resenas.destroy');

    Route::get('/eventos', [AdminEventoController::class, 'index'])->name('eventos.index');
    Route::get('/eventos/{evento}/edit', [AdminEventoController::class, 'edit'])->name('eventos.edit');
    Route::put('/eventos/{evento}', [AdminEventoController::class, 'update'])->name('eventos.update');
    Route::delete('/eventos/{evento}', [AdminEventoController::class, 'destroy'])->name('eventos.destroy');
});

// ==================== PÚBLICO ====================
Route::get('/', function () {
    $destinos = \App\Models\Destino::where('activo', true)
        ->with('provincia')
        ->get()
        ->map(function ($d) {
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

    $ciudadesRepresentativas = [
        ['provincia' => 'Patagonia', 'ciudad' => 'Bariloche', 'lat' => -41.1335, 'lng' => -71.3103],
        ['provincia' => 'Cuyo', 'ciudad' => 'Mendoza', 'lat' => -32.8908, 'lng' => -68.8458],
        ['provincia' => 'Norte', 'ciudad' => 'Salta', 'lat' => -24.7821, 'lng' => -65.4117],
        ['provincia' => 'Pampeana', 'ciudad' => 'Buenos Aires', 'lat' => -34.6037, 'lng' => -58.3816],
        ['provincia' => 'Litoral', 'ciudad' => 'Iguazú', 'lat' => -25.5991, 'lng' => -54.5736],
    ];

    $weatherService = app(\App\Services\WeatherService::class);
    $climaData = [];
    foreach ($ciudadesRepresentativas as $c) {
        $data = null;
        try {
            $data = $weatherService->getCurrentWeather($c['lat'], $c['lng']);
        } catch (\Exception $e) {
            // Ignorar errores de conexión/API
        }

        if ($data && isset($data['main']['temp']) && isset($data['weather'][0]['icon'])) {
            $climaData[] = [
                'provincia' => $c['provincia'],
                'ciudad' => $c['ciudad'],
                'temp' => $data['main']['temp'],
                'icono' => $data['weather'][0]['icon']
            ];
        } else {
            // Fallback en caso de falla
            $mockTemps = [
                'Bariloche' => 2,
                'Mendoza' => 24,
                'Salta' => 28,
                'Buenos Aires' => 18,
                'Iguazú' => 30
            ];
            $mockIcons = [
                'Bariloche' => '13d',
                'Mendoza' => '01d',
                'Salta' => '02d',
                'Buenos Aires' => '03d',
                'Iguazú' => '10d'
            ];
            $climaData[] = [
                'provincia' => $c['provincia'],
                'ciudad' => $c['ciudad'],
                'temp' => $mockTemps[$c['ciudad']] ?? 15,
                'icono' => $mockIcons[$c['ciudad']] ?? '01d'
            ];
        }
    }

    return view('home', compact('destinos', 'climaData'));
})->name('home');

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
    Route::post('/eventos/sugerir', [\App\Http\Controllers\EventoSugerenciaController::class, 'store'])->name('eventos.sugerir');
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
        'provincias',
        'countDestinos',
        'countUsuarios',
        'countEventos',
        'countRoles',
        'countPermisos'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // ... las rutas que ya tenés
    Route::post('/favoritos/toggle', [\App\Http\Controllers\FavoritoController::class, 'toggle'])->name('favoritos.toggle');
});

Route::post('/visitados/toggle', [\App\Http\Controllers\DestinoVisitadoController::class, 'toggle'])->name('visitados.toggle');
require __DIR__ . '/auth.php';
