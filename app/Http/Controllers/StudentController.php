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
        // dd($validatedData);

        $user=User::create([
            'name'=>$validatedData['name'],
            'email'=>$validatedData['email'],
            'password'=>bcrypt('12345678'),//$validatedData['email']
        ]);
        $user->addRole('student');

        $student=Student::create([
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
    public function edit(User $student)
    {
        $student->load('Student');

        // dd($student);
        return view('students.edit',compact('student'));

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudenRequest $request, User $student)
    {
        $validatedData=$request->validated();

        $student->update([
            'name'=>$validatedData['name'],
            'email'=>$validatedData['email'],
            // 'password'=>bcrypt('12345678'),//$validatedData['email']
        ]);
        // $user->addRole('student');

        $student->Student->update([
            'address'=>$validatedData['address'],
            'tp'=>$validatedData['tp'],
            'gender'=>$validatedData['gender'],
            'address'=>$validatedData['address'],
            // 'user_id'=>$user->id,
            // 'dob'=>fake()->date(),
            // 'pronounce'=>fake()->word()
        ]);
        return response()->json(['message'=>"Student Updated Successfully"],200);

        // dd($student,$validatedData);
        
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }







    public function getData(Request $request)
    {
        try {
            // dd("assasasasa");
            $students = User::query()
                ->with('Student')
                ->whereHas('role', function ($query) {
                    $query->where('name', 'student');
                })->orderBy('created_at', 'desc');

            return DataTables::of($students)
                ->editColumn('name', function ($student) {
                    return $student->name;
                })->editColumn('email', function ($student) {
                    return $student->email;
                })
                ->addColumn('gender', function ($student) {
                    return $student->Student ? $student->Student->gender :"";
                })
                ->addColumn('address', function ($student) {
                    return $student->Student ? $student->Student->address : "";
                })
                ->addColumn('tp', function ($student) {
                    return $student->Student ? $student->Student->tp : "";
                })
                ->addColumn('actions', function ($student) {
                    // $route=route('students.edit')
                    $route = route('students.edit', ['student' => $student]);
                    $deleteRoute = route('students.destroy', ['student' => $student]);

                    $htmlContent = '
                    <a rel="tooltip" class="btn btn-success btn-link" href="' . $route . '" data-original-title="" title="">
                        <i class="material-icons">edit</i>
                        <div class="ripple-container"></div>
                    </a>
                    
                    <button type="button" class="btn btn-danger btn-link" data-original-title="" title="">
                        <i class="material-icons">close</i>
                        <div class="ripple-container"></div>
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
