<?php

namespace App\Http\Controllers\Admin;

use App\Timesheet;

class HomeController
{
    public function index()
    {
        $user = auth()->user();
        
        $isNotCheckOut = !!Timesheet::isNotCheckOut($user->id);

        return view('home', compact( 'user','isNotCheckOut'));
    }
}
