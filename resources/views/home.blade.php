@extends('layouts.admin')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>

                    <div class="card-body">
                        @if(session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <p>
                        You are logged in, {{$user->name}}!
                        </p>
                        <div class="form-check checkbox">
                            <input class="form-check-input" name="as-checkin" type="checkbox" id="as-checkin" style="vertical-align: middle;" />
                            <label class="form-check-label" for="as-checkin" style="vertical-align: middle;">
                                I am working for CONVERT.
                            </label>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a class="btn btn-success"
                           href="{{ $isNotCheckOut ? route("admin.timesheets.checkOut") : route("admin.timesheets.checkIn") }}">
                            {{ $isNotCheckOut ? trans('cruds.timesheets.check_out') : trans('cruds.timesheets.check_in') }}
                        </a>
                    </div>
                </div>
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
@endsection
