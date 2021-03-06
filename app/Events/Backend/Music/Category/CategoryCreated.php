<?php

namespace App\Events\Backend\Music\Category;

use Illuminate\Queue\SerializesModels;

class CategoryCreated
{
    use SerializesModels;

    public $category;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($category)
    {
        $this->category = $category;
    }
}
