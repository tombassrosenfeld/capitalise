<?php

namespace App\Services;

use App\Exceptions\CapitalCitiesDataHttpException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class CapitalCitiesData
{
    public function getOptions(): array
    {
        $options = $this->getCountriesData()->random(3);

        return [
            'country' => $options->random()->name,
            'cities' => $options->pluck('capital'),
        ];
    }

    public function getCountryData(string $country): array
    {
        $countryData = $this->getCountriesData()->firstWhere('name', $country);
        return [
            'name' => $countryData->name,
            'capital' => $countryData->capital,
        ];
    }

    private function getCountriesData(): Collection
    {
        try {
            $response = Http::get(config('services.capital_cities_data.api_url'))->throw();
        } catch (HttpClientException $e) {
            throw new CapitalCitiesDataHttpException($e->getMessage(), $e->getCode());
        }
        return collect(json_decode($response->body())->data);
    }
}
