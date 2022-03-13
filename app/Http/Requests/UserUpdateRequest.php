<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserUpdateRequest extends FormRequest
{

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
            'email' => ['required', 'unique:users,email,'.$this->id],
            'username' => ['required', 'unique:users,username,'.$this->id],
            'oib' => ['required', 'size:11'],
            'first_name' => ['required', 'min:1', 'max:100'],
            'last_name' => ['required', 'min:1', 'max:100'],
            'residence' => ['required', 'min:1', 'max:100'],
            'date_of_birth' => ['required', 'date']
        ];
    }
}
