<?php

namespace App\Rules;

use App\BookingTime;
use Illuminate\Contracts\Validation\Rule;

class BookingTimeAvailabilityRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($bookingTime = null)
    {
        $this->bookingTime = $bookingTime;
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
        return BookingTime::checkCanBookingTime(request()->input('user_id'), $value, request()->input('end_time'), $this->bookingTime);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This time is not available.';
    }
}
