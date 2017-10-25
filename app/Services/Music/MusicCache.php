<?php

namespace App\Services\Music;

use App\Models\Music\Album\Album;
use App\Models\Music\Artist\Artist;
use App\Models\Music\Category\Category;
use App\Models\Music\Genre\Genre;
use App\Models\Music\Single\Single;
use App\Models\Music\Track\Track;
use Cache;

class MusicCache
{
    protected $keyName = 'music_cache';

    public function get()
    {
        if (!config('music.cache')) {
            return $this->query();
        }

        $data = Cache::get($this->keyName);
        if (!$data) {
            $data = $this->query();
            Cache::forever($this->keyName, $data);
        }

        return $data;
    }

    /**
     * Query fresh data from the database.
     *
     * @return array
     */
    private function query()
    {
        return [
            'album' => Album::with('artist', 'tracks', 'categories', 'genres')
                    ->latest()->paginate(2),
            'singles' => Single::with('tracks.artists', 'categories', 'genres')->latest()->paginate(10),
            'artists' => Artist::orderBy('name')->paginate(10),
            'tracks' => Track::with('artists', 'trackable')
                    ->latest()->paginate(10),
            'genres' => Genre::orderBy('name')->paginate(10),
            'categories' => Category::orderBy('name')->paginate(10),

        ];
    }

    public function clear()
    {
        Cache::forget($this->keyName);
    }
}