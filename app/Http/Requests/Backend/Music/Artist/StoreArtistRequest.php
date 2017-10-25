<?php

namespace App\Http\Requests\Backend\Music\Artist;

use Illuminate\Foundation\Http\FormRequest;

class StoreArtistRequest extends FormRequest
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
            'name' => 'required|unique:artists|string|max:85',
            'bio' => 'nullable|min:3|string',
            'image' => 'nullable|file|image',
        ];
    }
}
