<?php

namespace App\Http\Controllers\Api\V1\Admin;

use Gate;
use App\BookingTime;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingTimeRequest;
use App\Http\Requests\UpdateBookingTimeRequest;
use App\Http\Resources\Admin\BookingTimeResource;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;

class BookingTimeApiController extends Controller
{
    // public function index()
    // {
    //     abort_if(Gate::denies('booking_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

    //     return new BookingTimeResource(BookingTime::with(['user'])->get());
    // }

    public function store(StoreBookingTimeRequest $request)
    {
        $startTime = Carbon::parse($request->get('start_time'));

        $endTime = Carbon::parse($request->get('end_time'));

        $diff = $endTime->diffInSeconds($startTime);

        $hours = gmdate('H:i:s', $diff);

        $bookingTime = BookingTime::create(array_merge($request->all(), ['hours' => $hours, 'd_hours' => $diff / 3600]));

        $event = $bookingTime->toEvent();

        return (new BookingTimeResource((array)$event))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(BookingTime $bookingTime)
    {
        abort_if(Gate::denies('booking_time_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BookingTimeResource($bookingTime->load(['user']));
    }

    public function update(UpdateBookingTimeRequest $request, BookingTime $bookingTime)
    {
        $startTime = Carbon::parse($request->get('start_time'));

        $endTime = Carbon::parse($request->get('end_time'));
        
        $diff = $endTime->diffInSeconds($startTime);

        $hours = gmdate('H:i:s', $diff);

        $bookingTime->update(array_merge($request->all(), ['hours' => $hours, 'd_hours' => $diff / 3600]));

        $event = $bookingTime->toEvent();

        return (new BookingTimeResource((array)$event))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(BookingTime $bookingTime)
    {
        abort_if(Gate::denies('booking_time_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookingTime->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
