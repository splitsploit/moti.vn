<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateSpecialTimeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'start' => [
                'required',
                'date_format:' . config('panel.time_format_second')
            ],
            'end'   => [
                'required',
                'after:start',
                'date_format:' . config('panel.time_format_second')
            ],
            'reward_percent' => [
                'integer',
                'required',
                'min:0',
                'max:500'
            ]
        ];
    }
}
