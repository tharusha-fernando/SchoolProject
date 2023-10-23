<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\Lecture;
use App\Models\Tutors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LectureTutorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('tutor_side.lectures.index');

        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $classRooms = ClassRoom::all();
        $tutors = Tutors::with('User')->where('user_id', auth()->user()->id)->get();
        return view('tutor_side.lectures.create', compact('courses', 'classRooms', 'tutors'));

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    public function store(StoreLectureRequest $request)
    {
        $validatedData = $request->validated();


        if ($validatedData['time_slot'] == 1) {
            $validatedData['start_time'] = Carbon::parse('14:00:00')->format('H:i:s');
            $validatedData['end_time'] = Carbon::parse('16:00:00')->format('H:i:s');
        } elseif ($validatedData['time_slot'] == 2) {
            $validatedData['start_time'] = Carbon::parse('16:00:00')->format('H:i:s');
            $validatedData['end_time'] = Carbon::parse('18:00:00')->format('H:i:s');
        } elseif ($validatedData['time_slot'] == 3) {
            $validatedData['start_time'] = Carbon::parse('18:00:00')->format('H:i:s');
            $validatedData['end_time'] = Carbon::parse('20:00:00')->format('H:i:s');
        }

        // dd($validatedData['date']);
        $isTaken = Lecture::where('date', $validatedData['date'])
            ->where(function ($query) use ($validatedData) {
                $query->where('start_time', $validatedData['start_time'])
                    ->where(function ($query2) use ($validatedData) {
                        $query2->where('tutor_id', $validatedData['tutor_id'])
                            ->orWhere('classroom_id', $validatedData['classroom_id']);
                    });
            })
            ->exists();

        // dd($isTaken);
        if ($isTaken) {
            return response()->json([
                'message' => 'Time Slot Already Taken Or Tutor Is Booked',
                'errors' => [
                    'classroom_id' => ['The selected time slot is already taken.'],
                    'time_slot' => ['The selected time slot is already taken.'],
                    'tutor_id' => ['The selected time slot is already taken.']


                ]
            ], 422);
            // return response()->json(['message'=>"Time Slot Already Taken"],500);
        }
        // dd($validatedData);

        Lecture::create($validatedData);
        return response()->json(['message' => "Lecture Created Successfully"], 200);



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
        $lecture=Lecture::find($id);
        $courses = Course::all();
        $classRooms = ClassRoom::all();
        $tutors = Tutors::with('User')->where('user_id', auth()->user()->id)->get();
        return view('tutor_side.lectures.edit', compact('lecture', 'courses', 'classRooms', 'tutors'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }


    public function update(UpdateLectureRequest $request,  $id)
    {
        $lecture=Lecture::find($id);
        $validatedData = $request->validated();


        if ($validatedData['time_slot'] == 1) {
            $validatedData['start_time'] = Carbon::parse('14:00:00')->format('H:i:s');
            $validatedData['end_time'] = Carbon::parse('16:00:00')->format('H:i:s');
        } elseif ($validatedData['time_slot'] == 2) {
            $validatedData['start_time'] = Carbon::parse('16:00:00')->format('H:i:s');
            $validatedData['end_time'] = Carbon::parse('18:00:00')->format('H:i:s');
        } elseif ($validatedData['time_slot'] == 3) {
            $validatedData['start_time'] = Carbon::parse('18:00:00')->format('H:i:s');
            $validatedData['end_time'] = Carbon::parse('20:00:00')->format('H:i:s');
        }

        $isTaken = Lecture::where('date', $validatedData['date'])
            ->whereNot('id', $lecture->id)
            ->where(function ($query) use ($validatedData) {
                $query->where('start_time', $validatedData['start_time'])
                    ->where(function ($query2) use ($validatedData) {
                        $query2->where('tutor_id', $validatedData['tutor_id'])
                            ->orWhere('classroom_id', $validatedData['classroom_id']);
                    });
            })
            ->exists();

        // dd($isTaken);
        if ($isTaken) {
            return response()->json([
                'message' => 'Time Slot Already Taken Or Tutor Is Booked',
                'errors' => [
                    'classroom_id' => ['The selected time slot is already taken.'],
                    'time_slot' => ['The selected time slot is already taken.'],
                    'tutor_id' => ['The selected time slot is already taken.']

                ]
            ], 422);
            // return response()->json(['message'=>"Time Slot Already Taken"],500);
        }
        // dd($validatedData);

        $lecture->update($validatedData);
        return response()->json(['message' => "Lecture Updated Successfully"], 200);

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($lecture);
        $lecture = Lecture::find($id);
        $lecture->delete();
        return response()->json(['message' => "Lecture Deleted Successfully"], 200);
        //
    }



    public function getData(Request $request)
    {
        try {
            $lectures = Lecture::query()
                ->with('Course', 'ClassRoom', 'Tutor.User')
                ->whereHas('Tutor', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                })
                //    ->where('')
                ->orderBy('created_at', 'desc');

            return DataTables::of($lectures)
                ->addColumn('course', function ($lecture) {
                    return $lecture->Course->course_name;
                })->addColumn('class_room', function ($lecture) {
                    return $lecture->ClassRoom->name;
                })
                ->addColumn('tutor', function ($lecture) {
                    return $lecture->Tutor->User->name;
                })
                ->editColumn('date', function ($lecture) {
                    return $lecture->date;
                })
                ->editColumn('start_time', function ($lecture) {
                    return $lecture->start_time;
                })
                ->editColumn('end_time', function ($lecture) {
                    return $lecture->end_time;
                })
                ->addColumn('actions', function ($lecture) {
                    $route = route('lecture-tutors.edit', ['lecture_tutor' => $lecture]);

                    $htmlContent = '
                        <a rel="tooltip" class="btn btn-success btn-link" href="' . $route . '" data-original-title="" title="">
                            <i class="material-icons">edit</i>
                            <div class="ripple-container"></div>
                        </a>
                        
                        <button data-id="' . $lecture->id . '" class="btn btn-danger btn-link deleteBtn" data-original-title="" title="">
                            <i class="material-icons">close</i>
                            <div class="ripple-container"></div>
                        </button>
                        
                    ';

                    return $htmlContent;
                })
                // ->rawColumns(['course', 'class_room','tutor','date','start','end','actions'])

                ->rawColumns(['course', 'class_room', 'tutor', 'date', 'start_time', 'end_time', 'actions'])
                ->make(true);
        } catch (Throwable $th) {
            dd($th->getMessage());
        }
    }
}
