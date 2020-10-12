<?php

namespace App\Http\Controllers;

use App\Models\MailingList;
use App\Models\MailingListEmail;
use App\Models\MailingListEmailValue;
use App\Models\MailingListField;
use App\Models\Survey;
use App\Models\SurveyAnswer;
use App\Models\SurveyCampaign;
use App\Models\SurveyCompaignEmail;
use App\Models\SurveyCompaignMailingList;
use App\Models\SurveyParticipant;
use App\Models\SurveyQuestion;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Auth;

class Surveys extends BaseController
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $surveys = Survey::withCount("participants")->withCount("in_progress_campaigns")->withCount("questions")->orderby("created_at", "desc")->get();
        return Inertia::render("company/surveys/index", compact("surveys"));
    }

    public function add(){
        $lists = MailingList::with("fields")->orderby("created_at", "desc")->get();
        return Inertia::render("company/surveys/add", compact("lists"));
    }

    public function save(Request $request){
        $survey                     = new Survey;
        $survey->name               = $request->name;
        $survey->short_description  = $request->short_description;
        $survey->email_description  = $request->email_description;
        $survey->from               = $request->from;
        $survey->save();

        return redirect()->route("surveys.index")->with("success", __("l.Data Added Successfully"));
    }

    public function edit($id = null){
        $survey = Survey::find($id);
        if(!$survey)
            return back();

        $lists  = MailingList::with("fields")->orderby("created_at", "desc")->get();
        return Inertia::render("company/surveys/edit", compact("lists", "survey"));
    }

    public function update(Request $request){
        $survey = Survey::find($request->id);
        if(!$survey)
            return back();

        $survey->name               = $request->name;
        $survey->short_description  = $request->short_description;
        $survey->email_description  = $request->email_description;
        $survey->from               = $request->from;
        $survey->save();

        return back()->with("success", __("l.Data Updated Successfully"));
    }

    public function status($id = null, $status = 1){
        $survey = Survey::find($id);
        if(!$survey)
            return back();

        $survey->status              = $status;
        $survey->save();

        return back()->with("success", __("l.Data Updated Successfully"));
    }

    public function delete($id = null){
        $survey = Survey::find($id);
        if(!$survey)
            return back();

        SurveyAnswer::where("survey_id", $id)->delete();
        SurveyCampaign::where("survey_id", $id)->delete();
        SurveyCompaignMailingList::where("survey_id", $id)->delete();
        SurveyCompaignEmail::where("survey_id", $id)->delete();
        SurveyParticipant::where("survey_id", $id)->delete();

        $survey->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function details($id = null){
        $survey = Survey::withCount("in_progress_campaigns")->with("questions", "answers", "campaigns.mailing_lists")->find($id);
        if(!$survey)
            return back();

        $lists  = MailingList::withCount("emails")->with("fields")->orderby("created_at", "desc")->get();
        return Inertia::render("company/surveys/details", compact("lists", "survey"));
    }

    public function save_question(Request $request){
        $survey                 = Survey::find($request->id);
        if(!$survey)
            return back();

        $num                    = SurveyQuestion::where("survey_id", $request->id)->count();
        $question               = new SurveyQuestion;
        $question->order        = $num+1;
        $question->survey_id    = $request->id;
        $question->type         = $request->type;
        $question->options      = "";
        $question->save();

        return back()->with("success", __("l.Data Added Successfully"));
    }

    public function delete_question($id = null){
        $question   = SurveyQuestion::find($id);
        if(!$question)
            return back();

        SurveyAnswer::where("survey_question_id", $id)->delete();

        $question->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function update_question(Request $request){
        $question   = SurveyQuestion::find($request->id);
        if(!$question)
            return back();
        $question->question = $request->question;
        $question->options = ($request->options) ? implode(",", $request->options) : null;
        $question->required = $request->required;
        $question->save();

        return back()->with("success", __("l.Data Updated Successfully"));
    }

    public function change_questions_order(Request $request){
        foreach ($request->all() as $q){
            if(is_array($q)){
                $question               = SurveyQuestion::find($q["id"]);
                if($question){
                    $question->order    = $q["order"];
                    $question->save();
                }
            }
        }
    }

    public function submit_campaign(Request $request){
        $survey                                         = Survey::find($request->survey_id);
        if(!$survey)
            return back();

        $campaign                                       = new SurveyCampaign;
        $campaign->survey_id                            = $survey->id;
        $campaign->status                               = 0;
        $campaign->progress                             = 0;
        $campaign->save();

        foreach ($request->except("survey_id") as $k=>$v){
            if (strpos($k, "list_") !== false) {
                $id                                     = str_replace("list_", "", $k);
                $mailing_list                           = MailingList::with("emails")->find($id);
                if($mailing_list){
                    $campaign_ml                        = new SurveyCompaignMailingList;
                    $campaign_ml->survey_id             = $survey->id;
                    $campaign_ml->survey_compaign_id    = $campaign->id;
                    $campaign_ml->mailing_list_id       = $mailing_list->id;
                    $campaign_ml->save();
                    foreach ($mailing_list->emails as $em){
                        $email                          = new SurveyCompaignEmail;
                        $email->survey_id               = $survey->id;
                        $email->survey_compaign_id      = $campaign->id;
                        $email->mailing_list_email_id   = $em->id;
                        $email->email                   = $em->email;
                        $email->status                  = 0;
                        $email->save();
                    }
                }
            }
        }

        return back()->with("success", __("l.Data Added Successfully"));
    }

    public function delete_campaign($id = null){
        $campaign   = SurveyCampaign::find($id);
        if(!$campaign)
            return back();

        SurveyCompaignMailingList::where("survey_compaign_id", $id)->delete();
        SurveyCompaignEmail::where("survey_compaign_id", $id)->delete();

        $campaign->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function send_email($id = null){
        $email   = SurveyCompaignEmail::with("Email.valuesNotKeyed", "survey")->find($id);
        if(!$email)
            return back();

        $email->status = 2;
        $email->save();

        $campaign = SurveyCampaign::with("mailing_lists")->withCount("emails")->withCount("complete_emails")->find($email->survey_compaign_id);
        $campaign->status = 1;
        $campaign->progress = floor($campaign->complete_emails_count/$campaign->emails_count*100);
        if($campaign->progress == 100)
            $campaign->status = 2;
        $campaign->save();

        //
        $data = ["{survey_link}" => route('survey.survey', @$email->survey->id)];
        foreach ($campaign->mailing_lists as $mailing_list)
            if($mailing_list->mailing_list)
                if(count(@$mailing_list->mailing_list->fields)>0){
                    foreach (@$mailing_list->mailing_list->fields as $field){
                        $data["{".$field->name."}"] = "";
                    }
                }
        if($email->Email)
            if(count(@$email->Email->valuesNotKeyed)>0)
                foreach (@$email->Email->valuesNotKeyed as $v){
                    if($v->field){
                        if(array_key_exists("{".@$v->field->name."}", $data)){
                            $data["{".@$v->field->name."}"] = $v->value;
                        }
                    }
                }
        $text = $this->parse_email($data, @$email->survey->email_description);
        mailit($email->email, __("l.Survey")." \"".@$email->survey->name." \"",
            $text,  "Surveys", null, @$email->survey->from);

        return response()->json(["email" => $email, "campaign"=> $campaign]);
    }

    protected function parse_email($data, $text){
        foreach ($data as $k=>$v)
            $text = str_replace($k, $v, $text);
        return $text;
    }

}
