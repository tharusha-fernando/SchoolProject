<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'user_id',
        'message'
    ];

    
    public function Thread(){
        return $this->belongsTo(Thread::class);
    }

    public function User(){
        return $this->belongsTo(User::class);
    }
}
