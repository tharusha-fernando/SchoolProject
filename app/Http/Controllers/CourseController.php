<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;


class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('courses.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $validatedData=$request->validated();
        Course::create($validatedData);

        return response()->json(['message'=>"Course Created Successfully"],200);

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        // $student->load('Student');

        return view('courses.edit',compact('course'));

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $validatedData=$request->validated();
        $course->update($validatedData);

        return response()->json(['message'=>"Course Updated Successfully"],200);

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return response()->json(['status' => 'success', 'message' => 'Course Deleted Successfully.'], 200);
        //
    }



    public function getData(Request $request)
    {
        try {
            $courses = Course::query()
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
                ->addColumn('actions', function ($course) {
                    $route = route('courses.edit', ['course' => $course]);
                
                    $htmlContent = '
                        <a rel="tooltip" class="btn btn-success btn-link" href="' . $route . '" data-original-title="" title="">
                            <i class="material-icons">edit</i>
                            <div class="ripple-container"></div>
                        </a>
                        
                        <button data-id="' . $course->id . '" class="btn btn-danger btn-link deleteBtn" data-original-title="" title="">
                            <i class="material-icons">close</i>
                            <div class="ripple-container"></div>
                        </button>
                        
                    ';
                
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
