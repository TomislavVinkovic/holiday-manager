<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!Auth::user()->is_superuser) {
            return false;
        }
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
            'id' => ['required', 'integer'],
            'name' => ['required', 'string'],
            'description' => ['string'],
            'lead' => ['required', 'integer'], //integer because it is an id,
            'logo' => ['nullable', 'mimes:jpg,jpeg,png,svg,bmp']
        ];
    }
}