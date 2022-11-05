<?php

namespace App\Rules;

use Gate;
use Illuminate\Contracts\Validation\Rule;

class BookingTimeUserRule implements Rule
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
        return (auth()->user()->id == $value || Gate::allows('booking_time_access'));
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This :attribute is not allowed.';
    }
}
