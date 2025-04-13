<?php

namespace Feature\Controllers\CapitalQuizController;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CapitalQuizControllerTest extends TestCase
{

    public function test_getOptionsRoute_returnsTheExpectedData()
    {
        $countriesResponse = json_decode(file_get_contents(__DIR__ . '/TestData/CountryDataLimitedResponse.json'));

        Http::fake([
            'https://countriesnow.space/api/v0.1/countries/capital' => Http::response((array)$countriesResponse),
        ]);

        $user = User::factory()->make();

        $response = json_decode($this->actingAs($user)
            ->get('/api/capital-quiz/options')->getContent());

        $possibleCountries = collect($countriesResponse->data)->pluck('name');

        // This logic replicates that of the CountriesDataTest
        $this->assertContains($response->country, $possibleCountries);

        // The test data has only three options, so we know they should all be here
        $this->assertEquals(['Algiers', 'Andorra la Vella', 'Luanda'], $response->cities);
    }

    public function test_getOptionsRoute_returnsTheExpectedResponseOnError()
    {
        Http::fake([
            'https://countriesnow.space/api/v0.1/countries/capital' => Http::response(['message' => "error"], 500),
        ]);

        $user = User::factory()->make();

        $response = $this->actingAs($user)
            ->get('/api/capital-quiz/options');

        $response->assertStatus(500);
        $response->assertJson(["message" => 'Failed to fetch countries data']);
    }

    public function test_checkAnswerRoute_withCorrectAnswer_returnsExpectedResponse()
    {
        $countriesResponse = json_decode(file_get_contents(__DIR__ . '/TestData/CountryDataLimitedResponse.json'));

        Http::fake([
            'https://countriesnow.space/api/v0.1/countries/capital' => Http::response((array)$countriesResponse),
        ]);

        $user = User::factory()->make();

        $response = $this->actingAs($user)
            ->post(
                '/api/capital-quiz/answer',
                ['country' => 'Angola', 'capital' => 'Luanda']
            );

        $response->assertStatus(200);
        $this->assertEquals(
            [
                'correct' => true,
                'country' => 'Angola',
                'capital' => 'Luanda'
            ],
            $response->json()
        );
    }

    public function test_checkAnswerRoute_withWrongAnswer_returnsExpectedResponse()
    {
        $countriesResponse = json_decode(file_get_contents(__DIR__ . '/TestData/CountryDataLimitedResponse.json'));

        Http::fake([
            'https://countriesnow.space/api/v0.1/countries/capital' => Http::response((array)$countriesResponse),
        ]);

        $user = User::factory()->make();

        $response = $this->actingAs($user)
            ->post(
                '/api/capital-quiz/answer',
                ['country' => 'Angola', 'capital' => 'Not Luanda']
            );

        $response->assertStatus(200);
        $this->assertEquals(
            [
                'correct' => false,
                'country' => 'Angola',
                'capital' => 'Luanda'
            ],
            $response->json()
        );
    }
}
