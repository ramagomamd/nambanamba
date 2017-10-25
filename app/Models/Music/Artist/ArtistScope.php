<?php

namespace App\Models\Music\Artist;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait ArtistScope
{
	public function scopeSimilarSlug(Builder $query, $slug)
	{
		return $query->where('slug', $slug);
	}
}