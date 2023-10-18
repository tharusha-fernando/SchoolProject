<?php

namespace App\Http\Controllers;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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
                });

            return DataTables::of($students)
                ->editColumn('name', function ($student) {
                    return $student->name;
                })->editColumn('email', function ($student) {
                    return $student->email;
                })
                ->addColumn('gender', function ($student) {
                    return $student->Student->gender;
                })
                ->addColumn('address', function ($student) {
                    return $student->Student->address;
                })
                ->addColumn('tp', function ($student) {
                    return $student->Student->tp;
                })
                ->addColumn('actions', function ($student) {
                    // $route=route('students.edit')
                    $route = route('students.edit', ['student' => $student]);
                    $htmlContent='<a rel="tooltip" class="btn btn-success btn-link"
                    href="" data-original-title=""
                    title="">
                    <i class="material-icons">edit</i>
                    <div class="ripple-container"></div>
                </a>
                
                <button type="button" class="btn btn-danger btn-link"
                data-original-title="" title="">
                <i class="material-icons">close</i>
                <div class="ripple-container"></div>';
                    return $htmlContent;
                })
                ->rawColumns(['name', 'email','gender','address','tp','actions'])
                ->make(true);
        } catch (Throwable $th) {
            dd($th->getMessage());
        }
    }
}
