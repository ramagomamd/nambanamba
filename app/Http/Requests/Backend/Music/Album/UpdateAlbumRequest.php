<?php

namespace App\Http\Requests\Backend\Music\Album;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return access()->hasRole(1);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|min:2|max:65',
            'artists' => 'required|string',
            'category' => 'required|string|max:65',
            'genre' => 'required|string|max:65',           
            'description' => 'nullable|string|min:3||max:500',
            'type' => 'required|string|in:album,mixtape,ep'
        ];;
    }
}
