<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    use HasFactory;

    protected $table = 'anime';
    protected $primaryKey = 'id';

    // Define which fields are mass assignable (for mass assignment)
    protected $fillable = [
        'mal_id',
        'slug',
        'url',
        'title', 
        'type', 
        'synopsis', 
        'status', 
        'rating', 
        'score', 
        'popularity',
        'aired_from',
        'aired_to',
        'duration',
        'year',
    ];

}
