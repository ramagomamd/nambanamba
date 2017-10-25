<?php

namespace App\Http\Controllers\Frontend\Music;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Music\SingleRepository;
use App\Models\Music\Single\Single;
use SEOMeta;
use OpenGraph;
use Twitter;

class SinglesController extends Controller
{
    protected $singles;

    public function __construct(SingleRepository $singles)
    {
        $this->singles = $singles;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "All Singles";

        $singles = $this->singles->query()
                ->has('track')
                ->with('track')
                ->latest()
                ->paginate(10);

        return view('frontend.music.singles.index', compact('title', 'singles'));
    }
}
