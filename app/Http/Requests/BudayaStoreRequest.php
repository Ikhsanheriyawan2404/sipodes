<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BudayaStoreRequest extends FormRequest
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
            'name' => 'required|max:255|unique:budaya',
            'location' => 'required|max:255',
            'figure' => 'required|max:255',
            'thumbnail' => 'required|image|mimes:jpg,png,jpeg|max:2058',
            'contact'=>'required|max:255',
            'description' => 'required',
            'type_budaya' => 'required|max:255',
        ];
    }
}
