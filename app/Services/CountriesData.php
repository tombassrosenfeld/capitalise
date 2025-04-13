<?php

namespace App\Services;

use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class CountriesData
{
    public function getOptions(): array
    {
        $options = $this->getCountriesData()->random(3);

        return $options->isEmpty() ? [] : [
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
        try {
            $response = Http::get(config('services.capital_cities_data.api_url'))->throw();
        } catch (HttpClientException $e) {
            report($e);
            return collect();
        }

        return collect(json_decode($response->body())->data);
    }
}
