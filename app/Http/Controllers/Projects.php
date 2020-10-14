<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Auth;

class Projects extends BaseController
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $projects = Project::with("members", "client")->orderby("created_at", "desc")->get();
        $clients = Client::orderby("created_at", "desc")->get();
        $users   = User::orderby("created_at", "desc")->get();

        return Inertia::render("company/projects/index", compact("projects", "clients", "users"));
    }

    public function add(){
        $clients = Client::orderby("created_at", "desc")->get();
        $users   = User::orderby("created_at", "desc")->get();

        return Inertia::render("company/projects/add", compact("clients", "users"));
    }

    public function save(Request $request){
        $request->validate(["name" => "required", "members" => "required"]);

        $project                    = new Project;
        $project->name              = $request->name;
        $project->client_id         = $request->client_id;
        $project->progress_tasks    = $request->progress_tasks;
        $project->progress          = $request->progress;
        $project->description       = $request->description;
        $project->start_date        = $request->start_date;
        $project->deadline          = $request->deadline;
        $project->status            = $request->status;
        $project->billing_type      = $request->billing_type;
        $project->fixed_rate        = $request->fixed_rate;
        $project->rate_per_hour     = $request->rate_per_hour;
        $project->labels            = ($request->labels and is_array($request->labels) and count($request->labels)>0) ? implode(";;;", $request->labels): "";
        $project->save();

        foreach ($request->members as $user_id)
            $project->members()->attach($user_id);

        return redirect()->route("projects.index")->with("success", __("l.Data Added Successfully"));
    }

    public function delete($id = null){
        $project = Project::find($id);
        if(!$project)
            return back();

        $project->members()->detach();
        $project->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function edit($id = null){
        $project = Project::with("members")->find($id);
        if(!$project)
            return back();

        $members = $project->members;
        $clients = Client::orderby("created_at", "desc")->get();
        $users   = User::orderby("created_at", "desc")->get();

        return Inertia::render("company/projects/edit", compact("project", "members", "clients", "users"));
    }

    public function update(Request $request){
        $project = Project::find($request->id);
        if(!$project)
            return back();

        $request->validate(["name" => "required", "members" => "required"]);

        $project->name              = $request->name;
        $project->client_id         = $request->client_id;
        $project->progress_tasks    = $request->progress_tasks;
        $project->progress          = $request->progress;
        $project->description       = $request->description;
        $project->start_date        = $request->start_date;
        $project->deadline          = $request->deadline;
        $project->status            = $request->status;
        $project->billing_type      = $request->billing_type;
        $project->fixed_rate        = $request->fixed_rate;
        $project->rate_per_hour     = $request->rate_per_hour;
        $project->labels            = ($request->labels and is_array($request->labels) and count($request->labels)>0) ? implode(";;;", $request->labels): "";
        $project->save();

        $project->members()->sync($request->members);

        return redirect()->route("projects.index")->with("success", __("l.Data Updated Successfully"));
    }

}
