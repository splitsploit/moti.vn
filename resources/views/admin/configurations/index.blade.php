@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.list') }} {{ trans('cruds.configurations.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                {{ trans('cruds.configurations.fields.key') }}
                            </th>
                            <th>
                                {{ trans('cruds.configurations.fields.default') }}
                            </th>
                            <th>
                                {{ trans('cruds.configurations.fields.value') }}
                            </th>
                            <th>
                                {{ trans('cruds.configurations.fields.description') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($configurations as $key => $configuration)
                            <form method="POST" action="{{ route('admin.configurations.update', [$configuration->id]) }}"  enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                <input type="hidden" name="id" value="{{ $configuration->id }}">
                                <tr>
                                    <td>
                                        <b>{{ $configuration->key }}</b>
                                        <input type="hidden" name="key" value="{{ $configuration->key }}">
                                    </td>
                                    <td>
                                        {{ $configuration->default }}
                                    </td>
                                    <td>
                                        <input class="form-control" type="text" name="value"
                                            value="{{ old('value', $configuration->value) }}" maxlength="255">
                                    </td>
                                    <td>
                                        <input class="form-control" type="description" name="description"
                                            value="{{ old('description', $configuration->description) }}" maxlength="255">
                                    </td>
                                    <td class="center">
                                        <button class="btn btn-danger" type="submit">
                                            {{ trans('global.save') }}
                                        </button>
                                    </td>
                                </tr>
                            </form>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
