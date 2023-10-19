<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasRole('superadministrator')){
            return view('dashboard.index');

        }elseif(auth()->user()->hasRole('administrator')){
            return view('dashboard.index');

        }elseif(auth()->user()->hasRole('student')){
            return view('student_side.dashboard.index');

        }elseif(auth()->user()->hasRole('tutor')){
            return view('tutor_side.dashboard.index');

        }
    }
}
