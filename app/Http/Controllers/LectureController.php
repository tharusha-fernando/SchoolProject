<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Http\Requests\StoreLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Models\ClassRoom;
use App\Models\Course;
use App\Models\Tutors;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\isEmpty;

class LectureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('lectures.index');

        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses=Course::all();
        $classRooms=ClassRoom::all();
        $tutors=Tutors::with('User')->get();
        return view('lectures.create',compact('courses','classRooms','tutors'));

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLectureRequest $request)
    {
        $validatedData=$request->validated();
        

        if($validatedData['time_slot']==1){
            $validatedData['start_time']=Carbon::parse('14:00:00')->format('H:i:s');
            $validatedData['end_time']=Carbon::parse('16:00:00')->format('H:i:s');

        }elseif($validatedData['time_slot']==2){
            $validatedData['start_time']=Carbon::parse('16:00:00')->format('H:i:s');
            $validatedData['end_time']=Carbon::parse('18:00:00')->format('H:i:s');
        }elseif($validatedData['time_slot']==3){
            $validatedData['start_time']=Carbon::parse('18:00:00')->format('H:i:s');
            $validatedData['end_time']=Carbon::parse('20:00:00')->format('H:i:s');
        }

        $isTaken=Lecture::where('date',$validatedData['date'])
        ->where('start_time',$validatedData['start_time'])
        ->where('classroom_id',$validatedData['classroom_id'])
        ->exists();

        // dd($isTaken);
        if($isTaken){
            return response()->json([
                'message' => 'Time Slot Already Taken',
                'errors' => [
                    'classroom_id' => ['The selected time slot is already taken.'],
                    'time_slot' => ['The selected time slot is already taken.']
                    
                ]
            ], 422);
            // return response()->json(['message'=>"Time Slot Already Taken"],500);
        }
        // dd($validatedData);

        Lecture::create($validatedData);
        return response()->json(['message'=>"Student Created Successfully"],200);



        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecture $lecture)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lecture $lecture)
    {
        $courses=Course::all();
        $classRooms=ClassRoom::all();
        $tutors=Tutors::with('User')->get();
        return view('lectures.edit',compact('lecture','courses','classRooms','tutors'));

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLectureRequest $request, Lecture $lecture)
    {
        $validatedData=$request->validated();
        

        if($validatedData['time_slot']==1){
            $validatedData['start_time']=Carbon::parse('14:00:00')->format('H:i:s');
            $validatedData['end_time']=Carbon::parse('16:00:00')->format('H:i:s');

        }elseif($validatedData['time_slot']==2){
            $validatedData['start_time']=Carbon::parse('16:00:00')->format('H:i:s');
            $validatedData['end_time']=Carbon::parse('18:00:00')->format('H:i:s');
        }elseif($validatedData['time_slot']==3){
            $validatedData['start_time']=Carbon::parse('18:00:00')->format('H:i:s');
            $validatedData['end_time']=Carbon::parse('20:00:00')->format('H:i:s');
        }

        $isTaken=Lecture::where('date',$validatedData['date'])
        ->where('start_time',$validatedData['start_time'])
        ->where('classroom_id',$validatedData['classroom_id'])
        ->whereNot('id',$lecture->id)
        ->exists();

        // dd($isTaken);
        if($isTaken){
            return response()->json([
                'message' => 'Time Slot Already Taken',
                'errors' => [
                    'classroom_id' => ['The selected time slot is already taken.'],
                    'time_slot' => ['The selected time slot is already taken.']
                    
                ]
            ], 422);
            // return response()->json(['message'=>"Time Slot Already Taken"],500);
        }
        // dd($validatedData);

        $lecture->update($validatedData);
        return response()->json(['message'=>"Student Updated Successfully"],200);

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecture $lecture)
    {
        $lecture->delete();
        return response()->json(['message'=>"Lecture Deleted Successfully"],200);

        //
    }

    public function getData(Request $request)
    {
        try {
            $lectures = Lecture::query()
                ->with('Course','ClassRoom','Tutor.User')
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
                ->addColumn('date', function ($lecture) {
                    return $lecture->date;
                })
                ->addColumn('start', function ($lecture) {
                    return $lecture->start_time;
                })
                ->addColumn('end', function ($lecture) {
                    return $lecture->end_time;
                })
                ->addColumn('actions', function ($lecture) {
                    $route = route('lectures.edit', ['lecture' => $lecture]);
                
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
                
                ->rawColumns(['course', 'class_room','tutor','date','start','end','actions'])
                ->make(true);
        } catch (Throwable $th) {
            dd($th->getMessage());
        }
    }
}
