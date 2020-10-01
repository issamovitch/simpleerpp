<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public function group(){
        return $this->belongsTo(\App\Models\ClientGroup::class, "client_group_id");
    }

    public function company(){
        return $this->belongsTo(\App\Models\Client::class, "company");
    }

    public function sector(){
        return $this->belongsTo(\App\Models\Sector::class, "sector_id");
    }
}
