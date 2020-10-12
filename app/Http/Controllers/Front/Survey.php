<?php

namespace App\Http\Controllers\Front;

use App\Models\Survey as SurveyO;
use App\Models\SurveyAnswer;
use App\Models\SurveyParticipant;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Inertia\Inertia;
use Redirect;

class Survey extends BaseController
{

    public function __construct(){
        parent::__construct();
    }

    public function survey($id = null){
        $survey = SurveyO::whereIn("status", [1, 2])->with("questions")->find($id);
        if(!$survey)
            return abort(404);

        return Inertia::render("front/surveys/index", compact("survey"));
    }

    public function save_survey(Request $request){
        $survey                         = SurveyO::whereIn("status", [1, 2])->with("questions")->find($request->survey_id);
        if(!$survey)
            return abort(404);

        $survey_participant = new SurveyParticipant;
        $survey_participant->survey_id = $survey->id;
        $survey_participant->save();

        foreach($survey->questions as $question){
            $answer                     = new SurveyAnswer;
            $answer->survey_id          = $request->survey_id;
            $answer->survey_question_id = $question->id;
            $value = "";
            foreach ($request->all() as $k=>$v) {
                if (strpos($k, "answer_") !== false) {
                    $id                 = str_replace("answer_", "", $k);
                    if($id == $question->id)
                        $value          = (is_array($v)) ? implode(";;;", $v) : $v;
                }
            }
            $answer->value              = $value;
            $answer->save();
        }

        $survey_thank_you_message = (@$this->settings["survey_thank_you_message"] and @$this->settings["survey_thank_you_message"]->value!="") ?
            @$this->settings["survey_thank_you_message"]->value :
            "Thank you for particpating in this sutrvey, your answer is very important to us.";

        return back()->with("success", $survey_thank_you_message);
    }

}
