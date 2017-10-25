<?php

namespace App\Http\Controllers\Frontend\Music;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Music\GenreRepository;
use App\Repositories\Backend\Music\AlbumRepository;
use App\Repositories\Backend\Music\SingleRepository;
use App\Models\Music\Genre\Genre;
use App\Repositories\Backend\Music\CacheRepository;
use SEOMeta;
use OpenGraph;
use Twitter;

class GenresController extends Controller
{
    protected $genres;
    protected $albums;
    protected $singles;
    protected $cache;

    public function __construct(GenreRepository $genres, AlbumRepository $albums, 
                                SingleRepository $singles, CacheRepository $cache)
    {
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
    public function index()
    {
        $title = "All Genres";
        
        $genres = $this->cache->findOrMake("genres");

        $description = "All Genres At NambaNamba Downloads. View Each Genre Music Albums and Singles MP3 Downloads at their Pages";
        $url = route('frontend.music.genres.index');

        // SEO Tags
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::setCanonical($url);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($url);
        OpenGraph::addProperty('type', 'music.genres');

        Twitter::setTitle($title);
        Twitter::setSite('@NambaNamba_Downloads');

        return view('frontend.music.genres.index', compact('title', 'genres'));
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $genre)
    {
        $albums = $this->albums->query()
                ->with('artists', 'category', 'genre', 'media', 'tracks')
                ->has('tracks')
                ->byGenre($genre)
                ->withCount('tracks');

        $albums_count = $albums->count();
        $albums = $albums->latest()->take(5)->get();
        $moreAlbums = route('frontend.music.genres.albums', $genre);

        $singles = $this->singles->query()
                ->byGenre($genre)
                ->has('track')
                ->with('track');

        $singles_count = $singles->count();
        $singles = $singles->latest()->take(5)->get();
        $moreSingles = route('frontend.music.genres.singles', $genre);

        $title = "Stream and Download {$genre->name} Albums and Singles";
        $url = route('frontend.music.genres.show', $genre);

        // SEO Tags
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($genre->description);
        SEOMeta::addKeyword(["Free {$genre->name} songs downloads and streaming", "download or stream {$genre->name} mp3s here", "stream {$genre->name} full albums and singles from NambaNamba.COM"]);

        OpenGraph::setDescription($genre->description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($url);
        OpenGraph::addProperty('locale', 'en-za');

        return view('frontend.music.genres.show', compact(
                    'title', 'genre', 'albums',
                    'albums_count', 'moreAlbums', 'singles',
                    'singles_count', 'moreSingles'
        ));
    }

    public function albums(Genre $genre)
    {
        $title = "All {$genre->name} Albums";

        $albums = $this->albums->query()
                ->with('artists', 'category', 'genre', 'media', 'tracks')
                ->has('tracks')
                ->byGenre($genre)  
                ->withCount('tracks')
                ->latest()
                ->paginate(10); 

        $description = "Stream and Download All {$genre->name} MP3 Music Albums. Download Album Songs Individually or Download Full Zipped Album Free at NambaNamba.COM";
        $url = route('frontend.music.genres.albums', $genre);

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

        return  view('frontend.music.albums.index', compact('title', 'albums', 'genre'));
    }

    public function singles(Genre $genre)
    {
        $title = "All {$genre->name} Singles";

        $singles = $this->singles->query()
                    ->byGenre($genre) 
                    ->has('track')
                    ->with('track')
                    ->latest()->paginate(10);

        $description = "Stream and Download All {$genre->name} MP3 Music Singles. Download Single Songs Free at NambaNamba.COM";
        $url = route('frontend.music.genres.singles', $genre);

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

        return  view('frontend.music.singles.index', compact('title', 'singles', 'genre'));
    }
}
