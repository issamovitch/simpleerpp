<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KBGroup extends Model
{
    use HasFactory;

    public function articles(){
        return $this->hasMany("App\Models\KBArticle", "group_id");
    }
}
