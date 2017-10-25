<?php

namespace App\Http\Requests\Backend\Music\Album;

use Illuminate\Foundation\Http\FormRequest;

class UploadTracksRequest extends FormRequest
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
            'file' => 'required|file',
            'album_id' => 'required|exists:albums,id',
        ];
    }
}
