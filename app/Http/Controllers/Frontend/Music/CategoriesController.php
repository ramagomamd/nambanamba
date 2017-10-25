<?php

namespace App\Http\Controllers\Frontend\Music;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Music\CategoryRepository;
use App\Models\Music\Category\Category;
use App\Repositories\Backend\Music\AlbumRepository;
use App\Repositories\Backend\Music\SingleRepository;
use SEOMeta;
use OpenGraph;
use Twitter;

class CategoriesController extends Controller
{
    protected $categories;
    protected $albums;
    protected $singles;

    public function __construct(CategoryRepository $categories, AlbumRepository $albums, 
                                SingleRepository $singles)
    {
        $this->categories = $categories;
        $this->albums = $albums;
        $this->singles = $singles;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $category = $category->load('genres');

        $genres = $category->genres->map(function ($genre) use ($category) {
            $albums = $this->albums->query()->byCategoryAndGenre($category, $genre);
            $singles = $this->singles->query()->byCategoryAndGenre($category, $genre);
            if ($albums->exists() || $singles->exists()) {
                return $genre;
            }
            return null;
        })->reject(null);

        $albums = $this->albums->query()
                ->with('artists', 'category', 'genre', 'tracks')
                ->has('tracks')
                ->byCategory($category)
                ->withCount('tracks');

        $albums_count = $albums->count();
        $albums = $albums->latest()->take(5)->get();
        $moreAlbums = route('frontend.music.categories.albums', $category);

        $singles = $this->singles->query()
                ->byCategory($category)
                ->has('track')
                ->with('track');

        $singles_count = $singles->count();
        $singles = $singles->latest()->take(5)->get();
        $moreSingles = route('frontend.music.categories.singles', $category);

        $title = "Stream and Download {$category->name} Albums and Singles";
        $url = route('frontend.music.categories.show', $category);

        // SEO Tags
        SEOMeta::setTitle($title);
        SEOMeta::setDescription($category->description);
        SEOMeta::addKeyword(["Free {$category->name} songs downloads and streaming", "download or stream {$category->name} mp3s here", "stream {$category->name} full albums and singles from NambaNamba.COM"]);

        OpenGraph::setDescription($category->description);
        OpenGraph::setTitle($title);
        OpenGraph::setUrl($url);
        OpenGraph::addProperty('locale', 'en-za');

        return view('frontend.music.categories.show', compact(
                    'title', 'category', 'genres', 'albums',
                    'albums_count', 'moreAlbums', 'singles',
                    'singles_count', 'moreSingles'
        ));
    }

    public function albums(Category $category)
    {
        $title = "All {$category->name} Albums Downloads";

        $albums = $this->albums->query()
                ->with('artists', 'category', 'genre', 'tracks')
                ->has('tracks')
                ->byCategory($category)  
                ->withCount('tracks')
                ->latest()->paginate(10); 

        $description = "Stream and Download All {$category->name} MP3 Music Albums. Download Album Songs Individually or Download Full Zipped Album Free at NambaNamba.COM";
        $url = route('frontend.music.categories.albums', $category);

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

        return  view('frontend.music.albums.index', compact('title', 'albums', 'category'));
    }

    public function singles(Category $category)
    {
        $title = "All {$category->name} Singles Downloads";

        $singles = $this->singles->query()
                    ->byCategory($category) 
                    ->has('track')
                    ->with('track')
                    ->latest()->paginate(10);

       $description = "Stream and Download All {$category->name} MP3 Music Singles. Download Single Songs Free at NambaNamba.COM";
        $url = route('frontend.music.categories.singles', $category);

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

        return  view('frontend.music.singles.index', compact('title', 'singles', 'category'));
    }
}
