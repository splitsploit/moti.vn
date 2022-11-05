<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class DateTimeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $startTime = Carbon::parse(request()->input('start_time'));

        $endTime = Carbon::parse($value);

        if ("00:00:00" == $endTime->format(config('panel.time_format_second'))) {

            return $startTime->lessThan($endTime);
        } else {

            return !$endTime->startOfDay()->diffInDays($startTime->startOfDay());
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a time after start time and within a day.';
    }
}
