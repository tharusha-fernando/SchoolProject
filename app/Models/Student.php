<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
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

}
