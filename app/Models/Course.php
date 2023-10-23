<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
        'course_code',
        'course_name',
        'description',
    ];



    public function Student(){
        return $this->belongsToMany(Student::class,'course_studnet','course_id','student_id');
    }
}
