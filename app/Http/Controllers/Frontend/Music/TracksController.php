<?php

namespace App\Http\Controllers\Frontend\Music;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Music\TrackRepository;
use App\Models\Music\Track\Track;
use App\Repositories\Backend\Music\CacheRepository;
use SEOMeta;
use OpenGraph;
use Twitter;

class TracksController extends Controller
{
    protected $tracks;
    protected $cache;

    public function __construct(TrackRepository $tracks, CacheRepository $cache)
    {
        $this->tracks = $tracks;
        $this->cache = $cache;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'All Tracks';

        $tracks = $this->tracks->query()
                ->whereNotNull('trackable_id')
                ->latest()
                ->paginate(20);

        $index = 0;
        foreach ($tracks as $track) {
            $track->index = $index;
            $index++;
        }

        if (request()->wantsJson()) {
            return $tracks;
        }

        $description = 'Stream and Download All South African and International MP3 Songs. Download and Stream All Songs Free at NambaNamba.COM';
        $url = route('frontend.music.tracks.index');

        // SEO Tags
        SEOMeta::setTitle($title)
                ->setDescription($description)
                ->setCanonical($url);

        OpenGraph::setDescription($description)
                    ->setTitle($title)
                    ->setUrl($url)
                    ->addProperty('type', 'music.albums');

        Twitter::setTitle($title)
                ->setSite('@NambaNamba_Downloads');

        return view('frontend.music.tracks.index', compact('title', 'tracks'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($category, $genre, $trackableType, $trackableSlug, $track)
    {

        $track = $this->cache->findOrMake('tracks', $track);
        // dd($track->getFirstMedia('file')->getUrl());

        $title = "Stream and Download {$track->full_title} " . strtoupper($track->file->extension);
        $url = route('frontend.music.tracks.show', [$track->trackable->category, 
            $track->trackable->genre, $track->trackable_type, $track->trackable, $track]);
        $album = $track->trackable->fuller_title ?: 
                        "{$track->trackable->category->name} {$track->trackable->genre->name} singles";
        $description = "{$track->artists_title_comma} comes to you with a track titled {$track->title} under {$album}
                         Download and Stream this joint here and don't forget to share on social medias with friends...";
        $cover = $track->cover ? $track->cover->getFullUrl() : '';

        // SEO Tags
        SEOMeta::setTitle($title)
                ->setDescription($track->description ?: $description)
                ->addMeta('music.album:published_time', $track->created_at->toW3CString(), 'property')
                ->addMeta('music.album:section', $track->trackable->category->name, 'property')
                ->addKeyword(["Free {$track->trackable->category->name} {$track->trackable->genre->name} songs downloads 
                            and streaming", "download or stream {$track->full_title}", "stream {$track->full_title} 
                            free at NambaNamba.COM"]);

        OpenGraph::setDescription($track->description)
                    ->setTitle($title)
                    ->setUrl($url)
                    ->addProperty('type', 'music.song')
                    ->addProperty('locale', 'en-za')
                    ->addImage($cover);

        OpenGraph::setType('music.song')
            ->setMusicSong([
                'duration' => $track->duration,
                'album' => $album,
                'musician' => $track->all_artists->pluck("name")
            ]);

        return view('frontend.music.tracks.show', compact('title', 'track'));
    }
}
