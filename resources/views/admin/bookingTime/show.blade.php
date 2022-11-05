@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.bookingTime.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.bookingTime.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>
                                {{ trans('cruds.bookingTime.fields.id') }}
                            </th>
                            <td>
                                {{ $bookingTime->id }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.bookingTime.fields.user') }}
                            </th>
                            <td>
                                {{ $bookingTime->user->name ?? '' }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.bookingTime.fields.start_time') }}
                            </th>
                            <td>
                                {{ $bookingTime->start_time }}
                            </td>
                        </tr>
                        <tr>
                            <th>
                                {{ trans('cruds.bookingTime.fields.end_time') }}
                            </th>
                            <td>
                                {{ $bookingTime->end_time }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.bookingTime.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                    @if ($bookingTime->permission('booking_time_edit') && $bookingTime->expiration())
                        <a class="btn btn-info" href="{{ route('admin.bookingTime.edit', $bookingTime->id) }}">
                            {{ trans('global.edit') }}
                        </a>
                    @endif
                    @if ($bookingTime->permission('booking_time_delete') && $bookingTime->expiration())
                        <form action="{{ route('admin.bookingTime.destroy', $bookingTime->id) }}" method="POST"
                            onsubmit="return confirm('{{ trans('global.areYouSure') }}'); " style="display: inline-block;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-danger" value="{{ trans('global.delete') }}">
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>



@endsection
