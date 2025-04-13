<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetCapitalQuizOptionsRequest;
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
                    'code' => 500
                ],
                500,
            );
        }

        return response()->json($options);
    }
}
