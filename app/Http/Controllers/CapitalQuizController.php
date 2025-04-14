<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCapitalQuizOptionsRequest;
use App\Http\Requests\PostCapitalQuizAnswerRequest;
use App\Services\CountriesData;
use Illuminate\Http\JsonResponse;

class CapitalQuizController extends Controller
{
    public function getOptions(GetCapitalQuizOptionsRequest $request, CountriesData $countriesData): JsonResponse
    {
        $options = $countriesData->getOptions();

        if (empty($options)) {
            return response()->json(
                [
                    'message' => 'Failed to fetch countries data',
                ],
                500,
            );
        }

        return response()->json($options);
    }

    public function checkAnswer(PostCapitalQuizAnswerRequest $request, CountriesData $countriesData): JsonResponse
    {
        ['country' => $country, 'capital' => $capital] = $request->validated();

        $countryData = $countriesData->getCountryData($country);

        if (empty($countryData)) {
            return response()->json(
                [
                    'message' => 'Failed to fetch country data'
                ],
                500
            );
        }

        return response()->json([
            'correct' => $countryData['capital'] === $capital,
            ...$countryData,
        ]);
    }
}
