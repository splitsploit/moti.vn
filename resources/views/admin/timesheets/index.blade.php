@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-md-6">
            <a class="btn btn-success" href="{{ $isNotCheckOut ? route("admin.timesheets.checkOut") : route("admin.timesheets.checkIn") }}">
                {{ $isNotCheckOut ? trans('cruds.timesheets.check_out') : trans('cruds.timesheets.check_in') }}
            </a>
        </div>
        <div class="col-md-6">
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="date_filter" id="date_filter" />
                    </div>
                    <div class="col-md-8">
                        <input type="submit" name="filter_submit" class="btn btn-success" value="Filter" />
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-12">
            <div class="form-check checkbox">
                <input class="form-check-input" name="as-checkin" type="checkbox" id="as-checkin" style="vertical-align: middle;" />
                <label class="form-check-label" for="as-checkin" style="vertical-align: middle;">
                    I am working for CONVERT.
                </label>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.timesheets.title') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Timesheets">
                    <thead>
                    <tr>
                        <th>

                        </th>
                        <th>
                            {{ trans('cruds.timesheets.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.timesheets.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.timesheets.fields.start_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.timesheets.fields.end_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.timesheets.fields.hours') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($timesheets as $key => $timesheet)
                        <tr data-entry-id="{{ $timesheet->id }}" class="{{$timesheet->hours == '00:00:00' ? 'warning-check-out' : ''}}">
                            <td width="10">

                            </td>
                            <td>
                                {{ $timesheet->id ?? '' }}
                            </td>
                            <td>
                                {{ $timesheet->date ?? '' }}
                            </td>
                            <td>
                                {{ $timesheet->user->email ?? '' }}
                            </td>
                            <td>
                                {{ $timesheet->start_time ?? '' }}
                            </td>
                            <td>
                                {{ $timesheet->end_time ?? '' }}
                            </td>
                            <td>
                                {{ $timesheet->hours ?? '' }}
                            </td>
                            <td>

                                @can('timesheets_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.timesheets.edit', $timesheet->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('timesheets_delete')
                                    <form action="{{ route('admin.timesheets.destroy', $timesheet->id) }}" method="POST"
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
        $('#as-checkin').change((e) => {
            const checkIn = $('a[href*="admin/timesheets/checkIn"]');
            const href = checkIn.attr('href');
            const url = new URL(href);
            if (e.target.checked) {
                url.searchParams.set('work', 'AS');
            } else {
                url.searchParams.delete('work');
            }
            checkIn.attr('href', url);
        })
    </script>
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('timesheets_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.timesheets.massDestroy') }}",
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
            $('.datatable-Timesheets:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(function() {
            let dateInterval = getQueryParameter('date_filter');
            let start = moment().startOf('isoWeek');
            let end = moment().endOf('isoWeek');
            if (dateInterval) {
                dateInterval = dateInterval.split(' - ');
                start = dateInterval[0];
                end = dateInterval[1];
            }
            $('#date_filter').daterangepicker({
                "showDropdowns": true,
                "showWeekNumbers": true,
                "alwaysShowCalendars": true,
                startDate: start,
                endDate: end,
                locale: {
                    format: 'YYYY-MM-DD',
                    firstDay: 1,
                },
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year')
                        .endOf('year')
                    ],
                    'All time': [moment().subtract(30, 'year').startOf('month'), moment().endOf('month')],
                }
            });
        });

        function getQueryParameter(name) {
            const url = window.location.href;
            name = name.replace(/[\[\]]/g, "\\$&");
            const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

    </script>

@stop
