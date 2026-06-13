<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    protected ?string $apiKey;
    protected $baseUrl = 'https://api.openweathermap.org/data/2.5';

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key');
    }

    public function getCurrentWeather(float $lat, float $lng): ?array
    {
        $cacheKey = "weather_{$lat}_{$lng}";

        return Cache::remember($cacheKey, 1800, function () use ($lat, $lng) {
            $response = Http::get("{$this->baseUrl}/weather", [
                'lat' => $lat,
                'lon' => $lng,
                'appid' => $this->apiKey,
                'units' => 'metric',
                'lang' => 'es',
            ]);

            return $response->successful() ? $response->json() : null;
        });
    }

    public function getForecast(float $lat, float $lng): ?array
    {
        $cacheKey = "forecast_{$lat}_{$lng}";

        return Cache::remember($cacheKey, 1800, function () use ($lat, $lng) {
            $response = Http::get("{$this->baseUrl}/forecast", [
                'lat' => $lat,
                'lon' => $lng,
                'appid' => $this->apiKey,
                'units' => 'metric',
                'lang' => 'es',
                'cnt' => 8,
            ]);

            return $response->successful() ? $response->json() : null;
        });
    }
}