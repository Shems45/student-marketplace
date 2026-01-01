<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeocodingService
{
    /**
     * Geocode a Belgian postcode + city into coordinates.
     * Returns ['lat' => float, 'lng' => float] or null on failure.
     */
    public function geocode(string $zip, string $city): ?array
    {
        $zip = trim($zip);
        $city = trim($city);

        if ($zip === '' || $city === '') {
            return null;
        }

        $cacheKey = sprintf('geo:%s:%s', strtolower($zip), strtolower($city));

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::withHeaders([
                'User-Agent' => config('app.name', 'Student Marketplace') . ' geocoder',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => sprintf('%s %s, Belgium', $zip, $city),
                'format' => 'json',
                'limit' => 1,
            ]);

            if (!$response->ok()) {
                return null;
            }

            $payload = $response->json();
            if (!is_array($payload) || empty($payload)) {
                return null;
            }

            $first = $payload[0];
            if (!isset($first['lat'], $first['lon'])) {
                return null;
            }

            $coords = [
                'lat' => (float) $first['lat'],
                'lng' => (float) $first['lon'],
            ];

            Cache::put($cacheKey, $coords, now()->addDays(30));

            return $coords;
        } catch (\Throwable $e) {
            Log::warning('Geocoding failed', [
                'zip' => $zip,
                'city' => $city,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }
}
