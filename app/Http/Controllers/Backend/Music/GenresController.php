<?php

namespace App\Http\Controllers\Backend\Music;

use App\Http\Controllers\Controller;
use App\Models\Music\Genre\Genre;
use App\Models\Music\Category\Category;
use App\Repositories\Backend\Music\GenreRepository;
use App\Repositories\Backend\Music\TrackRepository;
use App\Repositories\Backend\Music\AlbumRepository;
use App\Repositories\Backend\Music\SingleRepository;
use App\Http\Requests\Backend\Music\Genre\ManageGenreRequest;
use App\Http\Requests\Backend\Music\Genre\StoreGenreRequest;
use App\Http\Requests\Backend\Music\Genre\UpdateGenreRequest;
use Illuminate\Validation\Rule;
use App\Repositories\Backend\Music\CacheRepository;

class GenresController extends Controller
{
    protected $genres;
    protected $tracks;
    protected $cache;

    public function __construct(GenreRepository $genres, TrackRepository $tracks, AlbumRepository $albums, 
                                SingleRepository $singles, CacheRepository $cache)
    {
        $this->genres = $genres;
        $this->tracks = $tracks;
        $this->albums = $albums;
        $this->singles = $singles;
        $this->cache = $cache;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageGenreRequest $request)
    {
        $title = trans('labels.backend.music.genres.all');
        $genres = $this->genres->query()->orderBy('name');

        if (request()->wantsJson()) {
            return $genres->pluck('name', 'name');
        }

        $genres = $genres->paginate();

        return view('backend.music.genres.index', compact('title', 'genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGenreRequest $request)
    {
        $genre = $this->genres->create($request->only('name', 'slug', 'description'));

        return redirect()->route('admin.music.genres.show', compact('genre'))
                ->withFlashSuccess(trans('alerts.backend.music.genres.created'));
    }

    public function show(Genre $genre, ManageGenreRequest $request)
    {
        // dd($genre);
        $title = $genre->name;

        $albums = $this->albums->query()
                    ->byGenre($genre)
                    ->withCount('tracks')
                    ->with('artists', 'category', 'genre');

        $albums_count = $albums->count();
        $albums = $albums->latest()->take(5)->get();
        $moreAlbums = route('admin.music.genres.albums', $genre);

        $singles = $this->singles->query()
                    ->byGenre($genre) 
                    ->with('track');

        $singles_count = $singles->count();
        $singles = $singles->latest()->take(5)->get();
        $moreSingles = route('admin.music.genres.singles', $genre);

        return view('backend.music.genres.show', 
                compact('title', 'genre', 'albums', 'singles', 'albums_count', 'singles_count',
                        'moreAlbums', 'moreSingles'));
    }

    public function albums(Genre $genre, ManageGenreRequest $request)
    {
        $title = "{$genre->name} Genre Albums";

        $albums = $this->albums->query()
                    ->byGenre($genre)
                    ->withCount('tracks')
                    ->with('artists', 'category', 'genre')
                    ->latest()->paginate(10); 

        return  view('backend.music.albums.index', compact('title', 'albums'));
    }

    public function singles(Genre $genre, ManageGenreRequest $request)
    {
        $title = "{$genre->name} Genre Singles";

        $singles = $this->singles->query()
                    ->byGenre($genre)   
                    ->with('track')
                    ->latest()->paginate(10);

        return  view('backend.music.singles.index', compact('title', 'singles'));
    }

    public function refreshCache(ManageGenreRequest $request)
    {
        $this->cache->clear('genres');
        $album = $this->cache->findOrMake('genres');

        return back()->withFlashSuccess("All Genre Cache Successfully  Refreshed");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Genre $genre, UpdateGenreRequest $request)
    {
        $this->validate($request, [
            'name' => ['required', Rule::unique('genres')->ignore($genre->id), 'string', 'max:85'],
            'slug' => ['nullable', Rule::unique('genres')->ignore($genre->id), 'alpha_dash', 'max:85'],
        ]);
        $genre = $this->genres->update($genre, $request->only('name', 'slug', 'description'));

        return redirect()->route('admin.music.genres.show', $genre)->withFlashSuccess(trans('alerts.backend.music.genres.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre, ManageGenreRequest $request)
    {
        $this->genres->delete($genre);

        return redirect()->route('admin.music.genres.index')->withFlashSuccess(trans('alerts.backend.music.genres.deleted'));
    }
}
