<?php

namespace App\Events\Backend\Music\Single;

use Illuminate\Queue\SerializesModels;

class SingleCreated
{
    use SerializesModels;

    public $single;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($single)
    {
        $this->single = $single;
    }
}
