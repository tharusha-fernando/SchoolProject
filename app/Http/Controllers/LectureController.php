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
        $courses = Course::all();
        $classRooms = ClassRoom::all();
        $tutors = Tutors::with('User')->get();
        return view('lectures.create', compact('courses', 'classRooms', 'tutors'));

        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

        $isTaken = Lecture::where('date', $validatedData['date'])
            ->where('start_time', $validatedData['start_time'])
            ->where('classroom_id', $validatedData['classroom_id'])
            ->exists();

        // dd($isTaken);
        if ($isTaken) {
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
        return response()->json(['message' => "Lecture Created Successfully"], 200);



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
        $courses = Course::all();
        $classRooms = ClassRoom::all();
        $tutors = Tutors::with('User')->get();
        return view('lectures.edit', compact('lecture', 'courses', 'classRooms', 'tutors'));

        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLectureRequest $request, Lecture $lecture)
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

        $isTaken = Lecture::where('date', $validatedData['date'])
            ->where('start_time', $validatedData['start_time'])
            ->where('classroom_id', $validatedData['classroom_id'])
            ->whereNot('id', $lecture->id)
            ->exists();

        // dd($isTaken);
        if ($isTaken) {
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
        return response()->json(['message' => "Lecture Updated Successfully"], 200);

        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lecture $lecture)
    {
        $lecture->delete();
        return response()->json(['message' => "Lecture Deleted Successfully"], 200);

        //
    }

    public function getData(Request $request)
    {
        try {
            $lectures = Lecture::query()
                ->with('Course', 'ClassRoom', 'Tutor.User')
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
                // ->rawColumns(['course', 'class_room','tutor','date','start','end','actions'])

                ->rawColumns(['course', 'class_room', 'tutor', 'date', 'start_time', 'end_time', 'actions'])
                ->make(true);
        } catch (Throwable $th) {
            dd($th->getMessage());
        }
    }

    public static function getTimetable()
    {
        $today = Carbon::today();

        // Check if today is a Monday
        if ($today->dayOfWeek === Carbon::MONDAY) {
            // If today is Monday, return today's date
            $closestPastMonday = $today;
        } else {
            // Find the date of the closest past Monday
            $closestPastMonday = $today->previous(Carbon::MONDAY)->format('Y:m:d');
        }

        // Check if today is a Monday
        if ($today->dayOfWeek === Carbon::SUNDAY) {
            // If today is Monday, return today's date
            $closestNextSunday = $today;
        } else {
            // Find the date of the closest past Monday
            $closestNextSunday = $today->next(Carbon::SUNDAY)->format('Y:m:d');
        }

        // dd($closestNextSunday);
        $lecturesThisWeek = Lecture::with('Course','ClassRoom','Tutor.User')->whereBetween('date', [$closestPastMonday, $closestNextSunday])->orderBy('start_time')->get();
        // dd($lecturesThisWeek);
        // $records = YourModel::whereBetween('date_column', [$startDate, $endDate])->get();
        $lecturesMonday = [];
        $lecturesTuesday = [];
        $lecturesWednesday = [];
        $lecturesThursday = [];
        $lecturesFriday = [];
        $lecturesSaturday = [];
        $lecturesSunday = [];

        foreach ($lecturesThisWeek as $lectureThisWeek) {
            $dateToCheck = Carbon::parse($lectureThisWeek->date); // Replace with your date

            if ($dateToCheck->isMonday()) {
                // It's Monday
                // echo "It's a Monday.";
                $lecturesMonday[] = $lectureThisWeek;
            } elseif ($dateToCheck->isTuesday()) {
                // It's Tuesday
                // echo "It's a Tuesday.";
                $lecturesTuesday[] = $lectureThisWeek;
            } elseif ($dateToCheck->isWednesday()) {
                // It's Wednesday
                // echo "It's a Wednesday.";
                $lecturesWednesday[] = $lectureThisWeek;
            } elseif ($dateToCheck->isThursday()) {
                // It's Thursday
                // echo "It's a Thursday.";
                $lecturesThursday[] = $lectureThisWeek;
            } elseif ($dateToCheck->isFriday()) {
                // It's Friday
                // echo "It's a Friday.";
                $lecturesFriday[] = $lectureThisWeek;
            } elseif ($dateToCheck->isSaturday()) {
                // It's Saturday
                // echo "It's a Saturday.";
                $lecturesSaturday[] = $lectureThisWeek;
            } elseif ($dateToCheck->isSunday()) {
                // It's Sunday
                // echo "It's a Sunday.";
                $lecturesSunday[] = $lectureThisWeek;
            } else {
                // It's not a valid day of the week
                // echo "Invalid day of the week.";
            }
        }
        // dd(
        //     $lecturesMonday,
        //     $lecturesTuesday,
        //     $lecturesWednesday,
        //     $lecturesThursday,
        //     $lecturesFriday,
        //     $lecturesSaturday,
        //     $lecturesSunday,
        // );

        $collectionTime=[];
        $count = 0;
        // dd("asasasasas");
        while (true) {
            // $lec = (object)[
            //     'Monday'=>$lecturesMonday[$count] ? $lecturesMonday[$count] :"",
            //     'Tuesday'=>$lecturesTuesday[$count] ? $lecturesTuesday[$count] : "",
            //     'Wednesday'=>$lecturesWednesday[$count] ? $lecturesWednesday[$count] : "",
            //     'Thursday'=>$lecturesThursday[$count] ? $lecturesThursday[$count] : "",
            //     'Friday'=>$lecturesFriday[$count] ? $lecturesFriday[$count] : "",
            //     'Saturday'=>$lecturesSaturday[$count] ? $lecturesSaturday[$count] : "",
            //     'Sunday'=>$lecturesSunday[$count] ? $lecturesSunday[$count] : "",
            // ];
            $lec = (object) [
                'Monday'    => isset($lecturesMonday[$count]) ? $lecturesMonday[$count] : "",
                'Tuesday'   => isset($lecturesTuesday[$count]) ? $lecturesTuesday[$count] : "",
                'Wednesday' => isset($lecturesWednesday[$count]) ? $lecturesWednesday[$count] : "",
                'Thursday'  => isset($lecturesThursday[$count]) ? $lecturesThursday[$count] : "",
                'Friday'    => isset($lecturesFriday[$count]) ? $lecturesFriday[$count] : "",
                'Saturday'  => isset($lecturesSaturday[$count]) ? $lecturesSaturday[$count] : "",
                'Sunday'    => isset($lecturesSunday[$count]) ? $lecturesSunday[$count] : "",
            ];
            
            $collectionTime[]=$lec;
            // dd($collectionTime);

            // unset($lecturesMonday[$count]);
            // unset($lecturesTuesday[$count]);
            // unset ($lecturesWednesday[$count]);
            // unset ($lecturesThursday[$count]);
            // unset ($lecturesFriday[$count]);
            // unset ($lecturesSaturday[$count]);
            // unset ($lecturesSunday[$count]);

            if (isset($lecturesMonday[$count])) {
                unset($lecturesMonday[$count]);
            }
            if (isset($lecturesTuesday[$count])) {
                unset($lecturesTuesday[$count]);
            }
            if (isset($lecturesWednesday[$count])) {
                unset($lecturesWednesday[$count]);
            }
            if (isset($lecturesThursday[$count])) {
                unset($lecturesThursday[$count]);
            }
            if (isset($lecturesFriday[$count])) {
                unset($lecturesFriday[$count]);
            }
            if (isset($lecturesSaturday[$count])) {
                unset($lecturesSaturday[$count]);
            }
            if (isset($lecturesSunday[$count])) {
                unset($lecturesSunday[$count]);
            }
            
            // dd($lecturesSaturday);
$breakLoop=false;
            if (empty($lecturesMonday) && empty($lecturesTuesday) && empty($lecturesWednesday) && empty($lecturesThursday) && empty($lecturesFriday) && empty($lecturesSaturday) && empty($lecturesSunday)) {
                $breakLoop = true;
                // break;
            }
            if($breakLoop){
                break;
            }
            $count++;
        }
    //   dd($collectionTime);
    return collect($collectionTime);

    }
}
