<?php

namespace App\Http\Controllers;

use App\Models\ClientGroup;
use App\Models\ContactGroup;
use App\Models\CustomField;
use App\Models\Sector;
use App\Models\User;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Role;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class Settings extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    // General Settings

    public function index()
    {
        return redirect()->route("settings.general_settings");
        return Inertia::render("company/settings/index");
    }

    public function general_settings(){
        $settings = Setting::all()->keyBy("key");
        return Inertia::render("company/settings/general_settings", ["settings" => $settings]);
    }

    public function general_settings_save(Request $request)
    {
        foreach ($request->all() as $k => $v) {
            if($k == "logo")
                $v = $request->logo->store("uploads");
            if($k == "login_page_image")
                $v = $request->login_page_image->store("uploads");
            $this->save_s($k, $v);
        }
        return back()->with("success", __("l.Data Saved Successfully"));
    }

    protected function save_s($k, $v)
    {
        $setting = Setting::where("key", $k)->first();
        if (!$setting) {
            $setting = new Setting;
            $setting->key = $k;
        }
        $setting->value = $v;
        $setting->save();
    }

    // SMTP

    public function smtp_settings(){
        $settings = Setting::all()->keyBy("key");
        return Inertia::render("company/settings/smtp_settings", ["settings" => $settings ]);
    }

    public function smtp_settings_save(Request  $request){
        foreach ($request->except("_token") as $k => $v){
            $this->save_s($k, $v);
        }
        if($request->smtp_test_email != ""){
            $csetting = Setting::where("key", "app_name")->first();
            $app_name = ($csetting) ? $csetting->value : "SimpleERP";
            mailit($request->smtp_test_email, __("l.TEST MAIL"), __('l.This is a test mail from'). ' "'.$app_name .'".', "Settings", null, $request->smtp_username);
        }
        return back()->with("success", __("l.Data Saved Successfully"));
    }

    // Roles & Permissions

    public function roles()
    {
        $roles = Role::orderby("created_at", "desc")->get();
        return Inertia::render("company/settings/roles", ["roles" => $roles]);
    }

    public function roles_save(Request $request)
    {
        if($request->id)
            $role   = Role::find($request->id);
        else
            $role   = new Role;
        $role->name = $request->name;
        $role->save();
        return back()->with("success", __("l.Data Saved Successfully"));
    }

    public function roles_delete($id = null){
        if($id == 1)
            return;
        $role       = Role::find($id);
        if(!$role)
            return back();

        $role->delete();
        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    // Designations

    public function designations(){
        $designations   = Designation::orderby("created_at", "desc")->get();
        return Inertia::render("company/settings/designations", ["designations" => $designations]);
    }

    public function designations_save(Request $request){
        $designation               = new Designation;
        if($request->id){
            $designation       = Designation::find($request->id);
            if(!$designation)
                return back();
        }
        $designation->name         = $request->name;
        $designation->dsecription  = $request->dsecription;
        $designation->save();

        return back()->with("success", __("l.Data Saved Successfully"));
    }

    public function designations_delete($id = null){
        $designation       = Designation::find($id);
        if(!$designation)
            return back();

        $designation->delete();
        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    // Departments

    public function departments(){
        $departments        = Department::orderby("created_at", "desc")->get();
        $departments_json   = $this->get_departments();
        $users              = User::orderby("created_at", "desc")->get();
        return Inertia::render("company/settings/departments", [
            "departments" => $departments,
            "departments_json" => $departments_json,
            "users" => $users
        ]);
    }

    protected function get_departments(){
        $departments    = Department::where("parent_id", null)->orderby("created_at", "desc")->get();
        $csetting = Setting::where("key", "app_name")->first();
        $app_name = ($csetting) ? $csetting->value : "SimpleERP";
        $result = ['id'=> 0, 'name'=> $app_name, 'title'=> 'general manager','children'=> $this->deps($departments)];
        return $result;
    }

    protected function deps($departments){
        $deps = [];
        foreach ($departments as $department){
            $children = count($department->departments)>0 ? $this->deps($department->departments) : [];
            $dep = ['id'=> $department->id, 'name'=> $department->name, 'title'=> "aaa", "children"=> $children];
            array_push($deps, $dep);
        }
        return $deps;
    }

    public function departments_save(Request $request){
        $request->validate(["name" => "required"]);
        $department                 = new Department;
        $department->name           = $request->name;
        $department->dsecription    = $request->dsecription;
        $department->parent_id      = $request->parent_id;
        $department->manager_id     = $request->manager_id;
        $department->save();

        return back()->with("success", __("l.Data Saved Successfully"));
    }

    public function departments_update(Request $request){
        $department       = Department::find($request->id);
        if(!$department)
            return back();

        $department->name           = $request->name;
        $department->dsecription    = $request->dsecription;
        $department->parent_id      = $request->parent_id;
        $department->manager_id     = $request->manager_id;
        $department->save();

        return back()->with("success", __("l.Data Saved Successfully"));
    }

    public function departments_delete($id = null){
        $department       = Department::find($id);
        if(!$department)
            return back();

        $this->departments_delete_recursive($department);

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    protected function departments_delete_recursive($department){
        if(count($department->departments)>0)
            foreach ($department->departments as $dep){
                $this->departments_delete_recursive($dep);
            }
        $department->delete();
    }

    // Sectors

    public function sectors(){
        $sectors = Sector::orderby("created_at", "desc")->get();
        return Inertia::render("company/settings/sectors", ["sectors" => $sectors, "main_sectors" => main_sectors()]);
    }

    public function sectors_save(Request $request){
        $request->validate(["name" => "required", "sector" => "required"]);
        $sector             = new Sector;
        $sector->name       = $request->name;
        $sector->sector     = $request->sector;
        $sector->save();

        return back()->with("success", __("l.Data Saved Successfully"));
    }

    public function sectors_delete($id = null){
        $sector             = Sector::find($id);
        if(!$sector)
            return back();

        $sector->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function sectors_update(Request $request){
        $sector             = Sector::find($request->id);
        if(!$sector)
            return back();

        $sector->name       = $request->name;
        $sector->sector     = $request->sector;
        $sector->save();

        return back()->with("success", __("l.Data Saved Successfully"));
    }

    // Client Groups

    public function client_groups(){
        $client_groups  = ClientGroup::orderby("created_at", "desc")->get();
        return Inertia::render("company/settings/client_groups", ["client_groups" => $client_groups,]);
    }

    public function client_groups_save(Request $request){
        $request->validate(["name" => "required"]);
        $client_group               = new ClientGroup;
        $client_group->name         = $request->name;
        $client_group->save();

        return back()->with("success", __("l.Data Saved Successfully"));
    }

    public function client_groups_delete($id = null){
        $client_group       = ClientGroup::find($id);
        if(!$client_group)
            return back();

        $client_group->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function client_groups_update(Request $request){
        $client_group       = ClientGroup::find($request->id);
        if(!$client_group)
            return back();

        $client_group->name         = $request->name;
        $client_group->save();

        return back()->with("success", __("l.Data Saved Successfully"));
    }

    // Contact Groups

    public function contact_groups(){
        $contact_groups  = ContactGroup::orderby("created_at", "desc")->get();
        return Inertia::render("company/settings/contact_groups", compact("contact_groups"));
    }

    public function contact_groups_save(Request $request){
        $request->validate(["name" => "required"]);
        $contact_group               = new ContactGroup;
        $contact_group->name         = $request->name;
        $contact_group->save();

        return back()->with("success", __("l.Data Saved Successfully"));
    }

    public function contact_groups_delete($id = null){
        $contact_group       = ContactGroup::find($id);
        if(!$contact_group)
            return back();

        $contact_group->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function contact_groups_update(Request $request){
        $contact_group       = ContactGroup::find($request->id);
        if(!$contact_group)
            return back();

        $contact_group->name         = $request->name;
        $contact_group->save();

        return back()->with("success", __("l.Data Saved Successfully"));
    }

    // Custom Fields

    public function custom_fields(){
        $custom_fields  = CustomField::orderby("created_at", "desc")->get();
        return Inertia::render("company/settings/custom_fields", compact("custom_fields"));
    }


}
