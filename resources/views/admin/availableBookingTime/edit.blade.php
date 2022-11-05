@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.availableBookingTime.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.availableBookingTime.update", [$availableBookingTime->id]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="week_days">{{ trans('cruds.availableBookingTime.fields.week_days') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                              style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('week_days') ? 'is-invalid' : '' }}" name="week_days[]"
                            id="week_days" multiple required>
                        @foreach($weekDays as $id => $week_days)
                            <option
                                value="{{ $id }}" {{ (in_array($id, old('week_days', [])) || $availableBookingTime->week_days->contains($id)) ? 'selected' : '' }}>{{ $week_days }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('week_days'))
                        <div class="invalid-feedback">
                            {{ $errors->first('week_days') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.availableBookingTime.fields.week_days_helper') }}</span>
                </div>
                <div class="form-group {{ $errors->has('start') ? 'has-error' : '' }}">
                    <label class="required" for="start">{{ trans('cruds.availableBookingTime.fields.start') }}</label>
                    <input type="text" id="start" name="start" class="form-control available-booking-time-timepicker"
                           value="{{ old('start', isset($availableBookingTime) ? $availableBookingTime->start : '') }}"
                           required>
                    @if($errors->has('start'))
                        <em class="invalid-feedback">
                            {{ $errors->first('start') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.availableBookingTime.fields.start_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('end') ? 'has-error' : '' }}">
                    <label class="required" for="end">{{ trans('cruds.availableBookingTime.fields.end') }}</label>
                    <input type="text" id="end" name="end" class="form-control available-booking-time-timepicker"
                           value="{{ old('end', isset($availableBookingTime) ? $availableBookingTime->end : '') }}"
                           required>
                    @if($errors->has('end'))
                        <em class="invalid-feedback">
                            {{ $errors->first('end') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.availableBookingTime.fields.end_helper') }}
                    </p>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="maximum">{{ trans('cruds.availableBookingTime.fields.maximum') }}</label>
                    <input class="form-control {{ $errors->has('maximum') ? 'is-invalid' : '' }}" type="number"
                           name="maximum"
                           id="maximum"
                           value="{{ old('maximum', isset($availableBookingTime) ? $availableBookingTime->maximum : '') }}"
                           required>
                    @if($errors->has('maximum'))
                        <div class="invalid-feedback">
                            {{ $errors->first('maximum') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.availableBookingTime.fields.maximum_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="role_id">{{ trans('cruds.availableBookingTime.fields.role') }}</label>
                    <select class="form-control select2 {{ $errors->has('role') ? 'is-invalid' : '' }}" name="role_id"
                            id="role_id">
                        @foreach($roles as $id => $role)
                            <option
                                value="{{ $id }}" {{ ($availableBookingTime->role ? $availableBookingTime->role->id : old('role_id')) == $id ? 'selected' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('role'))
                        <div class="invalid-feedback">
                            {{ $errors->first('role') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.availableBookingTime.fields.role_helper') }}</span>
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
