<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyCompaignEmail extends Model
{
    use HasFactory;

    public function survey(){
        return $this->belongsTo("App\Models\Survey", "survey_id");
    }

    public function campaign(){
        return $this->belongsTo("App\Models\SurveyCampaign", "survey_compaign_id");
    }

    public function Email(){
        return $this->belongsTo("App\Models\MailingListEmail", "mailing_list_email_id");
    }
}
