<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DeleteTeamProjectRequest extends FormRequest
{

    //because of the simplicity of delete, this request is used for both teams and projects

    public function authorize() {
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
            'id' => ['required', 'integer']
        ];
    }
}
