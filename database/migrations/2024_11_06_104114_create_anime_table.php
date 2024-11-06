<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('anime', function (Blueprint $table) {
            $table->id();
            $table->integer('mal_id')->unique();
            $table->string('slug')->unique();
            $table->string('url'); // URL to the anime
            $table->string('title');
            $table->string('title_english')->nullable();
            $table->string('title_japanese')->nullable();
            $table->json('title_synonyms')->nullable();
            $table->string('type')->nullable();
            $table->string('source')->nullable(); // Source of anime (e.g., manga, novel)
            $table->integer('episodes')->default(0);
            $table->string('status')->nullable();
            $table->boolean('airing')->default(false);
            $table->date('aired_from')->nullable();
            $table->date('aired_to')->nullable();
            $table->date('airing_prop_from')->nullable();
            $table->date('airing_prop_to')->nullable();
            $table->string('airing_prop_string')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('score', 3, 1)->nullable();
            $table->integer('scored_by')->default(0);
            $table->integer('rank')->default(0);
            $table->integer('popularity')->default(0);
            $table->integer('members')->default(0);
            $table->integer('favorites')->default(0);
            $table->text('synopsis')->nullable();
            $table->text('background')->nullable();
            $table->integer('year')->nullable();
            $table->string('broadcast_day')->nullable();
            $table->string('broadcast_time')->nullable();
            $table->string('broadcast_timezone')->nullable();
            $table->json('producers')->nullable();
            $table->json('licensors')->nullable();
            $table->json('studios')->nullable();
            $table->json('genres')->nullable();
            $table->json('explicit_genres')->nullable();
            $table->json('themes')->nullable();
            $table->json('demographics')->nullable();
            $table->string('trailer_youtube_id')->nullable();
            $table->string('trailer_url')->nullable();
            $table->string('trailer_embed_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anime');
    }
};
