<?php

namespace App\Http\Controllers\Admin;

use Gate;
use App\Http\Controllers\Controller;
use App\Configuration;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfigurationsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $configurations = Configuration::all();

        return view('admin.configurations.index', compact('configurations'));
    }

    public function update(Request $request, Configuration $configuration)
    {
        abort_if(Gate::denies('user_management_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $result = $configuration->update([
            'value' => $request['value'],
            'description' => $request['description']
        ]);

        return redirect()->route('admin.configurations.index', $result ? [] : ['error=1']);
    }
}
