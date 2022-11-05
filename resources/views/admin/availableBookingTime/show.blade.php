@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.availableBookingTime.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.availableBookingTime.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.availableBookingTime.fields.id') }}
                        </th>
                        <td>
                            {{ $availableBookingTime->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.availableBookingTime.fields.week_days') }}
                        </th>
                        <td>
                            @foreach($availableBookingTime->week_days as $key => $item)
                                <span class="badge badge-info">{{ $weekDays[$item] ?? '' }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.availableBookingTime.fields.start') }}
                        </th>
                        <td>
                            {{ $availableBookingTime->start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.availableBookingTime.fields.end') }}
                        </th>
                        <td>
                            {{ $availableBookingTime->end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.availableBookingTime.fields.maximum') }}
                        </th>
                        <td>
                            <b>{{ $availableBookingTime->maximum }}</b>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.availableBookingTime.fields.role') }}
                        </th>
                        <td>
                            {{ $availableBookingTime->role->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.availableBookingTime.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
