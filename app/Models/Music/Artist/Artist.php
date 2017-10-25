<?php

namespace App\Models\Music\Artist;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Laravel\Scout\Searchable;

class Artist extends Model implements HasMediaConversions
{
    use ArtistAttribute,
    	ArtistRelationship,
    	ArtistScope,
        HasMediaTrait;

    const UNKNOWN_ID = 1;
    const UNKNOWN_NAME = 'Unknown Artist';
    const VARIOUS_ID = 2;
    const VARIOUS_NAME = 'Various Artists';

    protected $guarded = ['id'];

    protected $fillable = ['name', 'slug', 'bio'];

    protected $dates = ['deleted_at'];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
                ->performOnCollections('image')
                ->width(100)
                ->height(100)
                ->sharpen(10)
                ->optimize();
    }
}
