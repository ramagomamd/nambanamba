<?php 

namespace App\Repositories\Backend\Music;

use App\Models\Music\Artist\Artist;
use Illuminate\Support\Facades\DB;
use App\Repositories\BaseRepository;
use App\Models\Music\Track\Track;
use App\Models\Music\Album\Album;
use App\Exceptions\GeneralException;
use App\Helpers\Validators\Mimes;
use Illuminate\Http\UploadedFile;
use SplFileInfo;
use App\Services\Music\Tags;
use Storage;
use Spatie\Image\Image;
use Illuminate\Support\Facades\Cache;
use Spatie\Image\Manipulations;
use App\Repositories\Backend\Music\CacheRepository;

class TrackRepository extends BaseRepository
{
	const MODEL = Track::class;

	protected $artists;
	protected $validate;
	protected $cache;

	public function __construct(ArtistRepository $artists, Mimes $validate, CacheRepository $cache)
	{
		$this->artists = $artists;
		$this->validate = $validate;
		$this->cache = $cache;
	}

	public function create($file, $model)
	{
		// dd($file);
		if (!$tags = (new Tags($file))->getInfo()) return false;
		// dd($tags);
		// dd(pathinfo($file->getRealPath(), PATHINFO_EXTENSION));
		// Make A Track Model and Save
		$track = $this->createTrackStub($tags);
		// dd($track);
		// If Model has Cover, Attach its Path to Track
		// $track->cover_path = $model->cover_path;
		// Save Track
		$track->save();
		// Create Artist Entity or Fetch One
		$tags['main'] = $tags['artists']['main'];
		$tags['features'] = $tags['artists']['features'];

		$this->attachArtists($track, $tags);
		// dd($track->fresh());
		
		// Set Track Slug 
		$this->setSlug($track);

		if (!$this->validate->audio($file)) return false;
		// dd($track);

		$track->addMedia($file)
				->usingName(str_limit($track->full_title, 90))
				->usingFileName(str_slug(str_limit($track->full_title, 90)) . ".{$tags['format']}")
				->toMediaLibrary('file');

		if ($model->hasMedia('cover'))  {
			$modelCover = $model->getFirstMedia('cover');
			$cover = $track->copyMedia($modelCover->getPath())
					->usingName(str_limit("{$track->fresh()->full_title} Cover", 90))
					->usingFileName(str_limit("{$track->slug}-cover", 90) . ".{$modelCover->getExtensionAttribute()}")
					->toMediaLibrary('cover');
		} elseif (!$model->hasMedia('cover') && isset($tags['cover']) && !empty($tags['cover']['data'])) {
			// If Model has no Cover, extract it from file and Attach to Track
			$extension = explode('/', $tags['cover']['image_mime']);
	        $extension = empty($extension[1]) ? 'png' : $extension[1];
			$cover = $track->addMediaFromBase64(
					base64_encode($tags['cover']['data']), $tags['cover']['image_mime'])
					->usingName(str_limit("{$track->fresh()->full_title} Cover", 90))
					->usingFileName(str_limit("{$track->slug}-cover", 90) . ".{$extension}")
					->toMediaLibrary('cover');

			if ($cover) {	
				$watermark_image = $this->cache->findOrMake('settings', 'watermark_logo')
												->getFirstMedia('image')
												->getPath();

				Image::load($cover->getPath())
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

		if ($model->attachTrack($track)) {
			$this->setFileTags($track->fresh());
			return $track;
		} else {
			$track->delete();
			return false;
		}
	}

	public function update(Track $track, array $input)
	{
		// Detach All Artists From Track
		$track->artists()->detach();
		// Update Track
		$track = $this->updateTrackStub($track, $input);

		// Update Track Cover
		if (!empty($cover = $input['cover']) && $cover->isValid()) {
			// $this->updateTrackCover($track, $input['cover']);
			if ($this->validate->image($cover)) {
				if ($track->hasMedia('cover')) {
					$track->getMedia('cover')->each->delete();
				}

				$image = $track->addMedia($cover)
					->usingName(str_limit("{$track->full_title}-cover", 90))
					->usingFileName(str_slug(str_limit($track->full_title, 90)) . "-cover.{$cover->extension()}")
					->toMediaLibrary('cover');

					if ($image) {
						$watermark_image = $this->cache->findOrMake('settings', 'watermark_logo')
												->getFirstMedia('image')
												->getPath();
												
						Image::load($image->getPath())
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

		$this->attachArtists($track, $input);

		// Set Track Slug 
		$this->setSlug($track);

		$track->save();

		if ($track->trackable->attachTrack($track->fresh())) {
			// Update File Tags
			$this->setFileTags($track->fresh());
		} 

		return $track;
	}

	public function setSlug(Track $track)
	{
		$slug = str_slug("{$track->fresh()->full_title}");
		if ($slug != $track->slug && $this->query()->similarSlug($slug)->exists()) {
            $count = 1;
            while ($this->query()->similarSlug(
            		$slug = str_slug("{$track->full_title}-{$count}"))->exists()) {
            	$count++;
            }
        }
        $track->update(['slug' => $slug]);
	}

	public function attachArtists(Track $track, array $data)
	{
		$artists = $data['main'];
		$features = $data['features'];
		// Create Artist Entity or Fetch One
		if (isset($artists) && !is_null($artists)) {
			$artists = explode(',', $artists);
			foreach ($artists as $artist) {
				$artist = $this->artists->createArtistStub($artist);
				$track->artists()->attach($artist);
			}
		} else {
			$track->artists()->attach(Artist::UNKNOWN_ID);
		}

		// If Featured Artist isset, Create it or Fetch One
		if (isset($features) && !is_null($features)) {
			$features = explode(',', $features);
			foreach ($features as $feature) {
				$feature = $this->artists->createArtistStub($feature);
				if (($track->fresh()->artists)->contains($feature)) continue;
				$track->artists()->attach($feature, ['role' => 'feature']);
			}
		}
		// If Featured Artist isset, Create it or Fetch One
		if (isset($data['producer']) && !is_null($data['producer']) && !empty($data['producer'])) {
			$producer = $this->artists->createArtistStub($data['producer']);
			$track->artists()->attach($producer, ['role' => 'producer']);
		} else {
			$producer = $track->fresh()->artists->first(function ($artist) {
				return $artist->pivot->role == 'main';
			});
			$track->artists()->attach($producer, ['role' => 'producer']);
		}
	}

	public function updateTrackStub(Track $track, $input)
	{
		$title = title_case($input['title']);		

		$track->title = $title;
		$track->year = $input['year'];
		$track->number = $input['number'];
		if (isset($input['comment'])) {
			$track->comment = $input['comment'];
		} else {
			$track->comment = 'Downloaded Free From' .  config("app.website");
		}
		if (isset($input['copyright'])) {
			$track->copyright = $input['copyright'];
		}

		$track->save();

		return $track;
	}

	public function createTrackStub($tags)
	{
		$title = $tags['title'];

		if (!is_null($title) && isset($tags['duration'])) {

			$track = self::MODEL;
			$track = new $track;

			$track->title = $title;
			$track->year = $tags['year'];
			$track->number = $tags['number'];
			$track->comment = $tags['comment'];
			$track->bitrate = $tags['bitrate'];
			$track->duration = $tags['duration'];
			if (isset($tags['copyright'])) {
				$track->copyright = $tags['copyright'];
			}
			
			return $track;
		} else {
			return false;
		}
	}

    public function setFileTags(Track $track)
    {
    	$path = $track->path;
		$file = $path instanceof SplFileInfo ? $path : new SplFileInfo($path);
		$file = new UploadedFile($file->getRealPath(), true);
		$track->band = $track->trackable->artists_title_comma;
		$track->album = $track->trackable->title ?: "NambaNamba.COM Downloads";
		$track->genre = $track->trackable->genre->name;
		(new Tags($file))->setInfo($track);
    }

    public function delete(Track $track)
    {
    	$track->delete();
    }
}