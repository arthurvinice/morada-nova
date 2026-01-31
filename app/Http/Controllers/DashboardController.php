<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{

    public function index()
    {
        $userLevel = auth()->user()->nivel;

        if ($userLevel == 'SuperAdmin') {
            return view('dash.superadmin-index');
        }

        return view('dash.index');
    }

}
