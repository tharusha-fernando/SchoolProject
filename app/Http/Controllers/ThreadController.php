<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Http\Requests\StoreThreadRequest;
use App\Http\Requests\UpdateThreadRequest;
use App\Models\Lecture;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return view('threads.mythreads');

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
    public function store(StoreThreadRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Lecture $lecture)
    {
        // dd("asasasa");
        $lecture->load('Thread.Message.User');
        if(!$lecture->Thread){
            Thread::create(['lecture_id'=>$lecture->id]);
            $lecture->load('Thread.Message.User');
        }
        $thread=$lecture->Thread;
        // return $lecture;

        return view('threads.index',compact('thread'));

        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateThreadRequest $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Thread $thread)
    {
        //
    }

    
    public function getData(Request $request)
    {
        try {
            $threads = Thread::query()
                ->with('Message','Lecture.Course.Student','Lecture.Tutor')
                ->when(auth()->user()->hasRole('student'), function ($query) {
                    $query->whereHas('Lecture.Course.Student', function ($query2) {
                        $query2->where('user_id', auth()->user()->id);
                    });
                })
                ->when(auth()->user()->hasRole('tutor'), function ($query) {
                    $query->whereHas('Lecture.Tutor', function ($query2) {
                        $query2->where('user_id', auth()->user()->id);
                    });
                })
                ->orderBy('created_at', 'desc');

            return DataTables::of($threads)
                ->addColumn('course_name', function ($thread) {
                    return $thread->Lecture->Course->course_name;
                })->addColumn('lecture_date', function ($thread) {
                    return $thread->Lecture->created_at;
                })
    
                ->addColumn('actions', function ($thread) {
                    $route = route('threads.show', ['lecture' => $thread->Lecture->id]);
                    $htmlContent = '
                        <a rel="tooltip" class="btn btn-success btn-link" href="' . $route . '" data-original-title="" title="">
                            <i class="material-icons">visibility</i>
                            <div class="ripple-container"></div>
                        </a>
                        
                    ';
                
                    return $htmlContent;
                })
                
                ->rawColumns(['course_name', 'lecture_date','actions'])
                ->make(true);
        } catch (Throwable $th) {
            dd($th->getMessage());
        }
    }
}
