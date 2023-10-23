<?php

use App\Http\Controllers\AdminsController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\Student\MyCourses;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\Tutor\LectureTutorController;
use App\Http\Controllers\TutorsController;

Route::get('/', function () {return redirect('sign-in');})->middleware('guest');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');
Route::get('sign-up', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('sign-up', [RegisterController::class, 'store'])->middleware('guest');
Route::get('sign-in', [SessionsController::class, 'create'])->middleware('guest')->name('login');
Route::post('sign-in', [SessionsController::class, 'store'])->middleware('guest');
Route::post('verify', [SessionsController::class, 'show'])->middleware('guest');
Route::post('reset-password', [SessionsController::class, 'update'])->middleware('guest')->name('password.update');
Route::get('verify', function () {
	return view('sessions.password.verify');
})->middleware('guest')->name('verify'); 
Route::get('/reset-password/{token}', function ($token) {
	return view('sessions.password.reset', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('sign-out', [SessionsController::class, 'destroy'])->middleware('auth')->name('logout');
Route::get('profile', [ProfileController::class, 'create'])->middleware('auth')->name('profile');
Route::post('user-profile', [ProfileController::class, 'update'])->middleware('auth');
Route::group(['middleware' => 'auth'], function () {
	Route::get('billing', function () {
		return view('pages.billing');
	})->name('billing');
	Route::get('tables', function () {
		return view('pages.tables');
	})->name('tables');
	Route::get('rtl', function () {
		return view('pages.rtl');
	})->name('rtl');
	Route::get('virtual-reality', function () {
		return view('pages.virtual-reality');
	})->name('virtual-reality');
	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');
	Route::get('static-sign-in', function () {
		return view('pages.static-sign-in');
	})->name('static-sign-in');
	Route::get('static-sign-up', function () {
		return view('pages.static-sign-up');
	})->name('static-sign-up');
	Route::get('user-management', function () {
		return view('pages.laravel-examples.user-management');
	})->name('user-management');
	Route::get('user-profile', function () {
		return view('pages.laravel-examples.user-profile');
	})->name('user-profile');


	//routes
	
	


	Route::get('/threads/{lecture}/view',[ThreadController::class,'show'])->name('threads.show');
	// Route::resource('threads',ThreadController::class);
	Route::get('/threads',[ThreadController::class,'index'])->name('threads.index');
	Route::get('/threads-get-data',[ThreadController::class,'getData'])->name('threads.getData');

	Route::resource('messages',MessageController::class);

	



	Route::group(['middleware' => ['role:administrator|superadministrator']], function() {
		Route::resource('students',StudentController::class);
		Route::get('/students-get-data',[StudentController::class,'getData'])->name('students.getData');

		Route::resource('tutors',TutorsController::class);
		Route::get('/tutors-get-data',[TutorsController::class,'getData'])->name('tutors.getData');

		Route::resource('admins',AdminsController::class);
		Route::get('/admins-get-data',[AdminsController::class,'getData'])->name('admins.getData');

		Route::resource('courses',CourseController::class);
		Route::get('/courses-get-data',[CourseController::class,'getData'])->name('courses.getData');

		Route::resource('lectures',LectureController::class);
		Route::get('/lectures-get-data',[LectureController::class,'getData'])->name('lectures.getData');
		Route::get('/lectures-get-timetable',[LectureController::class,'getTimetable'])->name('lectures.getTimetable');

	});
	

	Route::group(['prefix' => 'student', 'middleware' => ['role:student']], function() {
		Route::resource('my-courses',MyCourses::class);
		Route::get('/mycourses/get-data',[MyCourses::class,'getData'])->name('my-courses.getData');
		

	});

	Route::group(['prefix' => 'tutor', 'middleware' => ['role:tutor']], function() {
		Route::resource('lecture-tutors',LectureTutorController::class);
		Route::get('/lectures-tutors-get-data',[LectureTutorController::class,'getData'])->name('lectures-tutors.getData');


	});
});