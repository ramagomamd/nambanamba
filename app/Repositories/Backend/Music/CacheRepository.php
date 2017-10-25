<?php

namespace App\Repositories\Backend\Music;

use Illuminate\Support\Facades\Cache;
use App\Repositories\Backend\SettingRepository;
use App\Models\Music\Album\Album;
use App\Models\Music\Category\Category;
use App\Models\Music\Single\Single;
use App\Models\Music\Genre\Genre;
use App\Models\Music\Track\Track;
use App\Models\Setting\Setting;

class CacheRepository
{
    public function findOrMake($type, $slug = '')
    {
        switch ($type) {
            case 'albums':
                return $this->albums($slug);
                break;
            case 'settings':
                return $this->settings($slug);
                break;
            case 'tracks':
                return $this->tracks($slug);
                break;
            case 'categories':
                return $this->categories();
                break;
            case 'genres':
                return $this->genres();
                break;
            case 'all':
                return $this->all();
                break;
        }
    }

    private function albums($slug = '')
    {
        if (!empty($slug)) {
            return $this->cacheAlbum($slug);
        } else {
            Album::each(function ($album) {
                $this->cacheAlbum($album->slug);
            });
            return;
        }
    }

    private function cacheAlbum($slug)
    {
        $key = "albums/{$slug}";

        $album = $this->get($key);
        if (!is_null($album)) return $album;

        $album = Album::where('slug', $slug)->firstOrFail();
        $album = $album->load('tracks', 'category', 'genre');
        $index = 0;
        foreach ($album->tracks as $track) {
            $track->index = $index;
            $index++;
        }
        return $this->put($key, $album);
    }

    public function tracks($slug = '')
    {
        if (!empty($slug)) {
            return $this->cacheTrack($slug);
        } else {
            Track::each(function ($track) {
                $this->cacheTrack($track->slug);
            });
            return;
        }
    }

    public function cacheTrack($slug)
    {
        $key = "tracks/{$slug}";

        $track = $this->get($key);
        if (!is_null($track)) return $track;

        $track = Track::where('slug', $slug)->first();
        $track->index = 0;
        return $this->put($key, $track);
    }

    public function categories()
    {
        $key = "categories";

        $categories = $this->get($key);
        if (!is_null($categories)) return $categories;

        $categories = Category::with('genres')->get();
        return $this->put($key, $categories);
    }

    public function genres()
    {
        $key = "genres";

        $genres = $this->get($key);
        if (!is_null($genres)) return $genres;

        $genres = Genre::get()->map(function ($genre) {
                $albums = Album::byGenre($genre);
                $singles = Single::byGenre($genre);
                if ($albums->exists() || $singles->exists()) {
                    return $genre;
                }
                return null;
            })->reject(null);
        return $this->put($key, $genres);
    }

    public function settings($key = '')
    {
        if (!empty($key)) {
            return $this->cacheSetting($key);
        } else {
            Setting::each(function ($setting) {
                $this->cacheSetting($setting->key);
            });
            return;
        }
    }

    public function cacheSetting($key)
    {
        $setting = $this->get("settings/{$key}");
        if (!is_null($setting)) return $setting;

        $setting = Setting::where('key', $key)->first();
        return $this->put("settings/{$key}", $setting);
    }

    public function all()
    {
        $this->albums();
        $this->tracks();
        $this->categories();
        $this->genres();
        $this->settings();
    }

    public function refresh()
    {
        Cache::flush();
        $this->all();
    }

    private function put($key, $content)
    {
        Cache::forever($key, $content);
        return $this->get($key);
    }

    public function get($key)
    {
        return Cache::get($key);
    }

    public function clear($type, $key = null)
    {
        if (!is_null($key)) {
            Cache::forget("{$type}/{$key}");
        }
        Cache::forget($type);
    }
}