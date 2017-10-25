<?php

namespace App\Models\Music\Track;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Laravel\Scout\Searchable;

class Track extends Model implements HasMediaConversions
{
    use TrackAttribute,
    	TrackRelationship,
    	TrackScope,
        HasMediaTrait;

    protected $fillable = [
    			'title', 'slug', 'year', 'number', 
    			'comment', 'album', 'composer', 
    			'bitrate', 'duration', 'copyright'
    ];

    protected $with = ['artists', 'trackable.category', 'trackable.genre', 'media'];

    protected $appends = ['url', 'full_title'];

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
                ->performOnCollections('cover')
                ->width(100)
                ->height(100)
                ->sharpen(10)
                ->optimize();
    }
}
