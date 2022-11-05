@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.specialTime.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.specialTime.update", [$specialTime->id]) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group {{ $errors->has('date') ? 'has-error' : '' }}">
                    <label for="date">{{ trans('cruds.specialTime.fields.date') }}</label>
                    <input type="text" id="date" name="date" class="form-control date"
                           value="{{ old('date', isset($specialTime) ? $specialTime->date : '') }}">
                    @if($errors->has('date'))
                        <em class="invalid-feedback">
                            {{ $errors->first('date') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.specialTime.fields.date_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('start') ? 'has-error' : '' }}">
                    <label class="required" for="start">{{ trans('cruds.specialTime.fields.start') }}</label>
                    <input type="text" id="start" name="start" class="form-control timepicker"
                           value="{{ old('start', isset($specialTime) ? $specialTime->start : '') }}"
                           required>
                    @if($errors->has('start'))
                        <em class="invalid-feedback">
                            {{ $errors->first('start') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.specialTime.fields.start_helper') }}
                    </p>
                </div>
                <div class="form-group {{ $errors->has('end') ? 'has-error' : '' }}">
                    <label class="required" for="end">{{ trans('cruds.specialTime.fields.end') }}</label>
                    <input type="text" id="end" name="end" class="form-control timepicker"
                           value="{{ old('end', isset($specialTime) ? $specialTime->end : '') }}"
                           required>
                    @if($errors->has('end'))
                        <em class="invalid-feedback">
                            {{ $errors->first('end') }}
                        </em>
                    @endif
                    <p class="helper-block">
                        {{ trans('cruds.specialTime.fields.end_helper') }}
                    </p>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="reward_percent">{{ trans('cruds.specialTime.fields.reward_percent') }}</label>
                    <input class="form-control {{ $errors->has('reward_percent') ? 'is-invalid' : '' }}" type="number" step="50"
                           name="reward_percent"
                           id="reward_percent"
                           value="{{ old('reward_percent', isset($specialTime) ? $specialTime->reward_percent : '') }}"
                           required>
                    @if($errors->has('reward_percent'))
                        <div class="invalid-feedback">
                            {{ $errors->first('reward_percent') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.specialTime.fields.reward_percent_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="role_id">{{ trans('cruds.specialTime.fields.role') }}</label>
                    <select class="form-control select2 {{ $errors->has('role') ? 'is-invalid' : '' }}" name="role_id"
                            id="role_id">
                        @foreach($roles as $id => $role)
                            <option
                                value="{{ $id }}" {{ ($specialTime->role ? $specialTime->role->id : old('role_id')) == $id ? 'selected' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('role'))
                        <div class="invalid-feedback">
                            {{ $errors->first('role') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.specialTime.fields.role_helper') }}</span>
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
