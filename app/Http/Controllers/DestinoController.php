<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use App\Models\Provincia;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DestinoController extends Controller
{
    protected $weather;

    public function __construct(WeatherService $weather)
    {
        $this->weather = $weather;
    }

    public function porProvincia(string $nombre)
    {
        $provincia = Provincia::where('nombre', $nombre)
            ->orWhere('nombre', 'like', '%' . $nombre . '%')
            ->with(['destinos', 'eventos', 'gastronomia', 'imagenes'])
            ->first();

        if ($provincia) {
            $destinos = $provincia->destinos;
        } else {
            $destinos = Destino::where('provincia', $nombre)->get();
        }

        $gastronomia = $provincia ? $provincia->gastronomia : collect();

        $coordenadasCapitales = [
            'Buenos Aires' => [-34.6037, -58.3816],
            'Catamarca' => [-28.4696, -65.7852],
            'Chaco' => [-27.4513, -59.0177],
            'Chubut' => [-43.2934, -65.1078],
            'Córdoba' => [-31.4135, -64.1811],
            'Corrientes' => [-27.4806, -58.8341],
            'Entre Ríos' => [-31.7333, -60.5333],
            'Formosa' => [-26.1775, -58.1781],
            'Jujuy' => [-24.1858, -65.2995],
            'La Pampa' => [-36.6167, -64.2833],
            'La Rioja' => [-29.4131, -66.8558],
            'Mendoza' => [-32.8908, -68.8458],
            'Misiones' => [-27.3671, -55.8960],
            'Neuquén' => [-38.9516, -68.0591],
            'Río Negro' => [-40.8135, -63.0154],
            'Salta' => [-24.7821, -65.4117],
            'San Juan' => [-31.5375, -68.5364],
            'San Luis' => [-33.2950, -66.3356],
            'Santa Cruz' => [-51.6230, -69.2168],
            'Santa Fe' => [-31.6333, -60.7000],
            'Santiago del Estero' => [-27.7824, -64.2661],
            'Tierra del Fuego' => [-54.8019, -68.3030],
            'Tucumán' => [-26.8083, -65.2176],
            'Ciudad Autónoma de Buenos Aires' => [-34.6037, -58.3816],
        ];

        $clima = null;
        $pronostico = null;
        if (isset($coordenadasCapitales[$nombre])) {
            [$lat, $lng] = $coordenadasCapitales[$nombre];
            $clima = $this->weather->getCurrentWeather($lat, $lng);
            $pronostico = $this->weather->getForecast($lat, $lng);
        }

        return view('provincia', compact('destinos', 'provincia', 'nombre', 'clima', 'pronostico', 'gastronomia'));
    }
    public function show(int $id)
    {
        $destino = Destino::with(['provincia', 'eventos', 'resenas.user', 'resenas.imagenes'])->findOrFail($id);

        /** @var \App\Models\User|null $user */
        $user = \Illuminate\Support\Facades\Auth::user();
        if ($user) {
            $user->load('favoritos', 'destinosVisitados');
        }

        $clima = null;
        $pronostico = null;

        if ($destino->ubicacion) {
            $coords = DB::select('SELECT ST_Y(ubicacion::geometry) as lat, ST_X(ubicacion::geometry) as lng FROM destinos WHERE id = ?', [$destino->id])[0];
            $clima = $this->weather->getCurrentWeather($coords->lat, $coords->lng);
            $pronostico = $this->weather->getForecast($coords->lat, $coords->lng);
        }

        return view('destinos.show', compact('destino', 'clima', 'pronostico'));
    }
}
