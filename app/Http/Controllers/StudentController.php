<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudenRequest;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('students.index');
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('students.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStudentRequest $request)
    {
        $validatedData=$request->validated();

        $user=User::create([
            'name'=>$validatedData['name'],
            'email'=>$validatedData['email'],
            'password'=>bcrypt('12345678'),//$validatedData['email']
        ]);
        $user->addRole('student');

        $tutor=Student::create([
            'address'=>$validatedData['address'],
            'tp'=>$validatedData['tp'],
            'gender'=>$validatedData['gender'],
            'address'=>$validatedData['address'],
            'user_id'=>$user->id,
            'dob'=>fake()->date(),
            'pronounce'=>fake()->word()
        ]);
        

        return response()->json(['message'=>"Student Created Successfully"],200);

        //
    }

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
    public function edit(User $tutor)
    {
        $tutor->load('Student');

        return view('students.edit',compact('student'));

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudenRequest $request, User $tutor)
    {
        $validatedData=$request->validated();

        $tutor->update([
            'name'=>$validatedData['name'],
            'email'=>$validatedData['email'],
        ]);

        $tutor->Tutor->update([
            'address'=>$validatedData['address'],
            'tp'=>$validatedData['tp'],
            'gender'=>$validatedData['gender'],
            'address'=>$validatedData['address'],
           
        ]);
        return response()->json(['message'=>"Student Updated Successfully"],200);
        
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $tutor)
    {
        $tutor->delete();
        return response()->json(['status' => 'success', 'message' => 'Student Deleted Successfully.'], 200);
        //
    }







    public function getData(Request $request)
    {
        try {
            $tutors = User::query()
                ->with('Tutor')
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
                    return $tutor->Tutor ? $tutor->Tutor->gender :"";
                })
                ->addColumn('address', function ($tutor) {
                    return $tutor->Tutor ? $tutor->Tutor->address : "";
                })
                ->addColumn('tp', function ($tutor) {
                    return $tutor->Tutor ? $tutor->Tutor->tp : "";
                })
                ->addColumn('actions', function ($tutor) {
                    $route = route('students.edit', ['student' => $tutor]);
                
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
                
                ->rawColumns(['name', 'email','gender','address','tp','actions'])
                ->make(true);
        } catch (Throwable $th) {
            dd($th->getMessage());
        }
    }
}
