<?php

namespace App\Http\Controllers\Backend\Music;

use App\Http\Controllers\Controller;
use App\Models\Music\Artist\Artist;
use App\Repositories\Backend\Music\ArtistRepository;
use App\Repositories\Backend\Music\TrackRepository;
use App\Http\Requests\Backend\Music\Artist\ManageArtistRequest;
use App\Http\Requests\Backend\Music\Artist\StoreArtistRequest;
use App\Http\Requests\Backend\Music\Artist\UpdateArtistRequest;
use Illuminate\Validation\Rule;

class ArtistsController extends Controller
{
    protected $artists;
    protected $tracks;

    public function __construct(ArtistRepository $artists, TrackRepository $tracks)
    {
        $this->artists = $artists;
        $this->tracks = $tracks;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageArtistRequest $request)
    {
        $title = trans('labels.backend.music.artists.all');
        $artists = $this->artists->query()->orderBy('name');

        if (request()->wantsJson()) {
            return $artists->pluck('name', 'name');
        }

        $artists = $artists->paginate();

        return view('backend.music.artists.index', compact('title', 'artists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArtistRequest $request)
    {
        $artist = $this->artists->create($request->only('name', 'bio', 'image'));

        return redirect()->route('admin.music.artists.show', compact('artist'))
                ->withFlashSuccess(trans('alerts.backend.music.artists.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist, ManageArtistRequest $request)
    {  
        $title = $artist->name;

        $albums = $artist->albums()
                ->withCount('tracks')
                ->with('artists', 'category', 'genre');
        $albums_count = $albums->count();
        $albums = $albums->latest()->take(5)->get();

        $singles = $artist->singles()
					->with('track');
        $singles_count = $singles->count();
        $singles = $singles->take(5)->get();

        $tracks = $this->tracks->query()
                ->byArtist($artist)
                ->whereNotNull('trackable_id');
        $tracks_count = $tracks->count();
        $tracks = $tracks->take(5)->get();

        return view('backend.music.artists.show', 
                compact('title', 'artist', 'albums', 'singles', 'tracks', 'albums_count', 'singles_count', 'tracks_count'));
    }

    public function albums(Artist $artist, ManageArtistRequest $request)
    {
        $title = 'All ' . $artist->name . ' Albums';
        $albums = $artist->albums()
                    ->withCount('tracks')
                    ->with('artists', 'category', 'genre')
                    ->latest()
                    ->paginate(); 

        return  view('backend.music.albums.index', compact('title', 'albums'));
    }

    public function singles(Artist $artist, ManageArtistRequest $request)
    {
        $title = 'All ' . $artist->name . ' Singles';
        $singles = $artist->singles()
                    ->latest()
                    ->paginate();

        return  view('backend.music.singles.index', compact('title', 'singles'));
    }

    public function tracks(Artist $artist, ManageArtistRequest $request)
    {
        $title = "{$artist->name} Contributed Tracks";
        $tracks = $this->tracks->query()
                ->byArtist($artist)
                ->whereNotNull('trackable_id')
                ->latest()
                ->paginate();

        return  view('backend.music.tracks.index', compact('title', 'tracks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Artist $artist, UpdateArtistRequest $request)
    {
        $this->validate($request, [
            'name' => ['required', Rule::unique('artists')->ignore($artist->id), 'string', 'max:85']
        ]);
        $artist = $this->artists->update($artist, $request->only('name', 'bio', 'image'));

        return redirect()->route('admin.music.artists.show', $artist)
                ->withFlashSuccess(trans('alerts.backend.music.artists.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Artist $artist, ManageArtistRequest $request)
    {
        $this->artists->delete($artist);

        return redirect()->route('admin.music.artists.index')
                ->withFlashSuccess(trans('alerts.backend.music.artists.deleted'));
    }
}
