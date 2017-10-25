<?php

namespace App\Models\Music\Track;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait TrackScope
{
	public function scopeSimilarSlug(Builder $query, $slug)
	{
		return $query->where('slug', $slug);
	}

	public function scopeByArtist(Builder $query, $artist)
	{
		return $query->whereHas('artists', function ($query) use ($artist) {
			$query->where('artist_id', $artist->id);
		});
		/*$artists = $tracks->artists->reject(function($artist) {
            return $artist->pivot->role != 'main';
        });*/
	}
}