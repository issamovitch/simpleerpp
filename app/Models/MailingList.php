<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MailingList extends Model
{
    use HasFactory;

    public function fields(){
        return $this->hasMany("App\Models\MailingListField", "mailing_list_id");
    }

    public function emails(){
        return $this->hasMany("App\Models\MailingListEmail", "mailing_list_id");
    }
}
