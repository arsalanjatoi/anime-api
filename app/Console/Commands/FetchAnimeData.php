<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Anime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class FetchAnimeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-anime-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://api.jikan.moe/v4/top/anime');
    
        if ($response->failed()) {
            $this->error('Failed to fetch data from Jikan API');
            return;
        }
    
        $animeData = $response->json('data');
    
        foreach ($animeData as $anime) {
            Anime::updateOrCreate(
                ['mal_id' => $anime['mal_id']],
                [
                    'slug' => Str::slug($anime['title']),
                    'title' => $anime['title'],
                    'synopsis' => $anime['synopsis'],
                    'type' => $anime['type'],
                    'rating' => $anime['rating'],
                    'episodes' => $anime['episodes'],
                ]
            );
        }
    
        $this->info('Anime data imported successfully!');
    }
}
