<?php

namespace App\Models\Music\Genre;

trait GenreRelationship
{
	public function genreable()
	{
		return $this->morphTo();
	}
	
	public function categories()
	{
		return $this->belongsToMany(config('music.category.model'));
	}
}