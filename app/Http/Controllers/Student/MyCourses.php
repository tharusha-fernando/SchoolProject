<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Throwable;

class MyCourses extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('student_side.courses.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);

        $course=Course::find($request->id);
$student=Student::where('user_id',auth()->user()->id)->first();
        $course->Student()->attach($student);

        return response()->json(['message'=>"Course Added Successfully"],200);

        //
    }



    // public function removeCourse(Request $request)
    // {
    //     dd($request);

    //     $course=Course::find($request->id);

    //     $course->Student()->detach(auth()->user()->id);

    //     return response()->json(['message'=>"Course Removed Successfully"],200);

    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
    
        // dd($course);
        $course=Course::find($id);
        $student=Student::where('user_id',auth()->user()->id)->first();

        $course->Student()->detach($student->id);

        return response()->json(['message'=>"Course Removed Successfully"],200);
        //
    }
    

    public function getData(Request $request)
    {
        $user_id=auth()->user()->id;
        // dd("asasas");
        try {
            $courses = Course::query()->with('Student')
                ->orderBy('created_at', 'desc');

            return DataTables::of($courses)
                ->editColumn('course_code', function ($course) {
                    return $course->course_code ;
                })->editColumn('course_name', function ($course) {
                    return $course->course_name ;
                })
                ->addColumn('description', function ($course) {
                    // Str::limit($course->description, $limit = 20, $end = '...')
                    // return $course->description ;
                    return Str::limit($course->description, $limit = 20, $end = '...') ;
                })
                // ->addColumn('address', function ($course) {
                //     return $course->Student ? $course->Student->address : "";
                // })
                // ->addColumn('tp', function ($course) {
                //     return $course->Student ? $course->Student->tp : "";
                // })
                ->addColumn('actions', function ($course)use($user_id) {
                    $route = route('courses.edit', ['course' => $course]);
                //     <a rel="tooltip" class="btn btn-success btn-link" href="' . $route . '" data-original-title="" title="">
                //     <i class="material-icons">edit</i>
                //     <div class="ripple-container"></div>
                // </a>
                if(!$course->Student->where('user_id',$user_id)->first()){
                    $htmlContent = '
                       
                    <button data-id="' . $course->id . '" class="btn btn-success btn-link addBtn" data-original-title="" title="">
                    <i class="material-icons">add</i>
                    <div class="ripple-container"></div>
                </button>
                        
                    ';
                }else{
                    $htmlContent = '
                       
                    <button data-id="' . $course->id . '" class="btn btn-danger btn-link removeBtn" data-original-title="" title="">
                        <i class="material-icons">remove</i>
                        <div class="ripple-container"></div>
                    </button>
                    
                ';
                }
               
                   
                
                    return $htmlContent;
                })
                // ->rawColumns(['course_code', 'course_name','description','address','tp','actions'])
                ->rawColumns(['course_code', 'course_name','description','actions'])
                ->make(true);
        } catch (Throwable $th) {
            dd($th->getMessage());
        }
    }
}
