<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true; //imam vec middleware koji se brine o ovome
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'name' => ['required', 'string'],
            'description' => ['string'],
            'lead' => ['required', 'integer'], //integer because it is an id,
            'logo' => ['required', 'mimes:jpg,jpeg,png,svg,bmp']
        ];
    }
}
