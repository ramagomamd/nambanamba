<?php

namespace App\Services\Music\Facades;

use Illuminate\Support\Facades\Facade;

class Download extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'download';
    }
}
