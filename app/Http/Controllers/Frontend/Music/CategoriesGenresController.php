<?php

namespace App\Http\Controllers\Frontend\Music;

use App\Http\Controllers\Controller;
use App\Models\Music\Category\Category;
use App\Models\Music\Genre\Genre;
use App\Repositories\Backend\Music\AlbumRepository;
use App\Repositories\Backend\Music\SingleRepository;
use SEOMeta;
use OpenGraph;
use Twitter;

class CategoriesGenresController extends Controller
{
    protected $albums;
    protected $singles;

    public function __construct(AlbumRepository $albums, SingleRepository $singles)
    {
        $this->albums = $albums;
        $this->singles = $singles;
    }

    public function index(Category $category, Genre $genre)      
    {
        $albums = $this->albums->query()
                ->with('artists', 'category', 'genre', 'tracks')
                ->has('tracks')
                ->byCategoryAndGenre($category, $genre)
                ->withCount('tracks');

        $albums_count = $albums->count();
        $albums = $albums->latest()->take(5)->get();

        $singles = $this->singles->query()
                ->with('track')
                ->byCategoryAndGenre($category, $genre);

        $singles_count = $singles->count();
        $singles = $singles->latest()->take(5)->get();

        $title = "Stream and Download {$category->name} {$genre->name} Albums and Singles";
        $description = "Stream and Download All {$category->name} {$genre->name} MP3 Music Albums and Singles. Download Albums and Singles Songs Individually or Download Full Zipped Album Free at NambaNamba.COM";
        $url = route('frontend.music.categories.genres', [$category, $genre]);

        // SEO Tags
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addKeyword(["Free {$category->name} {$genre->name} songs downloads and streaming", "download or stream {$category->name} mp3s here", "stream {$category->name} {$genre->name} full albums and singles from NambaNamba.COM"]);

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($url);
        OpenGraph::addProperty('locale', 'en-za');

        return view('frontend.music.general', 
                        compact('title', 'category', 'genre', 'albums', 'singles', 'albums_count', 
                                'singles_count'));
    }

    public function getAlbums(Category $category, Genre $genre)
    {
        $title = "{$category->name} {$genre->name} Albums Downloads";

        $albums = $this->albums->query()
                    ->with('artists', 'category', 'genre', 'tracks')
                    ->has('tracks')
                    ->byCategoryAndGenre($category, $genre)
                    ->withCount('tracks')
                    ->latest()->paginate(10);

        $description = "Stream and Download All {$category->name} {$genre->name} MP3 Music Albums. Download Album Songs Individually or Download Full Zipped Album Free at NambaNamba.COM";
        $url = route('frontend.music.categories.genres.albums', [$category, $genre]);

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

        return  view('frontend.music.albums.index', compact('title', 'albums', 'category', 'genre'));
    }

    public function getSingles(Category $category, Genre $genre)
    {
        $title = "{$category->name} {$genre->name} Singles Downloads";

        $singles = $this->singles->query()
                    ->byCategoryAndGenre($category, $genre)
                    ->with('track')
                    ->latest()->paginate(10);

        $description = "Stream and Download All {$category->name} {$genre->name} MP3 Music Singles. Download Single Songs Free at NambaNamba.COM";
        $url = route('frontend.music.categories.genres.singles', [$category, $genre]);

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

        return view('frontend.music.singles.index', compact('title', 'singles', 'category', 'genre'));
    }
}
