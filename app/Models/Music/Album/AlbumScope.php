<?php

namespace App\Models\Music\Album;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait AlbumScope
{
	public function scopeSimilarSlug(Builder $query, $slug)
	{
		return $query->where('slug', $slug);
	}

	public function scopeByCategoryAndGenre(Builder $query, Model $category, Model $genre)
	{
		return $query->where('category_id', $category->id)
                ->where('genre_id', $genre->id);
	}

	public function scopeByGenre(Builder $query, Model $genre)
	{
		return $query->where('genre_id', $genre->id);
	}

	public function scopeByCategory(Builder $query, $category)
    {
    	return $query->where('category_id', $category->id);
    }
}