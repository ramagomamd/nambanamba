<?php

namespace App\Http\Composers\Frontend;

use Illuminate\View\View;
use App\Repositories\Backend\Music\CacheRepository;

/**
 * Class SidebarComposer.
 */
class SidebarComposer
{
    protected $cache;

    /**
     * SidebarComposer constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(CacheRepository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param View $view
     *
     * @return bool|mixed
     */
    public function compose(View $view)
    {
        $categories = $this->cache->findOrMake('categories');
        $view->with('categories', $categories);
    }
}
