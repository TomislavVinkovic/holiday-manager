<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;

class UserCreationRequest extends FormRequest
{
    public function authorize(){
        if(!Auth::user()->is_superuser) {
            return false;
        }
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'email', 'unique:users,email'],
            'username' => ['required', 'unique:users,username'],
            //za password nisam stavio uncompromised radi lakseg testiranja
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
            'oib' => ['required', 'size:11'],
            'first_name' => ['required', 'min:1', 'max:100'],
            'last_name' => ['required', 'min:1', 'max:100'],
            'residence' => ['required', 'min:1', 'max:100'],
            'date_of_birth' => ['required', 'date'],
            'roles' => ['required', 'array']
        ];
    }
}
