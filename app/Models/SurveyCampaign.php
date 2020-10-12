<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyCampaign extends Model
{
    use HasFactory;

    protected $with = ["emails"];

    public function mailing_lists(){
        return $this->hasMany("App\Models\SurveyCompaignMailingList", "survey_compaign_id");
    }

    public function emails(){
        return $this->hasMany("App\Models\SurveyCompaignEmail", "survey_compaign_id");
    }

    public function complete_emails(){
        return $this->hasMany("App\Models\SurveyCompaignEmail", "survey_compaign_id")->where("status", 2);
    }
}
