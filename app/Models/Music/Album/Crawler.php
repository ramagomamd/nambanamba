<?php

namespace App\Models\Music\Album;

use Illuminate\Database\Eloquent\Model;
use App\Models\Music\Track\Crawler as TrackCrawler;

class Crawler extends Model
{
    public function tracks()
    {
        return $this->morphMany(TrackCrawler::class, 'crawlable');
    }
}
