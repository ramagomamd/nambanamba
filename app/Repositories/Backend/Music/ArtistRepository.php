<?php 

namespace App\Repositories\Backend\Music;

use App\Repositories\BaseRepository;
use App\Models\Music\Artist\Artist;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Models\Music\Track\Track;
use App\Helpers\Validators\Mimes;
use Spatie\Image\Image;
use Illuminate\Support\Facades\Cache;
use Spatie\Image\Manipulations;
use App\Repositories\Backend\Music\CacheRepository;

class ArtistRepository extends BaseRepository
{
	const MODEL = Artist::class;

	protected $validate;
	protected $cache;

	public function __construct(Mimes $validate, CacheRepository $cache)
	{
		$this->validate = $validate;
		$this->cache = $cache;
	}

	public function create(array $input)
	{
		$name = $input['name'];
		$artist = $this->createArtistStub($name);
		$artist->update(['bio', $input['bio']]);
		$artist->save();

		if (!empty($image = $input['image']) && $image->isValid()) {
			if ($this->validate->image($image)) {
				$media = $artist->addMedia($image)
					->usingName($artist->name)
					->usingFileName(str_slug($artist->name) . "-image.{$image->extension()}")
					->toMediaLibrary('image');

				if ($media) {
					$watermark_image = $this->cache->findOrMake('settings', 'watermark_logo')
												->getFirstMedia('image')
												->getPath();

					Image::load($media->getPath())
						->watermark($watermark_image)
						->watermarkOpacity(80)
						->watermarkPosition(Manipulations::POSITION_TOP)      // Watermark at the top
						->watermarkHeight(50, Manipulations::UNIT_PERCENT)    // 50 percent height
						->watermarkWidth(100, Manipulations::UNIT_PERCENT)
						->width(310)
						->height(330)
						->optimize()
						->save();
				}
			}
		}

		return $artist;
	}

	public function update(Model $artist, array $input)
	{
		$slug = str_slug($input['name']);
		if ($slug !== $artist->slug) {
			if ($this->query()->similarSlug($slug)->exists()) {
				throw new GeneralException(trans('exceptions.backend.music.artists.artist_exists'));
			}
		}

		$artist->name = $input['name'];
		$artist->slug = $slug;
		$artist->bio = $input['bio'];

		if($artist->save()) {

			if (!empty($image = $input['image']) && $image->isValid()) {
				if ($this->validate->image($image)) {
					if ($artist->hasMedia('image')) {
						$artist->getMedia('image')->each->delete();
					}
					$media = $artist->addMedia($image)
						->usingName($artist->name)
						->usingFileName(str_slug($artist->name) . "-image.{$image->extension()}")
						->toMediaLibrary('image');

					if ($media) {
						$watermark_image = $this->cache->findOrMake('settings', 'watermark_logo')
												->getFirstMedia('image')
												->getPath();

						Image::load($media->getPath())
							->watermark($watermark_image)
							->watermarkOpacity(80)
							->watermarkPosition(Manipulations::POSITION_TOP)      // Watermark at the top
							->watermarkHeight(50, Manipulations::UNIT_PERCENT)    // 50 percent height
							->watermarkWidth(100, Manipulations::UNIT_PERCENT)
							->width(310)
							->height(330)
							->optimize()
							->save();
					}
				}
			}

			return $artist;
		} 
		throw new GeneralException(trans('exceptions.backend.music.artists.update_error'));
	}

	public function createArtistStub($name)
	{
		$artist = $this->query()->firstOrCreate(['slug' => str_slug($name)], ['name' => $name]);

		return $artist;
	}

    public function delete(Model $artist)
    {
    	// TODO: Check if artist has albums, singles or tracks hanging...
    	$artist->delete();
    }
}