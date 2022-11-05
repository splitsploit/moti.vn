<?php

namespace App\Http\Requests;

use Gate;
use App\Configuration;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateTimesheetsRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('timesheets_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'user_id' => [
                'required',
                'integer'
            ],
            'start_time'   => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format_second')
            ],
            'end_time'     => [
                'required',
                'after:start_time',
                function ($attribute, $value, $fail) {
                    $limit_hours = (int)Configuration::get('limit_hours');
                    $start = Carbon::parse(request()->input('start_time'));
                    $end = Carbon::parse($value);
                    if ($end->gte($start->endOfDay()->addHours($limit_hours))) {
                        $fail('The start time and end time must be within a day.');
                    }
                    // if ($end->startOfDay()->diffInDays($start->startOfDay())) {
                    //     $fail('The start time and end time must be within a day.');
                    // }
                },
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format_second')
            ]
        ];
    }
}
