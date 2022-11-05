@extends('layouts.admin')
@section('content')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-md-12">
            <form action="" method="get">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="date_filter" id="date_filter" />
                    </div>
                    <div class="col-md-1">
                        <input type="submit" name="action_submit" class="btn btn-success" value="Filter" />
                    </div>
                    @can('user_management_access')
                        <div class="col-md-7">
                            <input type="submit" name="action_submit" class="btn btn-danger" value="Calculate" />
                        </div>
                    @endcan
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.timekeeping.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-timekeeping">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.role') }}
                            </th>
                            <th>
                                {{ trans('cruds.user.fields.email') }}
                            </th>
                            <th style="min-width: 140px;">
                                {{ trans('cruds.timekeeping.fields.start_time') }}
                            </th>
                            <th style="min-width: 140px;">
                                {{ trans('cruds.timekeeping.fields.end_time') }}
                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.normal_time') }}
                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.special_time') }}
                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.total_time') }}
                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.basic_salary') }}
                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.reward_salary') }}
                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.reward_percent') }}
                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.salary') }}
                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.reward') }}
                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.total') }}
                            </th>
                            <th>
                                {{ trans('cruds.timekeeping.fields.notes') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($timekeepings as $key => $timekeeping)
                            <tr data-entry-id="{{ $timekeeping->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $timekeeping->id }}
                                </td>
                                <td>
                                    <del>{{ $timekeeping->diff['role'] ?? '' }}</del>
                                    {{ $timekeeping->role ?? '' }}
                                </td>
                                <td>
                                    <del>{{ $timekeeping->diff['email'] ?? '' }}</del>
                                    {{ $timekeeping->email ?? '' }}
                                </td>
                                <td>
                                    {{ $timekeeping->start_time ?? '' }}
                                </td>
                                <td>
                                    {{ $timekeeping->end_time ?? '' }}
                                </td>
                                <td>
                                    <del>{{ $timekeeping->diff['normal_time'] ?? '' }}</del>
                                    {{ $timekeeping->normal_time ?? '' }}
                                </td>
                                <td>
                                    <del>{{ $timekeeping->diff['special_time'] ?? '' }}</del>
                                    {{ $timekeeping->special_time ?? '' }}
                                </td>
                                <td>
                                    <del>{{ $timekeeping->diff['total_time'] ?? '' }}</del>
                                    {{ $timekeeping->total_time ?? '' }}
                                </td>
                                <td>
                                    <del>{{ isset($timekeeping->diff['basic_salary']) ? number_format($timekeeping->diff['basic_salary'], 0, '.', ',') : '' }}</del>
                                    {{ number_format($timekeeping->basic_salary ?? 0, 0, '.', ',') }}
                                </td>
                                <td>
                                    <del>{{ isset($timekeeping->diff['reward_salary']) ? number_format($timekeeping->diff['reward_salary'], 0, '.', ',') : '' }}</del>
                                    {{ number_format($timekeeping->reward_salary ?? 0, 0, '.', ',') }}
                                </td>
                                <td>
                                    <del>{{ $timekeeping->diff['reward_percent'] ?? '' }}</del>
                                    <b>{{ $timekeeping->reward_percent ?? '' }}</b>%
                                </td>
                                <td>
                                    <del>{{ isset($timekeeping->diff['salary']) ? number_format($timekeeping->diff['salary'], 0, '.', ',') : '' }}</del>
                                    {{ number_format($timekeeping->salary ?? 0, 0, '.', ',') }}
                                </td>
                                <td>
                                    <del>{{ isset($timekeeping->diff['reward']) ? number_format($timekeeping->diff['reward'], 0, '.', ',') : '' }}</del>
                                    {{ number_format($timekeeping->reward ?? 0, 0, '.', ',') }}
                                </td>
                                <td>
                                    <del>{{ isset($timekeeping->diff['total']) ? number_format($timekeeping->diff['total'], 0, '.', ',') : '' }}</del>
                                    <b>{{ number_format($timekeeping->total ?? 0, 0, '.', ',') }}</b>
                                </td>
                                <td>
                                    {{ $timekeeping->notes ?? '' }}
                                </td>
                                <td>
                                    @can('user_management_access')
                                        <form action="{{ route('admin.timekeeping.destroy', $timekeeping->id) }}"
                                            method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
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

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.payroll.title') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-payroll">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.payroll.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.payroll.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.user.fields.email') }}
                            </th>
                            <th>
                                {{ trans('cruds.payroll.fields.total_normal_time') }}
                            </th>
                            <th>
                                {{ trans('cruds.payroll.fields.total_special_time') }}
                            </th>
                            <th>
                                {{ trans('cruds.payroll.fields.total_salary') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($payroll as $key => $salary)
                            <tr data-entry-id="{{ $key }}">
                                <td>

                                </td>
                                <td>
                                    {{ $key + 1 }}
                                </td>
                                <td>
                                    {{ $salary->user ?? '' }}
                                </td>
                                <td>
                                    {{ $salary->email ?? '' }}
                                </td>
                                <td>
                                    {{ number_format($salary['total_normal_time'], 2) }}
                                </td>
                                <td>
                                    {{ number_format($salary['total_special_time'], 2) }}
                                </td>
                                <td>
                                    {{ number_format($salary['total_salary'] ?? 0, 0, '.', ',') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <b>{{ number_format($payroll->sum('total_normal_time'), 2) }}</b>
                            </td>
                            <td>
                                <b>{{ number_format($payroll->sum('total_special_time'), 2) }}</b>
                            </td>
                            <td>
                                <b>{{ number_format($payroll->sum('total_salary'), 0, '.', ',') }}</b>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons);
            let dtDeleteButtons = [];
            @can('user_management_access')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.timekeeping.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true, 
                            search: 'applied'
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id');
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}');

                            return;
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
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
                                });
                        }
                    }
                };
                dtDeleteButtons.push(deleteButton);
            @endcan
            $.extend(true, $.fn.dataTable.defaults, {
                pageLength: 100
            });
            $('.datatable-timekeeping').DataTable({
                buttons: [...dtButtons, ...dtDeleteButtons],
                order: [
                    [5, 'desc']
                ]
            });
            $('.datatable-payroll').DataTable({
                buttons: dtButtons
            });
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
