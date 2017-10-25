<?php

namespace App\Http\Requests\Backend\Music\Genre;

use Illuminate\Foundation\Http\FormRequest;

class StoreGenreRequest extends FormRequest
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
            'name' => 'required|unique:genres|string|max:85',
            'slug' => 'nullable|unique:genres|alpha_dash|max:85',
            'description' => 'nullable|min:3|string'
        ];
    }
}
