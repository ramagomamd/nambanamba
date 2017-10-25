<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Music\CacheRepository;

/**
 * Class DashboardController.
 */
class DashboardController extends Controller
{
	protected $cache;
	
	public function __construct(CacheRepository $cache)
	{
		$this->cache = $cache;
	}
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('backend.dashboard');
    }

    public function refreshAllCache()
    {
    	$this->cache->refresh();

    	return back()->withFlashSuccess('Successfully refreshed All Cache');
    }
}
