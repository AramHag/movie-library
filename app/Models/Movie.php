<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'director', 'genre', 'release_year' , 'description',
    ];


    protected $casts = [
        'release_year' => 'integer',
    ];


    public function rates()
    {
        return $this->hasMany(Rate::class, 'movie_id', 'id');
    }

}
