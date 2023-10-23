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
        $today = Carbon::today();

        // Check if today is a Monday
        if ($today->dayOfWeek === Carbon::MONDAY) {
            // If today is Monday, return today's date
            $closestPastMonday = $today->format('Y:m:d');
        } else {
            // Find the date of the closest past Monday
            $closestPastMonday = $today->previous(Carbon::MONDAY)->format('Y:m:d');
        }

        // Check if today is a Monday
        if ($today->dayOfWeek === Carbon::SUNDAY) {
            // If today is Monday, return today's date
            $closestNextSunday = $today->format('Y:m:d');
        } else {
            // Find the date of the closest past Monday
            $closestNextSunday = $today->next(Carbon::SUNDAY)->format('Y:m:d');
        }


        if (auth()->user()->hasRole('superadminisasastrator')) {
            $studentCount = Student::count();
            $tutorCount = Tutors::count();
            $courseCount=Course::count();
            $lectureCount=Lecture::whereBetween('date', [$closestPastMonday, $closestNextSunday])->count();//->
            $todaysLectures=Lecture::where('date',Carbon::now()->tz('Asia/Colombo')->format('Y:m:d'))->orderBy('start_time','desc');
            return view('dashboard.index', compact('studentCount', 'tutorCount','courseCount','lectureCount','todaysLectures'));
        } elseif (auth()->user()->hasRole('administrator') || auth()->user()->hasRole('superadministrator' )) {
            $studentCount = Student::count();
            $tutorCount = Tutors::count();
            $courseCount=Course::count();
            $lectureCount=Lecture::whereBetween('date', [$closestPastMonday, $closestNextSunday])->count();
            $lectureTimetable=LectureController::getTimetable();
            // dd($lectureTimetable);->
            // return $lectureTimetable;
            $todaysLectures=Lecture::with('Course','ClassRoom','Tutor.User')// ->
            ->where('date',Carbon::now()->tz('Asia/Colombo')->format('Y:m:d'))->orderBy('start_time','desc')->get();
            // dd(Carbon::now()->tz('Asia/Colombo')->format('Y:m:d'));
// dd($todaysLectures);
            return view('dashboard.index', compact('studentCount', 'tutorCount','courseCount','lectureCount','todaysLectures','lectureTimetable'));
        } elseif (auth()->user()->hasRole('student')) {
            $studentCount = Student::count();
            $tutorCount = Tutors::count();
            $courseCount=Course::count();
            $lectureCount=Lecture::whereBetween('date', [$closestPastMonday, $closestNextSunday])->count();
            $lectureTimetable=LectureController::getTimetable();
            return view('student_side.dashboard.index',compact('studentCount', 'tutorCount','courseCount','lectureCount','lectureTimetable'));
        } elseif (auth()->user()->hasRole('tutor')) {
            $studentCount = Student::count();
            $tutorCount = Tutors::count();
            $courseCount=Course::count();
            $lectureCount=Lecture::whereBetween('date', [$closestPastMonday, $closestNextSunday])->count();
            $lectureTimetable=LectureController::getTimetable();
            return view('tutor_side.dashboard.index',compact('studentCount', 'tutorCount','courseCount','lectureCount','lectureTimetable'));
       
            // return view('tutor_side.dashboard.index');
        }
    }
}
