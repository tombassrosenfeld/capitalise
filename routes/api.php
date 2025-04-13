<?php

use App\Http\Controllers\CapitalQuizController;
use Illuminate\Support\Facades\Route;


Route::get('capital-quiz/options', [CapitalQuizController::class, 'getOptions']);
