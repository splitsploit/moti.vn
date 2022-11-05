@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.timesheets.title') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.timesheets.update', [$timesheet->id]) }}"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="user_id">{{ trans('cruds.timesheets.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id"
                        id="user_id" required>
                        @foreach ($users as $id => $user)
                            <option value="{{ $id }}"
                                {{ ($timesheet->user ? $timesheet->user->id : old('user_id')) == $id ? 'selected' : '' }}>
                                {{ $user }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('user'))
                        <div class="invalid-feedback">
                            {{ $errors->first('user') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.timesheets.fields.user_helper') }}</span>
                </div>
                <div class="form-group {{ $errors->has('start_time') ? 'has-error' : '' }}">
                    <label class="required" for="start_time">{{ trans('cruds.timesheets.fields.start_time') }}</label>
                    <input type="text" id="start_time" name="start_time" class="form-control timesheets-datetimepicker"
                        value="{{ old('start_time', isset($timesheet) ? $timesheet->start_time : '') }}" required>
                    @if ($errors->has('start_time'))
                        <em class="invalid-feedback">
                            {{ $errors->first('start_time') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.timesheets.fields.start_time_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('end_time') ? 'has-error' : '' }}">
                    <label class="required" for="end_time">{{ trans('cruds.timesheets.fields.end_time') }}</label>
                    <input type="text" id="end_time" name="end_time" class="form-control timesheets-datetimepicker"
                        value="{{ old('end_time', isset($timesheet) ? $timesheet->end_time : '') }}" required>
                    @if ($errors->has('end_time'))
                        <em class="invalid-feedback">
                            {{ $errors->first('end_time') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.timesheets.fields.end_time_helper') }}
                    </p>
                </div>
                <div class="form-group">
                    <button class="btn btn-danger" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection
