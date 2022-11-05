<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Role;
use App\SpecialTime;
use App\Http\Requests\MassDestroySpecialTimeRequest;
use App\Http\Requests\StoreSpecialTimeRequest;
use App\Http\Requests\UpdateSpecialTimeRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SpecialTimeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specialTimeList = SpecialTime::all();

        return view('admin.specialTime.index', compact('specialTimeList'));
    }

    public function create()
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.specialTime.create', compact('roles'));
    }

    public function store(StoreSpecialTimeRequest $request)
    {
        SpecialTime::create($request->all());

        return redirect()->route('admin.specialTime.index');
    }

    public function edit(SpecialTime $specialTime)
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.specialTime.edit', compact('roles', 'specialTime'));
    }

    public function update(UpdateSpecialTimeRequest $request, SpecialTime $specialTime)
    {
        $specialTime->update($request->all());

        return redirect()->route('admin.specialTime.index');
    }

    public function show(SpecialTime $specialTime)
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.specialTime.show', compact('specialTime'));
    }

    public function destroy(SpecialTime $specialTime)
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $specialTime->delete();

        return back();
    }

    public function massDestroy(MassDestroySpecialTimeRequest $request)
    {
        SpecialTime::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
