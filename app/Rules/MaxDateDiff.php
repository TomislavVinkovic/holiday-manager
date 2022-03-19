<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MaxDateDiff implements Rule, DataAwareRule
{
    
    public function setData($data) {
        $this->data = $data;
        return $this;
    }

    public function __construct() {
        
    }

    public function passes($attribute, $value)
    {
        $start_date = Carbon::parse($this->data['startDate']);
        $end_date = Carbon::parse($this->data['endDate']);
        $maxDifference = Auth::user()->available_vacation_days;

        $diff = $start_date->diffInDaysFiltered(function (Carbon $date) {
            return !$date->isWeekend(); //oduzmi mu dane odmora ne brojeci vikende
        }, $end_date);

        if($diff > $maxDifference) {
            return false;
        }
        return true;
    }

    public function message() {
        return "You do not have enough available vacation days!";
    }
}
