<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tutors extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender',
        'dob',
        'pronounce',
        'address',
        'tp',
    ];
    
    public function User(){
        return $this->belongsTo(User::class);
    }
    
    public function Course(){
        return $this->belongsToMany(Course::class,'course_tutor','tutor_id','course_id');
    }
}
