<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/fetch-anime', [AnimeController::class, 'fetchAndStoreTop100Anime']);
