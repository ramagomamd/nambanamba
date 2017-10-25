<?php

namespace App\Http\Requests\Backend\Music\Track;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackRequest extends FormRequest
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
            'title' => 'required|string|min:3',
            'comment' => 'nullable|min:3|string',
            'cover' => 'nullable|image',
            'main' => 'required|string',
            'features' => 'nullable|string',
            'producer' => 'nullable|string',
            'year' => 'nullable|date_format:Y',
            'number' => 'nullable|integer',
            'genres' => 'nullable|string',
            'copyright' => 'nullable|string|min:2|max:55',
        ];
    }
}
