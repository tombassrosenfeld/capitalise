<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class CountriesData
{
    public function getOptions(): array
    {
        $countriesData = $this->getCountriesData();

        if ($countriesData->count() < 3) {
            return [];
        }

        $options = $this->getCountriesData()->random(3);

        return [
            'country' => $options->random()->name,
            'cities' => $options->pluck('capital'),
        ];
    }

    public function getCountryData(string $country): array
    {
        $countryData = $this->getCountriesData()->firstWhere('name', $country);

        return empty($countryData) ? []
            : [
                'name' => $countryData->name,
                'capital' => $countryData->capital,
            ];
    }

    private function getCountriesData(): Collection
    {
        $response = Http::get(config('services.capital_cities_data.api_url'));

        // We don't want to throw this exception here but should log it.
        $response->onError(fn (RequestException $e) => report($e));

        return $response->ok() ? collect(json_decode($response->body())->data) : collect();
    }
}
