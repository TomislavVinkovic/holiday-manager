<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TeamUpdateRequest extends FormRequest
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
