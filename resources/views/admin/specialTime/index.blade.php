@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.specialTime.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.specialTime.title_singular') }}
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.specialTime.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.specialTime.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.specialTime.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.specialTime.fields.start') }}
                        </th>
                        <th>
                            {{ trans('cruds.specialTime.fields.end') }}
                        </th>
                        <th>
                            {{ trans('cruds.specialTime.fields.reward_percent') }}
                        </th>
                        <th>
                            {{ trans('cruds.specialTime.fields.role') }}
                        </th>
                        <th>

                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($specialTimeList as $key => $specialTime)
                        <tr data-entry-id="{{ $specialTime->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $specialTime->id ?? '' }}
                            </td>
                            <td>
                                {{ $specialTime->date ?? '' }}
                            </td>
                            <td>
                                {{ $specialTime->start ?? '' }}
                            </td>
                            <td>
                                {{ $specialTime->end ?? '' }}
                            </td>
                            <td>
                                {{ $specialTime->reward_percent ? $specialTime->reward_percent . '%' : '' }}
                            </td>
                            <td>
                                {{ $specialTime->role->title ?? '' }}
                            </td>
                            <td>
                                @can('user_management_access')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.specialTime.show', $specialTime->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('user_management_access')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.specialTime.edit', $specialTime->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('user_management_access')
                                    <form action="{{ route('admin.specialTime.destroy', $specialTime->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                          style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                               value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('user_management_access')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.specialTime.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({
                        selected: true, 
                        search: 'applied'
                    }).nodes(), function(entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[1, 'desc']],
                pageLength: 100,
            });
            $('.datatable:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
