<?php

namespace App\Models\Music\Genre;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;
use Laravel\Scout\Searchable;

class Genre extends Model
{
    use GenreAttribute,
    	GenreRelationship,
    	GenreScope,
        Mediable;

    protected $fillable = ['name', 'slug', 'description'];

    protected $dates = ['deleted_at'];
}
