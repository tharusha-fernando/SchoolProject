<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\Student;
use App\Models\Tutors;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->hasRole('superadministrator')) {
            $studentCount = Student::count();
            $tutorCount = Tutors::count();
            $courseCount=Course::count();
            $lectureCount=Lecture::count();
            $todaysLectures=Lecture::where('date',Carbon::now()->tz('Asia/Colombo')->format('Y:m:d'))->orderBy('start_time','desc');
            return view('dashboard.index', compact('studentCount', 'tutorCount','courseCount','lectureCount','todaysLectures'));
        } elseif (auth()->user()->hasRole('administrator')) {
            $studentCount = Student::count();
            $tutorCount = Tutors::count();
            $courseCount=Course::count();
            $lectureCount=Lecture::count();
            $todaysLectures=Lecture::with('Course','ClassRoom','Tutor.User')// ->
            ->where('date',Carbon::now()->tz('Asia/Colombo')->format('Y:m:d'))->orderBy('start_time','desc')->get();
            // dd(Carbon::now()->tz('Asia/Colombo')->format('Y:m:d'));
// dd($todaysLectures);
            return view('dashboard.index', compact('studentCount', 'tutorCount','courseCount','lectureCount','todaysLectures'));
        } elseif (auth()->user()->hasRole('student')) {
            return view('student_side.dashboard.index');
        } elseif (auth()->user()->hasRole('tutor')) {
            return view('tutor_side.dashboard.index');
        }
    }
}
