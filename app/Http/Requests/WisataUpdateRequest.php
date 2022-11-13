<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WisataUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required',
            'location' => 'required|max:255',
            'longtitude' => 'required|max:10',
            'latitude' => 'required|max:10',
            'price' => 'required|max:255',
            'thumbnail' => 'image|mimes:jpg,png,jpeg|max:2058',
        ];
    }
}
