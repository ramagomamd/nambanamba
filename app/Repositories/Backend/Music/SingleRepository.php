<?php 

namespace App\Repositories\Backend\Music;

use App\Repositories\BaseRepository;
use App\Models\Music\Single\Single;
use App\Events\Backend\Music\Single\SingleCreated;
use App\Events\Backend\Music\Single\SingleUpdated;
use App\Events\Backend\Music\Single\SingleDeleted;
use App\Exceptions\GeneralException;
use App\Services\Music\Tags;
use Spatie\Image\Image;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Spatie\Image\Manipulations;
use Illuminate\Support\Facades\DB;
use App\Repositories\Backend\Music\CacheRepository;

class SingleRepository extends BaseRepository
{
	const MODEL = Single::class;

	protected $categories;
	protected $genres;
	protected $tracks;
	protected $cache;

	public function __construct(GenreRepository $genres, TrackRepository $tracks, CacheRepository $cache,
								CategoryRepository $categories)
	{
		$this->categories = $categories;
		$this->genres = $genres;
		$this->tracks = $tracks;
		$this->cache = $cache;
	}

	public function create(array $input)
	{	
		$file = $input['file'];
		// Fetch files ID3 Tags
		if (!$tags = (new Tags($file))->getInfo()) {
			return [
				'message' => 'Failed to read file ID3 Tags',
				'code' => 508
			];
		}

		$single = self::MODEL;
		$single = new $single;
		
		// Attach Category
		$this->attachCategoryAndGenre($single, $input);

		$single->save();

		if ($single && $file->isValid()) {
			$track = $this->tracks->create($file, $single);

			if (!$track) {
				$single->delete();
				return [
					'message' => 'Failed to save track to database',
					'code' => 508
				];
			}
		}
		
		return [
			'message' => 'Successfully Uploaded File to server',
			'code' => 201
		];
	}

	public function attachCategoryAndGenre(Single $single, array $data)
	{
		// dd($data);
		// Attach Category
		if (!empty($data['category'])) {
			// Sync Main Category
			$category = $this->categories->createCategoryStub($data['category']);
			$single->category()->associate($category);
		} else {
			$single->delete();
			throw new GeneralException('Failed to create category for the single');
		}

		// Create and Attach Genres
		if (isset($data['genre']) && !is_null($data['genre'])) {
			$genre = $this->genres->createGenreStub($data['genre']);
			$single->genre()->associate($genre);
		} else {
			$single->delete();
			throw new GeneralException('Failed to create genre for the single');
		}

		return $single;
	}

	public function crawl(array $data)
	{
		// dd($data);
		// dd($data->cover);
		$single = self::MODEL;
		$single = new $single;
		
		/*$input['category'] = $data->category;
		$input['genre'] = $data->genre;*/
		// Attach Category
		$this->attachCategoryAndGenre($single, $data);

		if ($single->save()) {
			$this->uploadCover($single, $data['cover']);
		}

		$url = $data['link'];
		// $name = substr($url, strrpos($url, '/') + 1);
		$file = $single->addMediaFromUrl($url)
					->toMediaLibrary('file');
					// dd($file);
		$file = (new UploadedFile($file->getPath(), true));
		$track = $this->tracks->create($file, $single);

		if ($track) {
			DB::table('singles_crawler')->where('id', $data['crawlable_id'])
				->update(['crawled' => true]);
		} else {
			$single->delete();
		}
	}

	public function uploadViaUrl(array $data)
	{
		$links = collect(explode(',', $data['remote-links']));

		$links->each(function($link) use ($data) {
			$single = self::MODEL;
			$single = new $single;
			$this->attachCategoryAndGenre($single, $data)->save();

			try {
				$file = $single->addMediaFromUrl($link)
					->toMediaLibrary('file');
				// dd($file);
				$file = (new UploadedFile($file->getPath(), true));
				$track = $this->tracks->create($file, $single);
				return true;

			} catch (\Exception $e) {
				$single->delete();
				return false;
			}
		});
	}

	public function uploadCover(Single $single, $url)
	{
		if (isset($url)) {
			$cover = $single->addMediaFromUrl($url)
					->toMediaLibrary('cover');

			if ($cover) {
				$watermark_image = $this->cache->findOrMake('settings', 'watermark_logo')
												->getFirstMedia('image')
												->getPath();
												
				Image::load($cover->getPath())
					->watermark($watermark_image)
					->watermarkOpacity(50)
					->watermarkPosition(Manipulations::POSITION_TOP)      // Watermark at the top
					->watermarkHeight(50, Manipulations::UNIT_PERCENT)    // 50 percent height
					->watermarkWidth(100, Manipulations::UNIT_PERCENT)
					->width(310)
					->height(330)
					->optimize()
					->save();
			}

			return $cover ? true : false;
		}
		return false;
	}

	public function update(Single $single, array $input)
	{
		$single->description = $input['description'];

		$single->category()->dissociate();
		
		// Detach Genre
		$single->genre()->dissociate();
		$this->attachCategoryAndGenre($single, $data);
		$single->save();

		$file = $input['file'];
		if (isset($file) && $file->isValid()) {
			$track = $this->tracks->create($file, $single);
		}
		return $single;
	}

	public function delete(Single $single)
	{
		if ($single->track()->delete() && $single->delete()) {
			event(new SingleDeleted($single));

			$data = [
				'flash_success' => trans('alerts.backend.music.singles.deleted')
			];
		} else {
			$data = [
				'flash_success' => trans('exceptions.backend.music.singles.delete_error')
			];
		}
		return $data;
		
	}
}