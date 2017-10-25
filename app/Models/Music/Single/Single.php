<?php

namespace App\Models\Music\Single;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Single extends Model implements HasMediaConversions
{
    use SingleAttribute,
    	SingleRelationship,
    	SingleScope,
        HasMediaTrait;

    protected $fillable = ['status'];

    protected $with = ['artists'];

     /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($single) {
            $single->track->forceDelete();
        });
    }

    public function attachTrack(Model $track)
	{
		$track = $this->track()->save($track);
        if ($track) {
            $this->artists()->sync($track->all_artists);
            return true;
        }
        return false;
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
}
