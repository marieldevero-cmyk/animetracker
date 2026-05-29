<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Anime extends Model
{
    protected $table = 'ghibli_animes';

    protected $fillable = [
        'user_id',
        'title',
        'movie_year',
        'genre',
        'duration',
        'synopsis',
        'rating',
        'japanese_name',
        'director',
        'poster',
        'current_status',
    ];

    protected function casts(): array
    {
        return [
            'movie_year' => 'integer',
            'rating' => 'decimal:1',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
