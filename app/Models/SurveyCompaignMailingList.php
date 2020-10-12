<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyCompaignMailingList extends Model
{
    use HasFactory;

    protected $with = ["mailing_list"];

    public function mailing_list(){
        return $this->belongsTo("App\Models\MailingList", "mailing_list_id");
    }
}
