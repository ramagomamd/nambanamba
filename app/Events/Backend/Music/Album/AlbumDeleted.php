<?php

namespace App\Events\Backend\Music\Album;

use Illuminate\Queue\SerializesModels;

class AlbumDeleted
{
    use SerializesModels;

    public $album;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($album)
    {
        $this->album = $album;
    }
}
