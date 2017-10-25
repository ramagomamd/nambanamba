<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Music\Album\Album;

class SearchController extends Controller
{
    /**
     * Search the products table.
     *
     * @param  Request $request
     * @return mixed
     */
    public function search()
    {
        // First we define the error message we are going to show if no keywords
        // existed or if no results found.
        $error = ['error' => 'No results found, please try with different keywords.'];

        // Making sure the user entered a keyword.
        if(request()->has('q')) {

            // Using the Laravel Scout syntax to search the products table.
            $posts = Album::search(request()->get('q'))->get();

            // If there are results return them, if none, return the error message.
            return $posts->count() ? $posts : $error;

        }

        // Return the error message if no keywords existed
        return $error;
    }
}
