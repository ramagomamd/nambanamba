<?php

namespace App\Services;

use App\Models\Setting\Setting;
use Illuminate\Support\Facades\Cache;

class Settings
{

    public function get($key)
    {
        $setting = Setting::where('key', '=', $key)->first();
        return $setting;
    }
}