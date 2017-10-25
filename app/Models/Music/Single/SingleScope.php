<?php

namespace App\Models\Music\Single;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait SingleScope
{
	public function scopeByCategoryAndGenre(Builder $query, Model $category, Model $genre)
	{
		return $query->has('track')
            	->where('category_id', $category->id)
            	->where('genre_id', $genre->id);
	}

	public function scopeByGenre(Builder $query, Model $genre)
	{
		return $query->has('track')
				->where('genre_id', $genre->id);
	}

	public function scopeByCategory(Builder $query, Model $category)
    {
    	return $query->has('track')
    			->where('category_id', $category->id);
    }
}