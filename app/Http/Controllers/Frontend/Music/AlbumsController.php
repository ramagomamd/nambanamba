<?php

namespace App\Http\Controllers\Frontend\Music;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Music\AlbumRepository;
use App\Models\Music\Album\Album;
use App\Repositories\Backend\Music\CacheRepository;
use SEOMeta;
use OpenGraph;
use Twitter;

class AlbumsController extends Controller
{
    protected $albums;

    public function __construct(AlbumRepository $albums, CacheRepository $cache)
    {
        $this->albums = $albums;
        $this->cache = $cache;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Albums Index
        $title = 'All South African and International MP3 Albums Downloads';

        $albums = $this->albums->query()
                ->with('artists', 'category', 'genre', 'tracks')
                ->has('tracks')
                ->withCount('tracks')
                ->latest()
                ->paginate(10);
                
        $description = 'Stream and Download Full South African and International MP3 Music Albums. Download Album Songs Individually or Download a Full Zipped Album Free at NambaNamba.COM';
        $url = route('frontend.music.albums.index');

        // SEO Tags
        SEOMeta::setTitle($title)
                ->setDescription($description)
                ->setCanonical($url)
                ->addKeyword(['south african hip hop mp3 albums downloads', 'mzansi hip hop zip albums download', 'south african house music downloads', 'international hip hop mp3 albums downloads']);

        OpenGraph::setDescription($description)
                    ->setTitle($title)
                    ->setUrl($url)
                    ->addProperty('type', 'music.albums');

        Twitter::setTitle($title)
                ->setSite('@NambaNamba_Downloads');

        return view('frontend.music.albums.index', compact('title', 'albums'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category, $genre, $album)
    {
        /*$album = Cache::rememberForever("albums/{$album}", function () use ($album) {
            $album = Album::where('slug', $album)->firstOrFail();
            $album = $album->load('tracks', 'category', 'genre');
            $index = 0;
            foreach ($album->tracks as $track) {
                $track->index = $index;
                $index++;
            }
            return $album;
        });*/
        $album = $this->cache->findOrMake('albums', $album);

        if ($album->tracks->isEmpty()) {
            return redirect()->route('frontend.index')->withFlashDanger("Album does not exist or has no tracks yet");
        }

        // dd($album->getFirstMedia('file'));

        $title = "Stream and Download {$album->full_title}";
        $url = route('frontend.music.albums.show', [$album->category, $album->genre, $album]);
        $description = "{$album->artists_title_comma} comes to you with the album titled {$album->title} under 
                        {$album->category->name} {$album->genre->name} 
                         Download and Stream this joint here and don't forget to share on social medias with friends...";
        $cover = $album->cover ? $album->cover->getFullUrl() : '';

        // SEO Tags
        SEOMeta::setTitle($title)
                ->setDescription($album->description ?: $description)
                ->addMeta('music.album:published_time', $album->created_at->toW3CString(), 'property')
                ->addMeta('music.album:section', $album->category->name, 'property')
                ->addKeyword(["Free {$album->category->name} {$album->genre->name} albums downloads", "download {$album->full_title} zipped", "stream all songs from {$album->full_title} free"]);

        OpenGraph::setDescription($album->description)
                    ->setTitle($title)
                    ->setUrl($url)
                    ->addProperty('type', 'music.album')
                    ->addProperty('locale', 'en-za')
                    ->addImage($cover);

        OpenGraph::setType('music.album')
            ->setMusicAlbum([
                'song:track' => $album->tracks->count(),
                'musician' => $album->artists_title_comma,
                'release_date' => $album->release_date
            ]);

        return view('frontend.music.albums.show', compact('title', 'album'));
    }
}
