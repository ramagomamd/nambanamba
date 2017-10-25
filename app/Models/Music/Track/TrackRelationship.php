<?php

namespace App\Models\Music\Track;

trait TrackRelationship
{
	public function trackable()
	{
		return $this->morphTo();
	}

	public function artists()
	{
		return $this->belongsToMany(config('music.artist.model'))
					->withPivot('role');
	}
}