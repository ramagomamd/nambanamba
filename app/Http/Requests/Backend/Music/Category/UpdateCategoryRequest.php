<?php

namespace App\Http\Requests\Backend\Music\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
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
            'description' => 'min:3|string|nullable',
            'genres' => 'nullable|array',
            'genres.*' => 'nullable|string|min:2|max:60'
        ];
    }
}
