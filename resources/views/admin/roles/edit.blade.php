@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.role.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.roles.update', [$role->id]) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="title">{{ trans('cruds.role.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title"
                        id="title" value="{{ old('title', $role->title) }}" required>
                    @if ($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.role.fields.title_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="color">{{ trans('cruds.role.fields.color') }}</label>
                    <input class="form-control {{ $errors->has('color') ? 'is-invalid' : '' }}" type="color" name="color"
                        id="color" value="{{ old('color', $role->color) }}" required>
                    @if ($errors->has('color'))
                        <div class="invalid-feedback">
                            {{ $errors->first('color') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.role.fields.color_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="level">{{ trans('cruds.role.fields.level') }}</label>
                    <input class="form-control {{ $errors->has('level') ? 'is-invalid' : '' }}" type="number" name="level"
                        id="level" value="{{ old('level', $role->level) }}" required>
                    @if ($errors->has('level'))
                        <div class="invalid-feedback">
                            {{ $errors->first('level') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.role.fields.level_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="permissions">{{ trans('cruds.role.fields.permissions') }}</label>
                    <div style="padding-bottom: 4px">
                        <span class="btn btn-info btn-xs select-all"
                            style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                            style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('permissions') ? 'is-invalid' : '' }}"
                        name="permissions[]" id="permissions" multiple>
                        @foreach ($permissions as $id => $permissions)
                            <option value="{{ $id }}"
                                {{ in_array($id, old('permissions', [])) || $role->permissions->contains($id) ? 'selected' : '' }}>
                                {{ $permissions }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('permissions'))
                        <div class="invalid-feedback">
                            {{ $errors->first('permissions') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.role.fields.permissions_helper') }}</span>
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
