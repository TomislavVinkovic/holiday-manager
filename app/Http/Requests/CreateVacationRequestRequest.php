<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MaxDateDiff;

class CreateVacationRequestRequest extends FormRequest
{

    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'startDate' => ['required', 'date', new MaxDateDiff],
            'endDate' => ['required', 'date', 'after:startDate'],
            'description' => ['required', 'string']
        ];
    }
}
