<?php

namespace App\Http\Controllers;

use App\Models\Tutors;
use App\Http\Requests\StoreTutorsRequest;
use App\Http\Requests\UpdateTutorsRequest;
use App\Models\Course;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request as HttpRequest;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\isEmpty;

class TutorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tutor.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $Courses = Course::all();
        return view('tutor.create', compact('Courses'));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTutorsRequest $request)
    {
        $validatedData = $request->validated();
        // dd($validatedData);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt('12345678'), //$validatedData['email']
        ]);
        $user->addRole('tutor');

        $tutor = Tutors::create([
            'address' => $validatedData['address'],
            'tp' => $validatedData['tp'],
            'gender' => $validatedData['gender'],
            'address' => $validatedData['address'],
            'user_id' => $user->id,
            'dob' => fake()->date(),
            'pronounce' => fake()->word()
        ]);

        foreach ($validatedData['courses'] as $courseId) {
            $tutor->Course()->attach($courseId);
        }


        return response()->json(['message' => "Student Created Successfully"], 200);
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Tutors $tutors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $tutor)
    {
        $tutor->load('Tutor');
        $Courses=Course::all();

        return view('tutor.edit',compact('tutor','Courses'));

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTutorsRequest $request, User $tutor)
    {
        $validatedData = $request->validated();
        $tutor->load('Tutor');
        $tutor->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
        ]);

        $tutor->Tutor->update([
            'address' => $validatedData['address'],
            'tp' => $validatedData['tp'],
            'gender' => $validatedData['gender'],
            'address' => $validatedData['address'],
        ]);

        $tutor->Tutor->Course()->detach();
        foreach ($validatedData['courses'] as $courseId) {
            $tutor->Tutor->Course()->attach($courseId);
        }


        return response()->json(['message' => "Tutor Updated Successfully"], 200);
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tutor=User::find($id);
        // dd($tutor);
        $tutor->delete();
        return response()->json(['status' => 'success', 'message' => 'Tutor Deleted Successfully.'], 200);
        //
    }


    public function getData(HttpRequest $request)
    {
        try {
            $tutors = User::query()
                ->with('Tutor.Course')
                ->whereHas('role', function ($query) {
                    $query->where('name', 'tutor');
                })->orderBy('created_at', 'desc');

            return DataTables::of($tutors)
                ->editColumn('name', function ($tutor) {
                    return $tutor->name;
                })->editColumn('email', function ($tutor) {
                    return $tutor->email;
                })
                ->addColumn('gender', function ($tutor) {
                    return $tutor->Tutor ? $tutor->Tutor->gender : "";
                })
                ->addColumn('address', function ($tutor) {
                    return $tutor->Tutor ? $tutor->Tutor->address : "";
                })
                ->addColumn('tp', function ($tutor) {
                    return $tutor->Tutor ? $tutor->Tutor->tp : "";
                })
                ->addColumn('courses', function ($tutor) {
                    //    dd($tutor->Tutor->Course);
                    $htmlContent = '<ul>';
                    // dd($tutor->Tutor);
                    foreach ($tutor->Tutor->Course as $course) {
                        $htmlContent .= '<li>' . $course->course_name . '</li>';
                    }
                    $htmlContent .= '</ul>';
                    if ($htmlContent=='<ul></ul>') {
                        $htmlContent = "N/A";
                    }



                    return $htmlContent;
                    // return $tutor->Tutor ? $tutor->Tutor->tp : "";
                })
                ->addColumn('actions', function ($tutor) {
                    $route = route('tutors.edit', ['tutor' => $tutor]);

                    $htmlContent = '
                        <a rel="tooltip" class="btn btn-success btn-link" href="' . $route . '" data-original-title="" title="">
                            <i class="material-icons">edit</i>
                            <div class="ripple-container"></div>
                        </a>
                        
                        <button data-id="' . $tutor->id . '" class="btn btn-danger btn-link deleteBtn" data-original-title="" title="">
                            <i class="material-icons">close</i>
                            <div class="ripple-container"></div>
                        </button>
                        
                    ';

                    return $htmlContent;
                })

                ->rawColumns(['name', 'email', 'gender', 'address', 'tp', 'courses', 'actions'])
                ->make(true);
        } catch (Throwable $th) {
            dd($th->getMessage());
        }
    }
    
}
