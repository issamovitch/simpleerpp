<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KBArticle extends Model
{
    use HasFactory;

    public function group(){
        return $this->belongsTo("App\Models\KBGroup", "group_id");
    }
}
