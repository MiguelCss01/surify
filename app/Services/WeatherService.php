<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    protected string $apiKey = '';
    protected string $baseUrl = 'https://api.openweathermap.org/data/2.5';

    public function _construct()
    {
        $this->apiKey = config('services.openweather.key') ?? '';
    }

    public function getCurrentWeather(float $lat, float $lng): ?array
    {
        $cacheKey = "weather{$lat}{$lng}";
        $apiKey = $this->apiKey;
        $baseUrl = $this->baseUrl;

        return Cache::remember($cacheKey, 1800, function () use ($lat, $lng, $apiKey, $baseUrl) {
            $response = Http::withoutVerifying()->get("{$baseUrl}/weather", [
                'lat' => $lat,
                'lon' => $lng,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'es',
            ]);

            return $response->successful() ? $response->json() : null;
        });
    }

    public function getForecast(float $lat, float $lng): ?array
    {
        $cacheKey = "forecast{$lat}_{$lng}";
        $apiKey = $this->apiKey;
        $baseUrl = $this->baseUrl;

        return Cache::remember($cacheKey, 1800, function () use ($lat, $lng, $apiKey, $baseUrl) {
            $response = Http::withoutVerifying()->get("{$baseUrl}/forecast", [
                'lat' => $lat,
                'lon' => $lng,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'es',
                'cnt' => 8,
            ]);

            return $response->successful() ? $response->json() : null;
        });
    }
}