<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Carbon\Carbon;
use App\User;
use App\Timekeeping;
use App\Timesheet;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTimesheetsRequest;
use App\Http\Requests\UpdateTimesheetsRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TimesheetsController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $isNotCheckOut = !!Timesheet::isNotCheckOut($user->id);

        if (isset($request->date_filter)) {

            $parts = explode(' - ', $request->date_filter);

            $dateFromStr = Carbon::parse($parts[0])->startOfDay()->toDateTimeString();

            $dateToStr = Carbon::parse($parts[1])->endOfDay()->toDateTimeString();
        } else {

            $dateFromStr = Carbon::now()->startOfWeek()->toDateTimeString();

            $dateToStr = Carbon::now()->endOfWeek()->toDateTimeString();
        }

        $timesheets = Timesheet::whereBetween('start_time', [$dateFromStr, $dateToStr])
            ->when(Gate::none(['timesheets_access']), function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();

        return view('admin.timesheets.index', compact('timesheets', 'isNotCheckOut'));
    }

    public function checkIn(Request $request)
    {
        $now = Carbon::now();

        $work = null;
        if (isset($request->work)) {
            $work = $request->work;
        }

        //Uses updateOrCreate to update in case checkIn multiple times.
        Timesheet::updateOrCreate(
            [
                'user_id'    => auth()->user()->id,
                'date'       => $now->toDateString(),
                'hours'      => 0
            ],
            [
                'start_time' => $now->toDateTimeString(),
                'end_time'   => $now->toDateTimeString(),
                'notes'      => $work
            ]
        );

        return redirect()->route('admin.timesheets.index');
    }

    public function checkOut()
    {
        $user_id = auth()->user()->id;

        $timesheet = Timesheet::getTimesheetToCheckOut($user_id);

        if ($timesheet) {

            $start = Carbon::parse($timesheet->start_time);

            $end = Carbon::now();

            $hours = gmdate('H:i:s', $end->diffInSeconds($start));

            $timesheet->update([
                'end_time' => $end->toDateTimeString(),
                'hours'    => $hours
            ]);

            Timekeeping::calculate($timesheet);
        }

        return redirect()->route('admin.timesheets.index');
    }

    public function edit(Timesheet $timesheet)
    {
        abort_if(Gate::denies('timesheets_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $timesheet->load('user');

        return view('admin.timesheets.edit', compact('users', 'timesheet'));
    }

    public function update(UpdateTimesheetsRequest $request, Timesheet $timesheet)
    {
        $start = Carbon::parse($request->get('start_time'));

        $end = Carbon::parse($request->get('end_time'));

        $hours = gmdate('H:i:s', $end->diffInSeconds($start));

        $timesheet->update(array_merge($request->all(), ['hours' => $hours]));

        Timekeeping::calculate($timesheet);

        return redirect()->route('admin.timesheets.index');
    }

    public function destroy(Timesheet $timesheet)
    {
        abort_if(Gate::denies('timesheets_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timesheet->delete();

        return back();
    }

    public function massDestroy(MassDestroyTimesheetsRequest $request)
    {
        abort_if(Gate::denies('timesheets_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Timesheet::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
