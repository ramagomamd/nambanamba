<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Music\CategoryRepository;
use App\Repositories\Backend\Music\GenreRepository;
use App\Repositories\Backend\Music\AlbumRepository;
use App\Repositories\Backend\Music\SingleRepository;

/**
 * Class FrontendController.
 */
class FrontendController extends Controller
{
    protected $categories;
    protected $albums;
    protected $singles;
    protected $genres;

    public function __construct(CategoryRepository $categories, AlbumRepository $albums, SingleRepository $singles,
                                GenreRepository $genres)
    {
        $this->categories = $categories;
        $this->albums = $albums;
        $this->singles = $singles;
        $this->genres = $genres;
    }
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $title = "Home";

        $albums = $this->albums->query()
                    ->with('artists', 'category', 'genre', 'media', 'tracks')
                    ->has('tracks')
                    ->withCount('tracks')
                    ->latest()
                    ->take(5)
                    ->get();

        $singles = $this->singles->query()
                    ->has('track')
                    ->with('track')
                    ->latest()
                    ->take(5)
                    ->get();

        return view('frontend.index', compact('title', 'categories', 'albums', 'singles'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function macros()
    {
        return view('frontend.macros');
    }
}
