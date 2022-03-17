<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TeamUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'lead' => ['required', 'integer'],
            'members' => ['array'],
            'logo' => ['nullable', 'mimes:jpg,jpeg,png,svg,bmp']
        ];
    }
}
