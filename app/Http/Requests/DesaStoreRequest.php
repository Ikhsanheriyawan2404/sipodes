<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DesaStoreRequest extends FormRequest
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
            'village_code' => 'required',
            'district_code' => 'required',
            'city_code' => 'required',
            'url' => 'required|max:255',
            'logo' => 'required|image|mimes:jpeg,jpg,png|max:1028',
        ];
    }
}
