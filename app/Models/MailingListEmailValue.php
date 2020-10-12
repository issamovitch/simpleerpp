<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailingListEmailValue extends Model
{
    use HasFactory;

    public function field(){
        return $this->belongsTo("App\Models\MailingListField", "mailing_list_field_id");
    }
}
