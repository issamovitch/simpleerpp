<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $with = ["departments", "manager"];

    public function department(){
        return $this->belongsTo(\App\Models\Department::class, "parent_id");
    }

    public function departments(){
        return $this->hasMany(\App\Models\Department::class, "parent_id");
    }

    public function manager(){
        return $this->belongsTo(\App\Models\User::class, "manager_id");
    }
}
