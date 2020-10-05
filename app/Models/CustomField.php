<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomField extends Model
{
    use HasFactory;

    public function group(){
        return $this->belongsTo(\App\Models\ContactGroup::class, "group_id");
    }

    public function getOptionsAttribute($options)
    {
        return ($options and $options!="")? explode(",", $options) : $options;
    }

    public function getRequiredAttribute($required)
    {
        return ($required and $required==1)? true : false;
    }
}
