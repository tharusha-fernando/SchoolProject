<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class AdminsController extends Controller
{
    public function index()
    {
        return view('admins.index');
        //
    }

    public function create()
    {
      
        return view('admins.create');
        //
    }

    public function store(StoreAdminRequest $request)
    {
        $validatedData = $request->validated();
        // dd($validatedData);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt('12345678'), //$validatedData['email']
        ]);
        $user->addRole('administrator');


        return response()->json(['message' => "Admin Created Successfully"], 200);
        //
    }



    public function destroy($id)
    {
        $admin=User::find($id);
        // dd($tutor);
        $admin->delete();
        return response()->json(['status' => 'success', 'message' => 'Admin Deleted Successfully.'], 200);
        //
    }



    public function getData(Request $request)
    {
        try {
            $tutors = User::query()
                ->whereHas('role', function ($query) {
                    $query->where('name', 'administrator');
                })->orderBy('created_at', 'desc');

            return DataTables::of($tutors)
                ->editColumn('name', function ($tutor) {
                    return $tutor->name;
                })->editColumn('email', function ($tutor) {
                    return $tutor->email;
                })
                // ->addColumn('gender', function ($tutor) {
                //     return $tutor->Tutor ? $tutor->Tutor->gender : "";
                // })
                // ->addColumn('address', function ($tutor) {
                //     return $tutor->Tutor ? $tutor->Tutor->address : "";
                // })
                // ->addColumn('tp', function ($tutor) {
                //     return $tutor->Tutor ? $tutor->Tutor->tp : "";
                // })
                
                ->addColumn('actions', function ($tutor) {
                    $route = route('tutors.edit', ['tutor' => $tutor]);

                    
                    $htmlContent = '
                        
                        
                        <button data-id="' . $tutor->id . '" class="btn btn-danger btn-link deleteBtn" data-original-title="" title="">
                            <i class="material-icons">close</i>
                            <div class="ripple-container"></div>
                        </button>
                        
                    ';

                    // <a rel="tooltip" class="btn btn-success btn-link" href="' . $route . '" data-original-title="" title="">
                    //         <i class="material-icons">edit</i>
                    //         <div class="ripple-container"></div>
                    //     </a>

                    return $htmlContent;
                })
                // ->rawColumns(['name', 'email', 'gender', 'address', 'tp', 'courses', 'actions'])

                ->rawColumns(['name', 'email','actions'])
                ->make(true);
        } catch (Throwable $th) {
            dd($th->getMessage());
        }
    }
    //
}
