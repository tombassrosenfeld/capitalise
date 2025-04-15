<?php

use App\Http\Controllers\CapitalQuizController;
use Illuminate\Support\Facades\Route;

Route::prefix('/capital-quiz')->group(function () {
    Route::get('/', [CapitalQuizController::class, 'getOptions']);
    Route::post('/answer', [CapitalQuizController::class, 'checkAnswer']);
});

