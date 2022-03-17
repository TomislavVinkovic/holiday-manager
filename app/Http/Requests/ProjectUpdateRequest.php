<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProjectUpdateRequest extends FormRequest
{
    
    public function authorize() {
        return true;
    }

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
