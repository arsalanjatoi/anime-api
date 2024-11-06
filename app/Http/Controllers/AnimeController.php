<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\RateLimiter;
use App\Models\Anime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AnimeController extends Controller
{
    public function fetchAndStoreTop100Anime()
    {
        // Check if rate limit is exceeded
        if (RateLimiter::tooManyAttempts('jikan-api', 60)) {
            Log::warning('Rate limit exceeded for Jikan API at ' . now());
            return response()->json(['message' => 'Rate limit exceeded, please try again later.'], 429);
        }

        // Log request to rate limiter, keeping track of the time of the request
        RateLimiter::hit('jikan-api');

        // Each page giving 25 animes we need 100 so 25 x 4 = 100
        for ($page = 1; $page <= 4; $page++) {
            Log::info("Sending request to Jikan API for page {$page} at " . now());
            // Example API request to fetch anime data for the current page
            $response = Http::withHeaders([
                'Accept' => 'application/json',
            ])->get("https://api.jikan.moe/v4/anime?order_by=popularity&sort=desc&page={$page}");


            if ($response->successful()) {
                Log::info("Successfully fetched data for page {$page} at " . now());
                $animeData = $response->json()['data'];
                foreach ($animeData as $anime) {
                    $existingAnime = Anime::where('mal_id', $anime['mal_id'])->first();
                    // Only store if the anime doesn't exist already
                    if (!$existingAnime) {
                        $airedFrom = isset($anime['aired']['from'])
                            ? Carbon::parse($anime['aired']['from'])->format('Y-m-d')
                            : null;

                        $airedTo = isset($anime['aired']['to'])
                            ? Carbon::parse($anime['aired']['to'])->format('Y-m-d')
                            : null;
                        Anime::create([
                            'mal_id' => $anime['mal_id'],
                            'slug' =>  Str::slug($anime['title']),
                            'url' => $anime['url'],
                            'title' => $anime['title'],
                            'type' => $anime['type'],
                            'synopsis' => $anime['synopsis'],
                            'status' => $anime['status'],
                            'score' => $anime['score'],
                            'popularity' => $anime['popularity'],
                            'aired_from' => $airedFrom,
                            'aired_to' => $airedTo,
                            'duration' => $anime['duration'],
                            'year' => $anime['year'],
                        ]);
                    }
                }
            } else {
                Log::error("Failed to fetch data for page {$page} at " . now() . ". Error: " . $response->body());
                return response()->json(['message' => "Failed to fetch data for page {$page}."]);
            }
        }
        Log::info("Successfully fetched and stored top 100 anime at " . now());
        return response()->json(['message' => 'Top 100 anime fetched and stored successfully.'], 200);
    }

    // API Endpoint to fetch anime by slug
    public function show($slug)
    {
        Log::info("Fetching anime data for slug: {$slug}");
        $anime = Anime::where('slug', $slug)->first();
        if (!$anime) {
            Log::warning("Anime with slug '{$slug}' not found.");
            return response()->json(['error' => 'Anime not found'], 404);
        }

        Log::info("Anime with slug '{$slug}' found.", ['anime' => $anime->toArray()]);
        return response()->json($anime, 200);
    }
}
