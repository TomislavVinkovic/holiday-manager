<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Carbon;
use Cmixin\BusinessDay;

class NoWeekendsAndHolidays implements Rule
{
    
    public function __construct() {

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value) {
        Carbon::setHolidaysRegion('hr');
        $date = Carbon::parse($value);
        return !($date->isWeekend() || $date->isHoliday()); //validacija ce proci samo ako dan nije holiday
    }

    public function message() {
        return 'The given date cannot be weekend day or a holiday!';
    }
}
