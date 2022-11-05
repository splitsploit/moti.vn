@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">Calendar</div>
                    <div class="card-body">
                        <div id='calendar'></div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        {{ trans('cruds.bookingTime.title') }} Total from {{ $dateFromStr }} to {{ $dateToStr }}
                    </div>
            
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover datatable">
                                <thead>
                                    <tr>
                                        <th style="width: 15%;">
                                            #
                                        </th>
                                        <th>
                                            {{ trans('cruds.timekeeping.fields.role') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.timekeeping.fields.user') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.user.fields.email') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.timekeeping.fields.total_time') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($timekeepings as $key => $timekeeping)
                                        <tr data-entry-id="{{ $key }}">
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $timekeeping['role']->title ?? '' }}
                                            </td>
                                            <td>
                                                {{ $timekeeping['user']->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $timekeeping['user']->email ?? '' }}
                                            </td>
                                            <td>
                                                {{ $timekeeping['total_time'] }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const booking = urlParams.get('booking') === 'true';
            const events = {!!json_encode($events)!!};
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                schedulerLicenseKey: 'GPL-My-Project-Is-Open-Source',
                headerToolbar: {
                    left: !booking ? 'prev,next today': '',
                    center: 'title',
                    right: !booking ? 'resourceTimelineDay,resourceTimelineWeek,resourceTimelineMonth': ''
                },
                views: {
                    resourceTimelineDay: {
                        type: 'resourceTimeline',
                        slotDuration: '00:30:00',
                        slotLabelFormat: [
                            {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false
                            }
                        ],
                        buttonText: 'Day'
                    },
                    resourceTimelineWeek: {
                        type: 'resourceTimeline',
                        slotDuration: '00:30:00',
                        slotLabelFormat: [
                            {
                                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
                            },
                            {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false
                            }
                        ],
                        buttonText: 'Week'
                    },
                    resourceTimelineMonth: {
                        type: 'resourceTimeline',
                        buttonText: 'Month'
                    }
                },
                aspectRatio: 1.5,
                initialView: booking ? 'resourceTimelineWeek' : 'resourceTimelineDay',
                nowIndicator: true,
                firstDay: 1,
                timeZone: 'GMT',
                resourceAreaWidth: '15%',
                resourceAreaColumns: [
                    {
                        field: 'user',
                        headerContent: 'User'
                    }
                ],
                resourceGroupField: 'role',
                resources: {!!json_encode($resources)!!},
                events: events,
                slotMinTime: '06:00:00',
                slotMaxTime: '24:00:00',
                scrollTime: '06:00:00',
                height: 'auto',
                selectable: true,
                select: function (info) {
                    addEvent(info)
                },
                eventDrop: function (info) {
                    updateEvent(info)
                },
                eventResize: function (info) {
                    updateEvent(info)
                },
            });
            calendar.render();

            if (booking) {
                calendar.next();
            }

            const addEvent = function (info) {
                let event = info;
                event.title = event.resource.extendedProps['user'] || "{{ $user->name }}";
                event.editable = true;
                $.ajax({
                    headers: {
                        'x-csrf-token': _token
                    },
                    method: 'POST',
                    url: `{{ route('api.admin.bookingTime.store') }}`,
                    data: {
                        user_id: event.resource.id,
                        start_time: formatDateTime(event.startStr),
                        end_time: formatDateTime(event.endStr)
                    }
                }).done(function (response) {
                    calendar.addEvent(response.data);
                }).fail(function (error) {
                    console.error(error.responseJSON);
                    let errors = Object.values(error.responseJSON.errors);
                    let message = '';
                    for (let idx in errors) {
                        message += errors[idx] + '\n';
                    }
                    alert(message);
                });
            }
            const updateEvent = function (info) {
                let event = info.event;
                $.ajax({
                    headers: {
                        'x-csrf-token': _token
                    },
                    method: 'PUT',
                    url: `{{ route('api.admin.bookingTime.update', '') }}/${event.id}`,
                    data: {
                        user_id: event.getResources() ? event.getResources()[0].id : "{{ $user->id }}",
                        start_time: formatDateTime(event.startStr),
                        end_time: formatDateTime(event.endStr)
                    }
                }).done(function (response) {
                }).fail(function (error) {
                    console.error(error.responseJSON);
                    let errors = Object.values(error.responseJSON.errors);
                    let message = '';
                    for (let idx in errors) {
                        message += errors[idx] + '\n';
                    }
                    alert(message);
                    info.revert();
                });
            }
            const formatDateTime = function (dateTimeStr) {
                let d = new Date(dateTimeStr);
                return [d.getFullYear(), ("00" + (d.getMonth() + 1)).slice(-2), ("00" + d.getDate()).slice(-2)].join('-') + ' ' + [("00" + d.getHours()).slice(-2), ("00" + d.getMinutes()).slice(-2)].join(':');
            }
        });
    </script>
@endsection
