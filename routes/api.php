<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

// rate limit of 60 requests per minute
Route::middleware('throttle:60,1')->get('/anime/{slug}', [AnimeController::class, 'show']);
