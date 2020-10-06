<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\CustomField;
use App\Models\CustomValue;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Lang;

class Contacts extends BaseController{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $contacts = Contact::orderby("created_at", "desc")->get();

        return Inertia::render("company/contacts/index", compact("contacts"));
    }

    public function add(){
        $custom_fields  = CustomField::where("model", "Contact")->orderby("order", "asc")->get();
        return Inertia::render("company/contacts/add", compact("custom_fields"));
    }

    public function save(Request $request){
        $contact                = new Contact;
        $contact->name          = $request->name;
        $contact->job           = $request->job;
        $contact->about         = $request->about;
        $contact->address       = $request->address;
        $contact->phone         = $request->phone;
        $contact->email         = $request->email;
        if($request->hasFile("image")){
            $request->validate(["image" => "required"]);
            $contact->image = $request->image->store("image");
        }
        $contact->save();

        foreach ($request->all() as $k => $v){
            if (strpos($k, "field_") !== false) {
                $id                         = str_replace("field_", "", $k);
                $custom_value               = new CustomValue;
                $custom_value->field_id     = $id;
                $custom_value->contact_id    = $contact->id;
                $custom_value->value        = (is_array($v)) ? implode(",", $v) : $v;
                $custom_value->save();
            }
        }

        return redirect()->route("contacts.index")->with("success", __("l.Data Added Successfully"));
    }

    public function edit($id = null){
        $contact = Contact::find($id);
        if(!$contact)
            return back();

        $custom_fields  = CustomField::where("model", "Contact")->orderby("order", "asc")->get();
        foreach ($custom_fields as $custom_field){
            $custom_value = CustomValue::where(["field_id" => $custom_field->id, "contact_id" => $contact->id])->first();
            $value = @$custom_value->value;
            $custom_field->value = $value;
        }

        return Inertia::render("company/contacts/edit", compact("custom_fields", "contact"));
    }

    public function update(Request $request){
        $contact = Contact::find($request->id);
        if(!$contact)
            return back();

        $contact->name          = $request->name;
        $contact->job           = $request->job;
        $contact->about         = $request->about;
        $contact->address       = $request->address;
        $contact->phone         = $request->phone;
        $contact->email         = $request->email;
        if ($request->hasFile("image")){
            if($contact->image and is_file(storage_path("app/". $contact->image)))
                unlink(storage_path("app/". $contact->image));
            $contact->image      = $request->image->store("uploads");
        }
        $contact->save();

        CustomValue::where("contact_id", $contact->id)->delete();
        foreach ($request->all() as $k => $v){
            if (strpos($k, "field_") !== false) {
                $id                         = str_replace("field_", "", $k);
                $custom_value               = new CustomValue;
                $custom_value->field_id     = $id;
                $custom_value->contact_id    = $contact->id;
                $custom_value->value        = (is_array($v)) ? implode(",", $v) : $v;
                $custom_value->save();
            }
        }

        return redirect()->route("contacts.index")->with("success", __("l.Data Updated Successfully"));
    }

    public function delete($id = null){
        $contact = Contact::find($id);
        if(!$contact)
            return back();

        if($contact->image and is_file(storage_path("app/". $contact->image)))
            unlink(storage_path("app/". $contact->image));

        $contact->delete();
        CustomValue::where("contact_id", $contact->id)->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function view($id = null){
        $contact = Contact::find($id);
        if(!$contact)
            return back();

        $custom_fields  = CustomField::where("model", "Contact")->orderby("order", "asc")->get();
        foreach ($custom_fields as $custom_field){
            $custom_value = CustomValue::where(["field_id" => $custom_field->id, "contact_id" => $contact->id])->first();
            $value = @$custom_value->value;
            $custom_field->value = $value;
        }

        return Inertia::render("company/contacts/view", compact("custom_fields", "contact"));
    }

}
