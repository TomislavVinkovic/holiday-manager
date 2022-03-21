<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\MaxDateDiff;
use App\Rules\NoWeekendsAndHolidays;

class CreateVacationRequestRequest extends FormRequest
{

    
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'startDate' => ['required', 'date', 'after:today',  new MaxDateDiff, new NoWeekendsAndHolidays],
            'endDate' => ['required', 'date', 'after:today' , 'after:startDate', new NoWeekendsAndHolidays],
            'description' => ['required', 'string']
        ];
    }
}
