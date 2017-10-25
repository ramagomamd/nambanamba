<?php

namespace App\Models\Music\Single;

trait SingleRelationship
{
	public function category()
	{
		return $this->belongsTo(config('music.category.model'));
	}

	public function genre()
	{
		return $this->belongsTo(config('music.genre.model'));
	}
	
	public function artists()
	{
		return $this->belongsToMany(config('music.artist.model'));
	} 
	
	public function track()
	{
		return $this->morphOne(config('music.track.model'), 'trackable');
	}
}