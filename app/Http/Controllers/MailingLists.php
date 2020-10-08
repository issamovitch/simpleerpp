<?php

namespace App\Http\Controllers;

use App\Models\MailingList;
use App\Models\MailingListEmail;
use App\Models\MailingListEmailValue;
use App\Models\MailingListField;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Auth;

class MailingLists extends BaseController
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $lists = MailingList::with("fields")->orderby("created_at", "desc")->get();

        return Inertia::render("company/mailing_lists/index", compact("lists"));
    }

    public function save(Request $request){
        $list                           = new MailingList;
        $list->name                     = $request->name;
        $list->save();
        $this->save_field($request, $list->id);

        return back()->with("success", __("l.Data Added Successfully"));
    }

    public function update(Request $request){
        $list                       = MailingList::find($request->id);
        if(!$list)
            return back();

        $list->name                 = $request->name;
        $list->save();
        $this->save_field($request, $list->id);

        return back()->with("success", __("l.Data Updated Successfully"));
    }

    protected  function save_field($request, $list_id){
        foreach ($request->all() as $k => $v) {
            if (strpos($k, "new_field_") !== false) {
                $field = new MailingListField;
                $field->mailing_list_id = $list_id;
                $field->name = $v;
                $field->save();
            }
        }
        foreach ($request->all() as $k => $v) {
            if (strpos($k, "old_field_") !== false) {
                $id = str_replace("old_field_", "", $k);
                $field = MailingListField::find($id);
                if($field){
                    $field->mailing_list_id = $list_id;
                    $field->name = $v;
                    $field->save();
                }
            }
        }
    }

    public function delete_field($id = null){
        $field = MailingListField::find($id);
        if($field)
            $field->delete();
        MailingListEmailValue::where("mailing_list_field_id", $id)->delete();
    }

    public function delete($id = null){
        $list   = MailingList::with("fields")->find($id);
        if(!$list)
            return back();

        $list->delete();

        MailingListField::where("mailing_list_id", $id)->delete();
        MailingListEmailValue::where("mailing_list_id", $id)->delete();
        MailingListEmail::where("mailing_list_id", $id)->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function view($id = null){
        $list   = MailingList::with("fields", "emails")->find($id);
        if(!$list)
            return back();

        return Inertia::render("company/mailing_lists/view", compact("list"));
    }

    public function save_email(Request $request){
        $list                       = MailingList::find($request->mailing_list_id);
        if(!$list)
            return back();
        $email                      = new MailingListEmail;
        $email->mailing_list_id     = $list->id;
        $email->email               = $request->email;
        $email->save();

        $this->save_value($request, $list->id, $email->id);

        return back()->with("success", __("l.Data Added Successfully"));
    }

    public function update_email(Request $request){
        $list                       = MailingList::find($request->mailing_list_id);
        if(!$list)
            return back();
        $email                      = MailingListEmail::find($request->id);
        if(!$email)
            return back();
        $email->mailing_list_id     = $list->id;
        $email->email               = $request->email;
        $email->save();

        MailingListEmailValue::where("mailing_list_email_id", $email->id)->delete();
        $this->save_value($request, $list->id, $email->id);

        return back()->with("success", __("l.Data Added Successfully"));
    }

    public function delete_email($id = null){
        $email   = MailingListEmail::find($id);
        if(!$email)
            return back();

        $email->delete();

        MailingListEmailValue::where("mailing_list_email_id", $id)->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    protected function save_value($request, $list_id, $email_id){
        foreach ($request->all() as $k => $v) {
            if (strpos($k, "field_") !== false) {
                $id = str_replace("field_", "", $k);
                $value = new MailingListEmailValue;
                $value->mailing_list_id = $list_id;
                $value->mailing_list_field_id = $id;
                $value->mailing_list_email_id = $email_id;
                $value->value = $v;
                $value->save();
            }
        }
    }

}
