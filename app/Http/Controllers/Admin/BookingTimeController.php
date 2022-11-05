<?php

namespace App\Http\Controllers\Admin;

use App\BookingTime;
use App\Http\Requests\MassDestroyBookingTimeRequest;
use App\Http\Requests\StoreBookingTimeRequest;
use App\Http\Requests\UpdateBookingTimeRequest;
use App\User;
use Carbon\Carbon;
use Gate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingTimeController extends Controller
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

        $bookingTimeList = BookingTime::whereBetween('start_time', [$dateFromStr, $dateToStr])
            ->when(Gate::none(['booking_time_access', 'booking_time_show']), function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->get();
        
        $isOpenBookingTime = BookingTime::isOpenBookingTime();

        session()->put('previous-url', url()->full());

        return view('admin.bookingTime.index', compact('bookingTimeList', 'isOpenBookingTime'));
    }

    public function create()
    {
        abort_if(Gate::denies('booking_time_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (Gate::allows('booking_time_access')) {

            $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        } else {

            $users = User::where('id', auth()->user()->id)->pluck('name', 'id');
        }

        return view('admin.bookingTime.create', compact('users'));
    }

    public function store(StoreBookingTimeRequest $request)
    {
        $startTime = Carbon::parse($request->get('start_time'));

        $endTime = Carbon::parse($request->get('end_time'));

        $diff = $endTime->diffInSeconds($startTime);

        $hours = gmdate('H:i:s', $diff);

        BookingTime::create(array_merge($request->all(), ['hours' => $hours, 'd_hours' => $diff / 3600]));

        $previous = session()->get('previous-url');

        return $previous ? redirect()->to($previous) : redirect()->route('admin.bookingTime.index');
    }

    public function edit(BookingTime $bookingTime)
    {
        abort_if(!($bookingTime->permission('booking_time_edit') && $bookingTime->expiration($bookingTime)), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $bookingTime->load('user');

        return view('admin.bookingTime.edit', compact('users', 'bookingTime'));
    }

    public function update(UpdateBookingTimeRequest $request, BookingTime $bookingTime)
    {
        $startTime = Carbon::parse($request->get('start_time'));

        $endTime = Carbon::parse($request->get('end_time'));

        $diff = $endTime->diffInSeconds($startTime);

        $hours = gmdate('H:i:s', $diff);

        $bookingTime->update(array_merge($request->all(), ['hours' => $hours, 'd_hours' => $diff / 3600]));

        $previous = session()->get('previous-url');

        return $previous ? redirect()->to($previous) : redirect()->route('admin.bookingTime.index');
    }

    public function show(BookingTime $bookingTime)
    {
        abort_if(Gate::denies('booking_time_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookingTime->load('user');

        return view('admin.bookingTime.show', compact('bookingTime'));
    }

    public function destroy(BookingTime $bookingTime)
    {
        abort_if(!($bookingTime->permission('booking_time_delete') && $bookingTime->expiration($bookingTime)), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookingTime->delete();

        $previous = session()->get('previous-url');

        return $previous ? redirect()->to($previous) : redirect()->route('admin.bookingTime.index');
    }

    public function massDestroy(MassDestroyBookingTimeRequest $request)
    {
        BookingTime::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
