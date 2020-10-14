<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    public function members(){
        return $this->belongsToMany("App\Models\User", "project_user", "project_id", "user_id")->withPivot("type");
    }

    public function client(){
        return $this->belongsTo("App\Models\Client", "client_id");
    }
}
