<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use App\Models\CustomValue;
use App\Models\Sector;
use App\Models\Client;
use App\Models\ClientGroup;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Lang;

class Clients extends BaseController
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $clients        = Client::with("company", "group")->orderby("created_at", "desc")->get();
        $sectors        = Sector::orderby("created_at", "desc")->get();
        $client_groups  = ClientGroup::orderby("created_at", "desc")->get();
        return Inertia::render("company/clients/index",
            [
                "clients" => $clients,
                "sectors" => $sectors,
                "client_groups" => $client_groups,
                "countries" => Lang::get("countries")
            ]);
    }

    public function add(){
        $sectors        = Sector::orderby("created_at", "desc")->get();
        $companies      = Client::where("type" , 1)->orderby("created_at", "desc")->get();
        $client_groups  = ClientGroup::orderby("created_at", "desc")->get();
        $custom_fields  = CustomField::where("model", "Client")->orderby("order", "asc")->get();

        return Inertia::render("company/clients/add", [
            "sectors_values" => sectors(),
            "sectors" => $sectors,
            "companies" => $companies,
            "client_groups" => $client_groups,
            "countries" => Lang::get("countries"),
            "custom_fields" => $custom_fields
        ]);
    }

    public function reference_unique()
    {
        $unique = false;
        $tested = [];
        do {
            $random = generateRandomString(10);

            if (in_array($random, $tested)) {
                continue;
            }
            $count = Client::where("reference", $random)->count();
            $tested[] = $random;
            if ($count == 0) {
                $unique = true;
            }
        } while (!$unique);
        return $random;
    }

    public function sectors_save(Request $request){
        $sector             = new Sector;
        $sector->name       = $request->name;
        $sector->sector     = $request->sector;
        $sector->save();

        return $sector;
    }

    public function save_client_group(Request  $request){
        $client_group               = new ClientGroup;
        $client_group->name         = $request->name;
        $client_group->save();

        return $client_group;
    }

    public function save(Request $request){
        $request->validate(["name" => "required", "reference" => "required|unique:clients"]);
        if($request->hasFile("image"))
            $request->validate(["image" => "image"]);

        $client                     = new Client;
        $client->type               = $request->type;
        $client->name               = $request->name;
        $client->company            = $request->company;
        $client->reference          = $request->reference;
        $client->sector_id          = $request->sector_id;
        $client->client_group_id    = $request->client_group_id;
        $client->street             = $request->street;
        $client->street2            = $request->street2;
        $client->city               = $request->city;
        $client->state              = $request->state;
        $client->country            = $request->country;
        $client->postal_code        = $request->postal_code;
        $client->tva_num            = $request->tva_num;
        $client->phone              = $request->phone;
        $client->mobile             = $request->mobile;
        $client->email              = $request->email;
        $client->website            = $request->website;
        $client->notes              = $request->notes;
        if($request->hasFile("image"))
            $client->image          = $request->image->store("uploads");

        $client->save();

        foreach ($request->all() as $k => $v){
            if (strpos($k, "field_") !== false) {
                $id                         = str_replace("field_", "", $k);
                $custom_value               = new CustomValue;
                $custom_value->field_id     = $id;
                $custom_value->client_id    = $client->id;
                $custom_value->value        = (is_array($v)) ? implode(",", $v) : $v;
                $custom_value->save();
            }
        }

        return redirect()->route("clients.index")->with("success", __("l.Data Added Successfully"));
    }

    public function edit($id = null){
        $client         = Client::find($id);
        if (!$client)
            return back();

        $sectors        = Sector::orderby("created_at", "desc")->get();
        $companies      = Client::where("type" , 1)->where("id", "!=", $id)->orderby("created_at", "desc")->get();
        $client_groups  = ClientGroup::orderby("created_at", "desc")->get();
        $custom_fields  = CustomField::where("model", "Client")->orderby("order", "asc")->get();
        foreach ($custom_fields as $custom_field){
            $custom_value = CustomValue::where(["field_id" => $custom_field->id, "client_id" => $client->id])->first();
            $value = @$custom_value->value;
            $custom_field->value = $value;
        }
        return Inertia::render("company/clients/edit", [
            "client" => $client,
            "sectors_values" => sectors(),
            "sectors" => $sectors,
            "companies" => $companies,
            "client_groups" => $client_groups,
            "countries" => Lang::get("countries"),
            "custom_fields" => $custom_fields
        ]);
    }

    public function update(Request $request){
        $client         = Client::find($request->id);
        if (!$client)
            return back();

        $request->validate(["name" => "required", "reference" => "required|unique:clients,reference,".$request->id]);
        if($request->hasFile("image"))
            $request->validate(["image" => "image"]);

        $client->type               = $request->type;
        $client->name               = $request->name;
        $client->company            = $request->company;
        $client->reference          = $request->reference;
        $client->sector_id          = $request->sector_id;
        $client->client_group_id    = $request->client_group_id;
        $client->street             = $request->street;
        $client->street2            = $request->street2;
        $client->city               = $request->city;
        $client->state              = $request->state;
        $client->country            = $request->country;
        $client->postal_code        = $request->postal_code;
        $client->tva_num            = $request->tva_num;
        $client->phone              = $request->phone;
        $client->mobile             = $request->mobile;
        $client->email              = $request->email;
        $client->website            = $request->website;
        $client->notes              = $request->notes;
        if ($request->hasFile("image")){
            if($client->image and is_file(storage_path("app/". $client->image)))
                unlink(storage_path("app/". $client->image));
            $client->image            = $request->image->store("uploads");
        }

        $client->save();

        CustomValue::where("client_id", $client->id)->delete();
        foreach ($request->all() as $k => $v){
            if (strpos($k, "field_") !== false) {
                $id                         = str_replace("field_", "", $k);
                $custom_value               = new CustomValue;
                $custom_value->field_id     = $id;
                $custom_value->client_id    = $client->id;
                $custom_value->value        = (is_array($v)) ? implode(",", $v) : $v;
                $custom_value->save();
            }
        }

        return redirect()->route("clients.index")->with("success", __("l.Data Updated Successfully"));
    }

    public function delete($id = null){
        $client = Client::find($id);
        if (!$client)
            return back();

        if($client->image and is_file(storage_path("app/". $client->image)))
            unlink(storage_path("app/". $client->image));

        $client->delete();
        CustomValue::where("client_id", $client->id)->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function view($id = null){
        $client         = Client::with("group", "company", "sector")->find($id);
        if (!$client)
            return back();

        $sectors        = Sector::orderby("created_at", "desc")->get();
        $companies      = Client::where("type" , 1)->where("id", "!=", $id)->orderby("created_at", "desc")->get();
        $client_groups  = ClientGroup::orderby("created_at", "desc")->get();
        $custom_fields  = CustomField::where("model", "Client")->orderby("order", "asc")->get();
        foreach ($custom_fields as $custom_field){
            $custom_value = CustomValue::where(["field_id" => $custom_field->id, "client_id" => $client->id])->first();
            $value = @$custom_value->value;
            $custom_field->value = $value;
        }

        return Inertia::render("company/clients/view", [
            "client" => $client,
            "sectors" => $sectors,
            "companies" => $companies,
            "client_groups" => $client_groups,
            "custom_fields" => $custom_fields
        ]);
    }

}
