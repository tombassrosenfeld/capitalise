<?php

namespace Tests\Unit;

use App\Services\CapitalCitiesData;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CapitalCitiesDataTest extends TestCase
{
    /**
     * @group capitalCitiesData
     */

    public function test_getOptions_returnsExpectedData()
    {
        $countriesResponse = json_decode(file_get_contents(__DIR__ . '/TestData/CountryDataLimitedResponse.json'));

        Http::fake([
            'https://countriesnow.space/api/v0.1/countries/capital' => Http::response((array)$countriesResponse, 200)
        ]);

        $result = (new CapitalCitiesData)->getOptions();

        $possibleCountries = collect($countriesResponse->data)->pluck('name');

        // As this is random, we need to check that the country is one of the possible options
        $this->assertContains($result['country'], $possibleCountries);
        // The test data is limited to these three options so we know they should be in here
        $this->assertEquals(collect(["Kabul", "Mariehamn", "Tirana",]), $result['cities']);
    }

    public function test_getOptions_countryHasTheCorrectCorrespondingCapital()
    {
        $countriesResponse = json_decode(file_get_contents(__DIR__ . '/TestData/CountryDataFullResponse.json'));

        Http::fake([
            'https://countriesnow.space/api/v0.1/countries/capital' => Http::response((array)$countriesResponse, 200)
        ]);

        $result = (new CapitalCitiesData)->getOptions();

        $countryData = collect($countriesResponse->data)
            ->firstWhere('name', $result['country']);

        // We want to ensure that the correct capital is contained within the city options
        $this->assertContains($countryData->capital, $result['cities']);
    }

    public function test_getCountryData_returnsTheCorrectDataForVietnam()
    {
        $countriesResponse = json_decode(file_get_contents(__DIR__ . '/TestData/CountryDataFullResponse.json'));

        Http::fake([
            'https://countriesnow.space/api/v0.1/countries/capital' => Http::response((array)$countriesResponse, 200)
        ]);

        $result = (new CapitalCitiesData)->getCountryData("Vietnam");

        $this->assertEquals(
            [
                "name" => "Vietnam",
                "capital" => "Hanoi",
            ],
            $result
        );
    }

    public function test_getCountryData_returnsTheCorrectDataForUK()
    {
        $countriesResponse = json_decode(file_get_contents(__DIR__ . '/TestData/CountryDataFullResponse.json'));

        Http::fake([
            'https://countriesnow.space/api/v0.1/countries/capital' => Http::response((array)$countriesResponse, 200)
        ]);

        $result = (new CapitalCitiesData)->getCountryData("United Kingdom");

        $this->assertEquals(
            [
                "name" => "United Kingdom",
                "capital" => "London",
            ],
            $result
        );
    }
}
