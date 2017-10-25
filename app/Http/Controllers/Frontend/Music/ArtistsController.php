<?php

namespace App\Http\Controllers\Frontend\Music;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Music\ArtistRepository;
use App\Repositories\Backend\Music\TrackRepository;
use App\Models\Music\Artist\Artist;
use SEOMeta;
use OpenGraph;
use Twitter;

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
    public function index()
    {
        $title = "All Artists";
        $artists = $this->artists
                        ->query()
                        ->orderBy('name')
                        ->withCount(['albums', 'singles', 'tracks'])
                        ->paginate(20);

        $description = "All Artists At NambaNamba Downloads. View Each Artist Music Albums and Singles MP3 Downloads at their Pages";
        $url = route('frontend.music.artists.index');

        // SEO Tags
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($url);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($url);
        OpenGraph::addProperty('type', 'music.artists');

        Twitter::setTitle($title);
        Twitter::setSite('@NambaNamba_Downloads');

        return view('frontend.music.artists.index', compact('title', 'artists'));
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Artist $artist)
    {  
        $albums = $artist->albums()
                ->with('artists', 'category', 'genre', 'tracks')
                ->has('tracks')
                ->withCount('tracks');
        $albums_count = $albums->count();
        $albums = $albums->latest()->take(5)->get();

        $singles = $artist->singles()
                    ->has('track')
                    ->with('track');
        $singles_count = $singles->count();
        $singles = $singles->latest()->take(5)->get();

        $tracks = $artist->tracks()->whereNotNull('trackable_id');
        $tracks_count = $tracks->count();
        $tracks = $tracks->take(6)->get();
        $index = 0;
        foreach ($tracks as $track) {
            $track->index = $index;
            $index++;
        }

        $title = "Stream and Download {$artist->name} Albums and Singles";
        $url = route('frontend.music.artists.show', $artist);
        $cover = $artist->cover ? $artist->cover->getFullUrl() : '';

        // SEO Tags
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($artist->bio);
        SEOMeta::addMeta('music.album:published_time', $artist->created_at->toW3CString(), 'property');
        SEOMeta::addKeyword(["Free {$artist->name} songs downloads and streaming", "download or stream {$artist->name} mp3s here", "stream {$artist->name} full albums and singles from NambaNamba.COM"]);

        OpenGraph::setDescription($artist->description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($url);
        OpenGraph::addProperty('type', 'music.artist');
        OpenGraph::addProperty('locale', 'en-za');

        OpenGraph::addImage($cover);

        return view('frontend.music.artists.show', 
                compact('title', 'artist', 'albums', 'singles', 'tracks', 
                    'albums_count', 'singles_count', 'tracks_count'));
    }

    public function albums(Artist $artist)
    {
        $title = "All {$artist->name} Music Albums";
        $albums = $artist->albums()
                    ->with('artists', 'category', 'genre', 'tracks')
                    ->has('tracks')
                    ->withCount('tracks')
                    ->latest()
                    ->paginate(10); 


        $description = "Stream and Download All {$artist->name} MP3 Music Albums. Download Album Songs Individually or Download Full Zipped Album Free at NambaNamba.COM";
        $url = route('frontend.music.artists.albums', $artist);

        // SEO Tags
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($url);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($url);
        OpenGraph::addProperty('type', 'music.albums');

        Twitter::setTitle($title);
        Twitter::setSite('@NambaNamba_Downloads');

        return  view('frontend.music.albums.index', compact('title', 'albums', 'artist'));
    }

    public function singles(Artist $artist)
    {
        $title = "All {$artist->name} Music Singles";
        $singles = $artist->singles()
                    ->has('track')
                    ->with('track')
                    ->latest()
                    ->paginate(10);

        $description = "Stream and Download All {$artist->name} MP3 Music Singles. Download Single Songs Free at NambaNamba.COM";
        $url = route('frontend.music.artists.singles', $artist);

        // SEO Tags
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($url);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($url);
        OpenGraph::addProperty('type', 'music.songs');

        Twitter::setTitle($title);
        Twitter::setSite('@NambaNamba_Downloads');

        return  view('frontend.music.singles.index', compact('title', 'singles', 'artist'));
    }

    public function tracks(Artist $artist)
    {
        $title = "All {$artist->name} Tracks";
        $tracks = $tracks = $artist->tracks()
                ->whereNotNull('trackable_id')
                ->latest()
                ->paginate(20);
                dd($tracks);
        $index = 0;
        foreach ($tracks as $track) {
            $track->index = $index;
            $index++;
        }

        $description = "Stream and Download All {$artist->name} MP3 Songs. Download and Stream All Songs By {$artist->name } Free at NambaNamba.COM";
        $url = route('frontend.music.artists.tracks', $artist);

        // SEO Tags
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($url);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($url);
        OpenGraph::addProperty('type', 'music.songs');

        Twitter::setTitle($title);
        Twitter::setSite('@NambaNamba_Downloads');

        return  view('frontend.music.tracks.index', compact('title', 'tracks', 'artist'));
    }
}
