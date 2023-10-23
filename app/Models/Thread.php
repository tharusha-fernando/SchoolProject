<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;
    protected $fillable = [
        'lecture_id',
    ];

    public function Lecture(){
        return $this->belongsTo(Lecture::class);
    }

    public function Message(){
        return $this->hasMany(Message::class,'thread_id');
    }

    
}
