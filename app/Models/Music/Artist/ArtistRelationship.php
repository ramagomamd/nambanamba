<?php

namespace App\Models\Music\Artist;

trait ArtistRelationship
{
	public function tracks()
	{
		return $this->belongsToMany(config('music.track.model'))
				->withPivot('role');
	}

	public function albums()
	{
		return $this->belongsToMany(config('music.album.model'));
	}

	public function singles()
	{
		return $this->belongsToMany(config('music.single.model'));
	}
}