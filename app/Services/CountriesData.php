<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;


class CountriesData
{
    private const NO_CAPITAL_CITY = 'No capital city';

    public function getOptions(): array
    {
        $countriesData = $this->getCountriesData();

        if ($countriesData->count() < 3) {
            return [];
        }

        $options = $this->getCountriesData()->random(3);
        $cities = $options->pluck('capital')
            ->map(fn ($capital) => $capital ?: self::NO_CAPITAL_CITY);

        return [
            'country' => $options->random()->name,
            'cities' => $cities,
        ];
    }

    public function getCountryData(string $country): array
    {
        $countryData = $this->getCountriesData()->firstWhere('name', $country);

        return empty($countryData) ? []
            : [
                'country' => $countryData->name,
                'capital' => $countryData->capital ?: self::NO_CAPITAL_CITY,
            ];
    }

    private function getCountriesData(): Collection
    {
        $response = Http::get(config('services.capital_cities_data.api_url'));

        // We don't want to throw this exception here but should log it.
        $response->onError(fn () => report($response->toException()));

        return $response->ok() ? collect(json_decode($response->body())->data) : collect();
    }
}
