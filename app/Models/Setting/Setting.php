<?php

namespace App\Models\Setting;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Setting extends Model implements HasMediaConversions
{
	use HasMediaTrait;

    protected $guarded = [];

    public $timestamps = false;

    protected $with = ['media'];

    public function getImageAttribute()
    {
    	if ($this->type == "image") {
    		if ($this->hasMedia("image")) {
    			return $this->getFirstMedia('image');
    		}
    		return null;
    	}
    	return null;
    }

    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
                ->performOnCollections('image')
                ->width(368)
                ->height(232)
                ->sharpen(10)
                ->optimize();
    }
}