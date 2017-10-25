<?php 

namespace App\Repositories\Backend\Music;

use App\Repositories\BaseRepository;
use App\Models\Music\Genre\Genre;
use Illuminate\Database\Eloquent\Model;
use MediaUploader;

class GenreRepository extends BaseRepository
{
	const MODEL = Genre::class;

	public function create(array $input)
	{
		$name = $input['name'];
		$genre = $this->createGenreStub($name);
		$genre->description = $input['description'];

		$genre->save();

		if($genre) {

			if (isset($input['image'])) {
				$image = $this->uploadCover('uploads', $input['image'], $genre);

				$genre->attachMedia($image, 'image');
			}

			return $genre;
		}

		throw new GeneralException(trans('exceptions.backend.music.genres.create_error'));
	}

	public function update(Model $genre, array $input)
	{
		$slug = str_slug($input['name']);
		if ($slug !== $genre->slug) {
			if ($this->query()->similarSlug($slug)->exists()) {
				throw new GeneralException(trans('exceptions.backend.music.genres.slug_error'));
			}
		}
		$genre->slug = $slug;
		$genre->name = $input['name'];
		$genre->description = $input['description'];

		if($genre->save()) {

			if (isset($input['image'])) {
				if ($genre->image) {
					$genre->image->delete();
				}

				$image = $this->uploadCover('uploads', $input['image'], $genre);

				$genre->syncMedia($image, 'image');

			}

			return $genre;
		}

		throw new GeneralException(trans('exceptions.backend.music.genres.update_error'));
	}

	public function uploadCover($disk, $file, Model $genre)
	{
		$media = MediaUploader::fromSource($file)
				->toDestination($disk, $this->directory($genre))
				->useHashForFilename()
				->upload();

		return $media;
	}

	public function directory(Model $genre)
	{
		$title = title_case($genre->name);

		return 'music/covers/genres/'. $title;
	}

	public function createGenreStub($name)
	{
		$genre = $this->query()->firstOrCreate(['slug' => str_slug($name)], ['name' => $name]);

		return $genre;
	}

    public function delete(Model $genre)
    {
    	$genre->delete();
    }
}