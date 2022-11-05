@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-md-6">
            <a class="btn btn-success" href="{{ route('admin.bookingTime.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.bookingTime.title_singular') }}
            </a>
            @if ($isOpenBookingTime)
                <a class="btn btn-info" href="{{ route('admin.calendar.index') . '?booking=true' }}">
                    {{ trans('global.add') }} {{ trans('cruds.bookingTime.title_singular') }} in Calendar
                </a>
            @else
                <span class="text-danger">The booking time has not yet opened.</span>
            @endif
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
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.bookingTime.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-BookingTime">
                    <thead>
                        <tr>
                            <th>

                            </th>
                            <th>
                                {{ trans('cruds.bookingTime.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.bookingTime.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.user.fields.email') }}
                            </th>
                            <th>
                                {{ trans('cruds.bookingTime.fields.start_time') }}
                            </th>
                            <th>
                                {{ trans('cruds.bookingTime.fields.end_time') }}
                            </th>
                            <th>
                                {{ trans('cruds.bookingTime.fields.hours') }}
                            </th>
                            <th>

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookingTimeList as $key => $bookingTime)
                            <tr data-entry-id="{{ $bookingTime->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $bookingTime->id ?? '' }}
                                </td>
                                <td>
                                    {{ $bookingTime->user->name ?? '' }}
                                </td>
                                <td>
                                    {{ $bookingTime->user->email ?? '' }}
                                </td>
                                <td>
                                    {{ $bookingTime->start_time ?? '' }}
                                </td>
                                <td>
                                    {{ $bookingTime->end_time ?? '' }}
                                </td>
                                <td>
                                    {{ $bookingTime->hours ?? '' }}
                                </td>
                                <td>
                                    @can('booking_time_show')
                                        <a class="btn btn-xs btn-primary"
                                            href="{{ route('admin.bookingTime.show', $bookingTime->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan
                                    @if ($bookingTime->permission('booking_time_edit') && $bookingTime->expiration())
                                        <a class="btn btn-xs btn-info"
                                            href="{{ route('admin.bookingTime.edit', $bookingTime->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endif
                                    @if ($bookingTime->permission('booking_time_delete') && $bookingTime->expiration())
                                        <form action="{{ route('admin.bookingTime.destroy', $bookingTime->id) }}"
                                            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                            style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger"
                                                value="{{ trans('global.delete') }}">
                                        </form>
                                    @endif
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
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('booking_time_delete')
                let deleteButtonTrans = "{{ trans('global.datatables.delete') }}";
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.bookingTime.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true,
                            search:  'applied'
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id');
                        });

                        if (ids.length === 0) {
                            alert("{{ trans('global.datatables.zero_selected') }}");
                            return;
                        }

                        if (confirm("{{ trans('global.areYouSure') }}")) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload();
                                })
                        }
                    }
                };
                dtButtons.push(deleteButton);
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            var table = $('.datatable-BookingTime:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
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
