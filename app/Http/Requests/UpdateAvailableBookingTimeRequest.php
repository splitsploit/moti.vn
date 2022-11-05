<?php

namespace App\Http\Requests;

use Gate;
use App\Rules\TimeRule;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateAvailableBookingTimeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'week_days.*' => [
                'integer',
                'min:1',
                'max:7'
            ],
            'week_days' => [
                'required',
                'array'
            ],
            'start' => [
                'required',
                'date_format:' . config('panel.time_format')
            ],
            'end'   => [
                'required',
                new TimeRule(),
                'date_format:' . config('panel.time_format')
            ],
            'maximum' => [
                'required',
                'integer'
            ]
        ];
    }
}
