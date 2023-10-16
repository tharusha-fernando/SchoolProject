<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'classroom_id',
        'tutor_id',
        'start_time',
        'end_time',
    ];


    public function Course(){
        return $this->belongsTo(Course::class);
    }

    public function ClassRoom(){
        return $this->belongsTo(ClassRoom::class);
    }

    public function Tutor(){
        return $this->belongsTo(Tutors::class);
    }

}
