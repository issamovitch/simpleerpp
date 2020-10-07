<?php

namespace App\Http\Controllers;

use App\Models\KBArticle;
use App\Models\KBGroup;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Str;

class KnowledgeBase extends BaseController
{
    public function __construct(){
        parent::__construct();
    }

    public function index($group_id = null){
        if($group_id)
            $articles   = KBArticle::where("group_id", $group_id)->orderby("order", "asc")->paginate(100000);
        else
            $articles   = KBArticle::orderby("order", "asc")->paginate(20);
        $pagination = pagination($articles);
        $groups     = KBGroup::orderby("order", "asc")->get();
        return Inertia::render('company/knowledge_base/index', compact("articles", "groups", "pagination", "group_id"));
    }

    public function add(){
        $groups = KBGroup::orderby("order", "asc")->get();
        $count  = KBArticle::count()+1;
        return Inertia::render('company/knowledge_base/add', compact("groups", "count"));
    }

    public function group_save(Request  $request){
        $order              = KBGroup::max("order");
        $group              = new KBGroup;
        $group->name        = $request->name;
        $group->description = $request->description;
        $group->order       = $order+1;
        $group->draft       = ($request->draft)?true:false;
        $group->save();

        return $group;
    }

    public function save(Request $request){
        $request->validate(["subject" => "required"]);

        $article            = new KBArticle;
        $article->order     = $request->order;
        $article->subject   = $request->subject;
        $article->slug      = $this->slug_unique($request->subject);
        $article->group_id  = $request->group_id;
        $article->draft     = ($request->draft) ? true : false;
        $article->text      = $request->text;
        $article->save();


        return redirect()->route("knowledge_base.index")->with("success", __("l.Data Added Successfully"));
    }

    public function slug_unique($title)
    {
        $unique = false;
        $tested = [];
        do {
            $slug = Str::of($title)->slug('-');
            if(count($tested)>0)
                $slug.= "-".count($tested);
            if (in_array($slug, $tested)) {
                continue;
            }
            $count = KBArticle::where("slug", $slug)->count();
            array_push($tested, $slug);
            if ($count == 0) {
                $unique = true;
            }
        } while (!$unique);
        return $slug;
    }

    public function edit($id = null){
        $article    = KBArticle::find($id);
        if(!$article)
            return back();
        $groups     = KBGroup::orderby("order", "asc")->get();
        return Inertia::render('company/knowledge_base/edit', compact("groups", "article"));
    }

    public function update(Request $request){
        $request->validate(["subject" => "required", "slug" => "required||unique:k_b_articles,slug,".$request->id]);
        $article    = KBArticle::find($request->id);
        if(!$article)
            return back();

        $article->order     = $request->order;
        $article->subject   = $request->subject;
        $article->slug      = $request->slug;
        $article->group_id  = $request->group_id;
        $article->draft     = ($request->draft) ? true : false;
        $article->text      = $request->text;
        $article->save();

        return redirect()->route("knowledge_base.index")->with("success", __("l.Data Updated Successfully"));
    }

    public function delete($id = null){
        $article    = KBArticle::find($id);
        if(!$article)
            return back();

        $article->delete();

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function filter(Request $request){
        $articles   = KBArticle::orderby("order", "asc");
        if($request->group_id=="") {
            if($request->status!=""){
                if($request->status == "d"){
                    $articles = $articles->whereHas("group", function ($q){$q->where("k_b_groups.draft", true);})
                    ->orWhere(function ($query) {
                       $query->where("draft", true)->whereHas("group", function ($q){$q->where("k_b_groups.draft", false);});
                    });
                }else{
                    $articles = $articles->where("draft", false)->whereHas("group", function ($q){$q->where("k_b_groups.draft", false);});
                }
            }
        }
        elseif($request->group_id == "ng"){
            $articles   = $articles->whereNull("group_id");
            if($request->status!=""){
                if($request->status == "d"){
                    $articles = $articles->where("draft", true);
                }else{
                    $articles = $articles->where("draft", false);
                }
            }
        }
        else{
            $articles   = $articles->where("group_id", $request->group_id);
            $group     = KBGroup::find($request->group_id);
            if($request->status!=""){
                if($request->status == "d"){
                    if($group->draft){
                        // All article draft
                    } else{
                        $articles = $articles->where("draft", true);
                    }
                }else{
                    if($group->draft){
                        // All article draft
                        $articles = $articles->where(false);
                    } else{
                        $articles = $articles->where("draft", false);
                    }
                }
            }
        }

        $articles   = $articles->get();
        return $articles;
    }

}
