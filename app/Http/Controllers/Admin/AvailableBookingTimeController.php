<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Role;
use App\AvailableBookingTime;
use App\Http\Requests\MassDestroyAvailableBookingTimeRequest;
use App\Http\Requests\StoreAvailableBookingTimeRequest;
use App\Http\Requests\UpdateAvailableBookingTimeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AvailableBookingTimeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekDays = AvailableBookingTime::WEEK_DAYS;

        $availableBookingTimeList = AvailableBookingTime::all();

        return view('admin.availableBookingTime.index', compact('weekDays', 'availableBookingTimeList'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekDays = AvailableBookingTime::WEEK_DAYS;

        $roles = Role::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.availableBookingTime.create', compact('weekDays','roles'));
    }

    public function store(StoreAvailableBookingTimeRequest $request)
    {
        $weekDays = implode(',', $request->input('week_days'));
        
        $input = $request->except('week_days');

        $input['week_days'] = $weekDays;

        AvailableBookingTime::create($input);

        return redirect()->route('admin.availableBookingTime.index');
    }

    public function edit(AvailableBookingTime $availableBookingTime)
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekDays = AvailableBookingTime::WEEK_DAYS;

        $roles = Role::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $availableBookingTime->load('role');

        $availableBookingTime->week_days = $availableBookingTime->weekDays();

        return view('admin.availableBookingTime.edit', compact('weekDays', 'roles', 'availableBookingTime'));
    }

    public function update(UpdateAvailableBookingTimeRequest $request, AvailableBookingTime $availableBookingTime)
    {
        $weekDays = implode(',', $request->input('week_days'));
        
        $input = $request->except('week_days');

        $input['week_days'] = $weekDays;

        $availableBookingTime->update($input);

        return redirect()->route('admin.availableBookingTime.index');
    }

    public function show(AvailableBookingTime $availableBookingTime)
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $weekDays = AvailableBookingTime::WEEK_DAYS;

        $availableBookingTime->load('role');

        $availableBookingTime->week_days = $availableBookingTime->weekDays();

        return view('admin.availableBookingTime.show', compact('weekDays','availableBookingTime'));
    }

    public function destroy(AvailableBookingTime $availableBookingTime)
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $availableBookingTime->delete();

        return back();
    }

    public function massDestroy(MassDestroyAvailableBookingTimeRequest $request)
    {
        AvailableBookingTime::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
