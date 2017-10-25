<?php

namespace App\Http\Controllers\Backend\Music;

use App\Http\Controllers\Controller;
use App\Models\Music\Single\Single;
use App\Repositories\Backend\Music\SingleRepository;
use App\Repositories\Backend\Music\CategoryRepository;
use App\Repositories\Backend\Music\GenreRepository;
use App\Http\Requests\Backend\Music\Single\ManageSingleRequest;
use App\Http\Requests\Backend\Music\Single\StoreSingleRequest;
use App\Http\Requests\Backend\Music\Single\UpdateSingleRequest;

class SinglesController extends Controller
{
    protected $singles;
    protected $categories;
    protected $genres;

    public function __construct(SingleRepository $singles, CategoryRepository $categories, GenreRepository $genres)
    {
        $this->singles = $singles;
        $this->categories = $categories;
        $this->genres = $genres;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManageSingleRequest $request)
    {
        $title = "Singles";
        $singles = $this->singles->query()
                    ->has('track')
                    ->with('track')
                    ->latest()->paginate();

        return view('backend.music.singles.index', 
                    compact('title', 'singles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSingleRequest $request)
    {
        $results = $this->singles->create(
            $request->only('file', 'category', 'genre', 'description'));

        return response($results['message'], $results['code']);
    }

    public function remoteUpload()
    {
        // dd("hey");
        $singles = $this->singles->uploadViaUrl(
            request()->only('remote-links', 'category', 'genre'));
        return back()->withFlashInfo("Finished Uploading Singles Via URL");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Single $single, ManageSingleRequest $request)
    {
        $categories = $this->categories->getAll();
        $genres = $this->genres->getAll();

        return view('backend.music.singles.edit', 
                    compact('single', 'categories', 'genres'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Single $single, UpdateSingleRequest $request)
    {
        $single = $this->singles->update($single, $request->only(
                                    'file', 'category', 'genre'));

        return redirect()->route('admin.music.singles.index')->withFlashSuccess(
                                        trans('alerts.backend.music.singles.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Single $single, ManageSingleRequest $request)
    {
        $results = $this->singles->delete($single);

        return redirect()->route('admin.music.singles.index')->with($results);
    }
}
