<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lecture;
use App\Models\Student;
use App\Models\Tutors;
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
            return view('dashboard.index', compact('studentCount', 'tutorCount','courseCount','lectureCount'));
        } elseif (auth()->user()->hasRole('administrator')) {
            $studentCount = Student::count();
            $tutorCount = Tutors::count();
            $courseCount=Course::count();
            $lectureCount=Lecture::count();
            return view('dashboard.index', compact('studentCount', 'tutorCount','courseCount','lectureCount'));
        } elseif (auth()->user()->hasRole('student')) {
            return view('student_side.dashboard.index');
        } elseif (auth()->user()->hasRole('tutor')) {
            return view('tutor_side.dashboard.index');
        }
    }
}
