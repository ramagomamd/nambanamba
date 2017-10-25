<?php

namespace App\Models\Music\Category;

trait CategoryRelationship
{
	public function categorables()
	{
		return $this->morphTo();
	}
	
	public function genres()
	{
		return $this->belongsToMany(config('music.genre.model'));
	}
}