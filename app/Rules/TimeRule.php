<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class TimeRule implements Rule
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
        $start = Carbon::parse(request()->input('start'));

        $end = Carbon::parse($value);

        if ("00:00:00" == $end->format(config('panel.time_format_second'))) {

            $end->addDays(1);

        }
        
        return $start->lessThan($end);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a time after start.';
    }
}
