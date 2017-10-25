<?php 

namespace App\Repositories\Backend\Music;

use App\Repositories\BaseRepository;
use App\Models\Music\Category\Category;
use App\Models\Music\Genre\Genre;
use App\Models\Music\Album\Album;
use App\Models\Music\Single\Single;
use Illuminate\Database\Eloquent\Model;
use App\Events\Backend\Music\Category\CategoryCreated;
use App\Events\Backend\Music\Category\CategoryUpdated;
use App\Events\Backend\Music\Category\CategoryDeleted;

class CategoryRepository extends BaseRepository
{
	const MODEL = Category::class;

	protected $genres;

	public function __construct(GenreRepository $genres)
	{
		$this->genres = $genres;
	}

	public function create(array $input)
	{
		$name = $input['name'];
		$category = $this->createCategoryStub($name);
		$category->update(['description', $input['description']]);
		if (!empty($input['genres']) && !is_null($input['genres'])) {
			foreach ($input['genres'] as $genre) {
				$genre = $this->genres->createGenreStub($genre);
				$category->genres()->attach($genre);
			}
		}

		if($category) {
			event(new CategoryCreated($category));
			return $category;
		}

		throw new GeneralException(trans('exceptions.backend.music.categories.create_error'));
	}

	public function update(Model $category, array $input)
	{
		$slug = str_slug($input['name']);
		if ($slug !== $category->slug) {
			if ($this->query()->similarSlug($slug)->exists()) {
				throw new GeneralException(trans('exceptions.backend.music.categories.slug_error'));
			}
		}
		$category->slug = $slug;
		$category->name = $input['name'];
		$category->description = $input['description'];
		if (!empty($input['genres']) && !is_null($input['genres'])) {
			// Detach every genre with no album or a single
			$genres = Genre::each(function ($genre) use ($category) {
	            $albums = Album::byCategoryAndGenre($category, $genre);
	            $singles = Single::byCategoryAndGenre($category, $genre);
	            if ($albums->exists() || $singles->exists()) {
	                return;
	            }
	            $category->genres()->detach($genre);
	        });
	        // Attach New Genres
	        foreach ($input['genres'] as $genre) {
				$genre = $this->genres->createGenreStub($genre);
				$category->genres()->attach($genre);
			}
		}

		if($category->save()) {
			event(new CategoryUpdated($category));

			return $category;
		}

		throw new GeneralException(trans('exceptions.backend.music.categories.update_error'));
	}

	public function createCategoryStub($name)
	{
		$category = $this->query()->firstOrCreate(['slug' => str_slug($name)], ['name' => $name]);

		return $category;
	}

	public function delete(Model $category)
	{
		if ($category->delete()) {
			event(new CategoryDeleted($category));

			return true;
		}

		throw new GeneralException(trans('exceptions.backend.music.categories.delete_error'));
	}
}