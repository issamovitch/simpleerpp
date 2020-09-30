<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Designation;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class Users extends BaseController
{
    public function __construct(){
        parent::__construct();
    }

    public function index()
    {
        $users          = User::with("role", "designation")->orderby("created_at", "desc")->get();
        $roles          = Role::orderby("created_at", "desc")->get();
        $designations   = Designation::orderby("created_at", "desc")->get();
        $departments    = Department::orderby("created_at", "desc")->get();
        return Inertia::render("company/users/index", ["users" => $users, "roles" => $roles, "designations" => $designations, "departments" => $departments]);
    }

    public function add(){
        $roles          = Role::orderby("created_at", "desc")->get();
        $designations   = Designation::orderby("created_at", "desc")->get();
        $users          = User::with("role", "designation")->orderby("created_at", "desc")->get();
        $departments    = Department::orderby("created_at", "desc")->get();
        return Inertia::render("company/users/add",
            [
                "users" => $users,
                "roles" => $roles,
                "designations" => $designations,
                "departments" => $departments,
            ]);
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

        return $designation;
    }

    public function departments_save(Request $request){
        $request->validate(["name" => "required"]);
        $department                 = new Department;
        $department->name           = $request->name;
        $department->dsecription    = $request->dsecription;
        $department->parent_id      = $request->parent_id;
        $department->manager_id     = $request->manager_id;
        $department->save();

        return $department;
    }

    public function save(Request $request){
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
            "role_id" => "required",
        ]);
        $user                   = new User;
        $user->name             = $request->name;
        $user->email            = $request->email;
        $user->password         = bcrypt($request->password);
        $user->role_id          = $request->role_id;
        $user->designation_id   = $request->designation_id;
        $user->department_id    = $request->department_id;
        $user->manager_id       = $request->manager_id;
        $user->workplace        = $request->workplace;
        $user->phone            = $request->phone;
        $user->mobile           = $request->mobile;
        $user->emergency_contact = $request->emergency_contact;
        $user->gender           = $request->gender;
        $user->civil_status     = $request->civil_status;
        $user->number_of_children = $request->number_of_children;
        $user->nationality      = $request->nationality;
        $user->num_identification = $request->num_identification;
        $user->num_passport     = $request->num_passport;
        $user->date_of_birth    = $request->date_of_birth;
        $user->place_of_birth   = $request->place_of_birth;
        $user->native_country   = $request->native_country;
        $user->certificate_level = $request->certificate_level;
        $user->field_of_study   = $request->field_of_study;
        $user->university       = $request->university;
        if($request->hasFile("image")){
            $request->validate(["image" => "image"]);
            $user->image        = $request->image->store("uploads");
        }
        $user->save();

        return redirect()->route("users.index")->with("success", __("l.Data Added Successfully"));
    }

    public function view($id = null){
        $user = User::with("role", "designation", "department", "manager")->find($id);
        if (!$user)
            return back();

        return Inertia::render("company/users/view", ["user" => $user]);
    }

    public function edit($id = null){
        $user = User::with("role", "designation", "department", "manager")->find($id);
        if (!$user)
            return back();

        $roles          = Role::orderby("created_at", "desc")->get();
        $designations   = Designation::orderby("created_at", "desc")->get();
        $users          = User::with("role", "designation")->orderby("created_at", "desc")->get();
        $departments    = Department::orderby("created_at", "desc")->get();
        return Inertia::render("company/users/edit",
            [
                "user" => $user,
                "users" => $users,
                "roles" => $roles,
                "designations" => $designations,
                "departments" => $departments,
            ]);
    }

    public function update(Request $request){
        $user = User::find($request->id);
        if (!$user)
            return back();

        $request->validate([
            "name" => "required",
            "email" => "required|unique:users,email,".$request->id,
            "role_id" => "required",
        ]);
        $user->name             = $request->name;
        $user->email            = $request->email;
        if($request->password and $request->password!="")
            $user->password     = bcrypt($request->password);
        $user->role_id          = $request->role_id;
        $user->designation_id   = $request->designation_id;
        $user->department_id    = $request->department_id;
        $user->manager_id       = $request->manager_id;
        $user->workplace        = $request->workplace;
        $user->phone            = $request->phone;
        $user->mobile           = $request->mobile;
        $user->emergency_contact = $request->emergency_contact;
        $user->gender           = $request->gender;
        $user->civil_status     = $request->civil_status;
        $user->number_of_children = $request->number_of_children;
        $user->nationality      = $request->nationality;
        $user->num_identification = $request->num_identification;
        $user->num_passport     = $request->num_passport;
        $user->date_of_birth    = $request->date_of_birth;
        $user->place_of_birth   = $request->place_of_birth;
        $user->native_country   = $request->native_country;
        $user->certificate_level = $request->certificate_level;
        $user->field_of_study   = $request->field_of_study;
        $user->university       = $request->university;
        if($request->hasFile("image")){
            $request->validate(["image" => "image"]);
            if($user->image and is_file(storage_path("app/". $user->image)))
                unlink(storage_path("app/". $user->image));
            $user->image        = $request->image->store("uploads");
        }
        $user->save();

        return redirect()->route("users.index")->with("success", __("l.Data Updated Successfully"));
    }

    public function delete($id = null){
        $user = User::find($id);
        if (!$user)
            return back();

        if($user->image and file_exists(storage_path("app/".$user->image)) and is_file(storage_path("app/".$user->image)))
            unlink(storage_path("app/".$user->image));

        $user->delete();

        return redirect()->route("users.index")->with("success", __("l.Data Deleted Successfully"));
    }
}
