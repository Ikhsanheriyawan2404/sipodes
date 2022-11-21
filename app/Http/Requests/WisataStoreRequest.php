<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WisataStoreRequest extends FormRequest
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
            'name' => 'required|max:255|unique:wisata',
            'description' => 'required',
            'location' => 'required',
            'latitude' => 'required|numeric|between:-90,90',
            'longtitude' => 'required|numeric|between:-180,180',
            'price' => 'required|max:255',
            'thumbnail' => 'required|image|mimes:jpg,png,jpeg|max:2058',
        ];
    }
}
