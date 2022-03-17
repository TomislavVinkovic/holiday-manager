<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TeamCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true; //imam vec middleware koji se brine o ovome
    }


    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'lead' => ['required', 'integer'],
            'members' => ['required', 'array'],
            'logo' => ['required', 'mimes:jpg,jpeg,png,svg,bmp'],
            'project' => ['nullable', 'integer']
        ];
    }
}
