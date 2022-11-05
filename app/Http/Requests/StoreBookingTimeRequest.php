<?php

namespace App\Http\Requests;

use Gate;
use App\BookingTime;
use App\Rules\BookingTimeAvailabilityRule;
use App\Rules\BookingTimeUserRule;
use App\Rules\DateTimeRule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreBookingTimeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('booking_time_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                new BookingTimeUserRule(),
                'integer'
            ],
            'start_time' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!BookingTime::isOpenBookingTime()) {
                        $fail('The booking time has not yet opened.');
                    }
                },
                new BookingTimeAvailabilityRule(),
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format')
            ],
            'end_time' => [
                'required',
                new DateTimeRule(),
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format')
            ]
        ];
    }
}
