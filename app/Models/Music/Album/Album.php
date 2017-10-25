<?php

namespace App\Models\Music\Album;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Laravel\Scout\Searchable;

class Album extends Model implements HasMediaConversions
{
    use AlbumAttribute,
    	AlbumRelationship,
    	AlbumScope,
        HasMediaTrait;

    protected $fillable = ['artist_id', 'title', 'slug', 'description', 'status'];

    /**
     * The relationships to always eager-load.
     *
     * @var array
     */
    protected $with = ['artists', 'media'];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($album) {
            $album->tracks->each->forceDelete();
        });
    }

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
                ->performOnCollections('cover')
                ->width(100)
                ->height(100)
                ->sharpen(10)
                ->optimize();
    }

    public function attachTrack(Model $track)
	{
		return $this->tracks()->save($track) ? true : false;
	}
}
