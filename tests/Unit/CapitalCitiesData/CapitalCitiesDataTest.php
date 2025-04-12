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

    public function test_checkAnswers_returnsTrueForACorrectAnswer()
    {
        $countriesResponse = json_decode(file_get_contents(__DIR__ . '/TestData/CountryDataFullResponse.json'));

        Http::fake([
            'https://countriesnow.space/api/v0.1/countries/capital' => Http::response((array)$countriesResponse, 200)
        ]);

        $result = (new CapitalCitiesData)->checkAnswer("Vietnam", "Hanoi");

        $this->assertTrue($result);
    }

    public function test_checkAnswers_returnsFalseForAnIncorrectAnswer()
    {
        $countriesResponse = json_decode(file_get_contents(__DIR__ . '/TestData/CountryDataFullResponse.json'));

        Http::fake([
            'https://countriesnow.space/api/v0.1/countries/capital' => Http::response((array)$countriesResponse, 200)
        ]);

        $result = (new CapitalCitiesData)->checkAnswer("United Kingdom", "Bristol");

        $this->assertFalse($result);
    }
}
