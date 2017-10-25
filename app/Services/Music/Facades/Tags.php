<?php

namespace App\Services\Music\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Music.
 */
class Tags extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tags';
    }
}
