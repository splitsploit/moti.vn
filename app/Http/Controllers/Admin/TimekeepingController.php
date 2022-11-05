<?php

namespace App\Http\Controllers\Admin;

use Gate;
use Exception;
use Carbon\Carbon;
use App\Timesheet;
use App\Timekeeping;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTimekeepingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TimekeepingController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->date_filter)) {

            $parts = explode(' - ', $request->date_filter);

            $dateFromStr = Carbon::parse($parts[0])->startOfDay()->toDateTimeString();

            $dateToStr = Carbon::parse($parts[1])->endOfDay()->toDateTimeString();
        } else {

            $dateFromStr = Carbon::now()->startOfWeek()->toDateTimeString();

            $dateToStr = Carbon::now()->endOfWeek()->toDateTimeString();
        }

        if ($request->action_submit == 'Calculate') {

            abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

            $timesheets = Timesheet::has('user')
                ->whereBetween('start_time', [$dateFromStr, $dateToStr])
                ->where('hours', '<>', '00:00:00')
                ->whereNull('deleted_at')
                ->get();

            $timekeepings = [];

            DB::beginTransaction();

            try {

                foreach ($timesheets as $timesheet) {

                    $before = $timesheet->timekeeping()->first();

                    $timekeeping = Timekeeping::calculate($timesheet);

                    $timekeeping->diff = $before ? array_diff_assoc($before->toArray(), $timekeeping->toArray()) : [];

                    $timekeepings[] = $timekeeping;
                }

                DB::commit();
            } catch (Exception $e) {

                DB::rollBack();

                throw new Exception($e->getMessage());
            }
        } else {

            $timekeepings = Timekeeping::has('user')
                ->whereBetween('start_time', [$dateFromStr, $dateToStr])
                ->when(Gate::none(['user_management_access', 'timekeeping_show']), function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })->get();
        }

        // Payroll
        $payroll = Timekeeping::has('user')
            ->whereBetween('start_time', [$dateFromStr, $dateToStr])
            ->when(Gate::none(['user_management_access', 'timekeeping_show']), function ($query) {
                $query->where('timekeepings.user_id', auth()->user()->id);
            })
            ->selectRaw('timekeepings.user, timekeepings.email, SUM(timekeepings.normal_time) / 60 AS total_normal_time, SUM(timekeepings.special_time) / 60 AS total_special_time, SUM(timekeepings.total) AS total_salary')
            ->orderByRaw('total_salary DESC')
            ->groupBy('timekeepings.user', 'timekeepings.email')
            ->get();

        return view('admin.timekeeping.index', compact('timekeepings', 'payroll'));
    }

    public function destroy(Timekeeping $timekeeping)
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timekeeping->timesheet()->delete();

        $timekeeping->delete();

        return back();
    }

    public function massDestroy(MassDestroyTimekeepingRequest $request)
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $timekeepings = Timekeeping::whereIn('id', request('ids'))->get();

        foreach ($timekeepings as $timekeeping) {

            $timekeeping->timesheet()->delete();

            $timekeeping->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
