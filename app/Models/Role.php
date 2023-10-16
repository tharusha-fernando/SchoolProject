<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];


    public function User(){
        return $this->belongsToMany(Role::class,'users_roles','role_id','user_id');
    }
}
