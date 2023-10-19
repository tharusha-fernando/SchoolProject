<?php

namespace App\Http\Controllers;

use App\Models\Tutors;
use App\Http\Requests\StoreTutorsRequest;
use App\Http\Requests\UpdateTutorsRequest;
use App\Models\User;
use GuzzleHttp\Psr7\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTutorsRequest $request)
    {
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
    public function edit(Tutors $tutors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTutorsRequest $request, Tutors $tutors)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tutors $tutors)
    {
        //
    }


    public function getData(Request $request)
    {
        try {
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
                    $route = route('students.edit', ['student' => $student]);
                
                    $htmlContent = '
                        <a rel="tooltip" class="btn btn-success btn-link" href="' . $route . '" data-original-title="" title="">
                            <i class="material-icons">edit</i>
                            <div class="ripple-container"></div>
                        </a>
                        
                        <button data-id="' . $student->id . '" class="btn btn-danger btn-link deleteBtn" data-original-title="" title="">
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
