<?php

namespace App\Http\Controllers\Backend\Music;

use App\Http\Controllers\Controller;
use App\Models\Music\Category\Category;
use App\Models\Music\Genre\Genre;
use App\Repositories\Backend\Music\CategoryRepository;
use App\Repositories\Backend\Music\GenreRepository;
use App\Repositories\Backend\Music\AlbumRepository;
use App\Repositories\Backend\Music\SingleRepository;
use App\Http\Requests\Backend\Music\Category\ManageCategoryRequest;
use App\Http\Requests\Backend\Music\Category\StoreCategoryRequest;
use App\Http\Requests\Backend\Music\Category\UpdateCategoryRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Backend\Music\CacheRepository;

class CategoriesController extends Controller
{
    protected $categories;
    protected $genres;
    protected $albums;
    protected $singles;
    protected $cache;

    public function __construct(CategoryRepository $categories, GenreRepository $genres, CacheRepository $cache,
                                AlbumRepository $albums, SingleRepository $singles)
    {
        $this->categories = $categories;
        $this->genres = $genres;
        $this->albums = $albums;
        $this->singles = $singles;
        $this->cache = $cache;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageCategoryRequest $request)
    {
        $title = trans('labels.backend.music.categories.all');
        $categories = $this->categories->query()->orderBy('name');
        $genres = $this->genres->getAll();

        if (request()->wantsJson()) {
            return $categories->pluck('name', 'name');
        }

        $categories = $categories->paginate();

        return view('backend.music.categories.index', compact('title', 'categories', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->categories->create($request->only(
                                        'name', 'slug', 'description', 'genres'));

        return redirect()->route('admin.music.categories.show', $category)
                ->withFlashSuccess(trans('alerts.backend.music.categories.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, ManageCategoryRequest $request)
    {
        $title = $category->name;

        $category = $category->load('genres');
        $genres = $this->genres->getAll()->map(function ($genre) use ($category) {
            $albums = $this->albums->query()->byCategoryAndGenre($category, $genre);
            $singles = $this->singles->query()->byCategoryAndGenre($category, $genre);
            if ($albums->exists() || $singles->exists()) {
                return;
            }
            return $genre;
        })->reject(null);

        $albums = $this->albums->query()
                ->byCategory($category)
                ->withCount('tracks')
                ->with('artists', 'category', 'genre');

        $albums_count = $albums->count();
        $albums = $albums->latest()->take(5)->get();
        $moreAlbums = route('admin.music.categories.albums', $category);

        $singles = $this->singles->query()
                ->byCategory($category)
				->has('track')
                ->with('track');

        $singles_count = $singles->count();
        $singles = $singles->latest()->take(5)->get();
        $moreSingles = route('admin.music.categories.singles', $category);

        return view('backend.music.categories.show', compact(
                    'title', 'category', 'genres', 'albums',
                    'albums_count', 'moreAlbums', 'singles',
                    'singles_count', 'moreSingles'
        ));
    }

    public function albums(Category $category)
    {
        $title = "{$category->name} Category Albums";

        $albums = $this->albums->query()
                ->byCategory($category)  
                ->withCount('tracks')
                ->with('artists', 'category', 'genre')
                ->latest()->paginate(10); 

        return  view('backend.music.albums.index', compact('title', 'albums'));
    }

    public function singles(Category $category)
    {
        $title = "{$category->name} Category Singles";

        $singles = $this->singles->query()
                    ->byCategory($category) 
					->has('track')
                    ->with('track')
                    ->latest()->paginate(10);

        return  view('backend.music.singles.index', compact('title', 'singles'));
    }

    public function refreshCache(ManageCategoryRequest $request)
    {
        $this->cache->clear('categories');
        $album = $this->cache->findOrMake('categories');

        return back()->withFlashSuccess("All Categories Cache Successfully  Refreshed");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category, UpdateCategoryRequest $request)
    {
        $this->validate($request, [
            'name' => ['required', Rule::unique('categories')->ignore($category->id), 
                        'string', 'min:2', 'max:191']
        ]);

        $category = $this->categories->update($category, $request->only(
                                        'name', 'slug', 'description', 'genres') );

        return redirect()->route('admin.music.categories.show', $category)
                ->withFlashSuccess(trans('alerts.backend.music.categories.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, ManageCategoryRequest $request)
    {
        $this->categories->delete($category);

        return redirect()->route('admin.music.categories.index')->withFlashSuccess(trans('alerts.backend.music.categories.deleted'));
    }

    public function deleteGenre(Category $category, Genre $genre, ManageCategoryRequest $request)
    {
        $category->removeGenre($genre);

        return back()->withFlashSuccess('Genre successfully removed from category');
    }
}
