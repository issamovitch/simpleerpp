<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    public function questions(){
        return $this->hasMany("App\Models\SurveyQuestion", "survey_id")->orderBy("order", "asc");
    }

    public function answers(){
        return $this->hasMany("App\Models\SurveyAnswer", "survey_id")->orderBy("created_at", "desc");
    }

    public function campaigns(){
        return $this->hasMany("App\Models\SurveyCampaign", "survey_id")->orderBy("created_at", "desc");
    }

    public function in_progress_campaigns(){
        return $this->hasMany("App\Models\SurveyCampaign", "survey_id")->where("status", 1);
    }

    public function participants(){
        return $this->hasMany("App\Models\SurveyParticipant", "survey_id");
    }
}
