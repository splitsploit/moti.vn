<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\BookingTime;
use App\Configuration;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CalendarController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // Get all resources
        $resources = DB::table('users')
            ->when(Gate::none(['booking_time_access', 'booking_time_show']), function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->join('role_user', function ($join) {
                $join->on('users.id', '=', 'role_user.user_id');
            })->join('roles', function ($join) {
                $join->on('role_user.role_id', '=', 'roles.id');
            })
            ->select('users.id as id', 'roles.title as role', 'users.name as user')
            ->whereNull('roles.deleted_at')
            ->whereNull('users.deleted_at')
            ->orderBy('users.name')
            ->get();

        $dateFromStr = Gate::allows('user_management_access') ? Carbon::now()->subMonths(2)->startOfMonth()->toDateTimeString() : Carbon::now()->startOfMonth()->toDateTimeString();

        $dateToStr = Carbon::now()->addWeeks(1)->endOfWeek()->toDateTimeString();

        $bookingTimeList = BookingTime::whereBetween('start_time', [$dateFromStr, $dateToStr])->get();

        $events = [];

        $timekeepings = [];

        foreach ($bookingTimeList as $item) {

            if (!$item->user || !$item->start_time) {

                continue;
            }

            $user_id = $item->user->id;

            $event = $item->toEvent();

            $event->editable = $item->expiration(); //BookingTime::checkCanBookingTime($user_id, $item->start_time, $item->end_time, $item);

            if ($user->id == $user_id || Gate::any(['booking_time_access', 'booking_time_show'])) {

                $events[] = $event;
            }

            $timekeepings[$user_id]['user'] = $item->user;

            $timekeepings[$user_id]['role'] = $item->user->roles->first();

            $start = Carbon::parse($item->start_time);

            $end = Carbon::parse($item->end_time);

            $total_time = $end->diffInMinutes($start) / 60;

            $timekeepings[$user_id]['total_time'] = ($timekeepings[$user_id]['total_time'] ?? 0) + $total_time;
        }

        $timekeepings = collect($timekeepings)->sortBy('total_time')->reverse()->toArray();

        return view('admin.calendar.calendar', compact('user', 'resources', 'events', 'dateFromStr', 'dateToStr', 'timekeepings'));
    }
}
