<?php

namespace App\Http\Controllers\Backend\Music;

use App\Http\Controllers\Controller;
use App\Models\Music\Category\Category;
use App\Models\Music\Genre\Genre;
use App\Repositories\Backend\Music\AlbumRepository;
use App\Repositories\Backend\Music\SingleRepository;
use App\Http\Requests\Backend\Music\Category\ManageCategoryRequest;

class CategoriesGenresController extends Controller
{
    protected $albums;
    protected $singles;

    public function __construct(AlbumRepository $albums, SingleRepository $singles)
    {
        $this->albums = $albums;
        $this->singles = $singles;
    }

    public function index(Category $category, Genre $genre, ManageCategoryRequest $request)      
    {
        $title = "{$category->name} {$genre->name}";

        $albums = $this->albums->query()
                ->byCategoryAndGenre($category, $genre)        
                ->withCount('tracks')
                ->with('artists', 'category', 'genre');

        $albums_count = $albums->count();
        $albums = $albums->latest()->take(5)->get();
        $moreAlbums = route('admin.music.categories.genres.albums', [$category, $genre]);

        $singles = $this->singles->query()
                ->byCategoryAndGenre($category, $genre)
                ->with('track');

        $singles_count = $singles->count();
        $singles = $singles->latest()->take(5)->get();
        $moreSingles = route('admin.music.categories.genres.singles', [$category, $genre]);

        return view('backend.music.general', 
                        compact('title', 'category', 'genre', 'albums', 'singles', 'albums_count', 
                                'singles_count', 'moreAlbums', 'moreSingles'));
    }

    public function getAlbums(Category $category, Genre $genre, ManageCategoryRequest $request)
    {
        $title = "{$category->name} {$genre->name}";

        $albums = $this->albums->query()
                    ->byCategoryAndGenre($category, $genre)
                    ->withCount('tracks')
                    ->with('artists', 'category', 'genre')
                    ->latest()->paginate(10);

        return  view('backend.music.albums.index', compact('title', 'albums'));
    }

    public function getSingles(Category $category, Genre $genre, ManageCategoryRequest $request)
    {
        $title = "{$category->name} {$genre->name} Singles";

        $singles = $this->singles->query()
                    ->byCategoryAndGenre($category, $genre)
                    ->with('track')
                    ->latest()->paginate(10);

        return view('backend.music.singles.index', compact('title', 'singles'));
    }
}
