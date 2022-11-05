@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.specialTime.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.specialTime.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.specialTime.fields.id') }}
                        </th>
                        <td>
                            {{ $specialTime->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.specialTime.fields.date') }}
                        </th>
                        <td>
                            {{ $specialTime->date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.specialTime.fields.start') }}
                        </th>
                        <td>
                            {{ $specialTime->start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.specialTime.fields.end') }}
                        </th>
                        <td>
                            {{ $specialTime->end }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.specialTime.fields.reward_percent') }}
                        </th>
                        <td>
                            <b>{{ $specialTime->reward_percent }}%</b>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.specialTime.fields.role') }}
                        </th>
                        <td>
                            {{ $specialTime->role->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.specialTime.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
