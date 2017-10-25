<?php

namespace App\Models\Music\Genre;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait GenreScope
{
	public function scopeSimilarSlug(Builder $query, $slug)
	{
		return $query->where('slug', $slug);
	}
}