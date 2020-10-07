<?php

namespace App\Http\Controllers\Front;

use App\Models\KBArticle;
use App\Models\KBGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Inertia\Inertia;
use Redirect;

class KnowledgeBase extends BaseController
{

    public function __construct(){
        parent::__construct();
    }

    public function index(){
        $groups = KBGroup::withCount(['articles' => function($query) {$query->where("draft", false);}])->whereHas("articles")->where("draft", false)->orderby("order", "asc")->get();
        return Inertia::render("front/knowledge_base/index", compact("groups"));
    }

    public function group($group_id = null){
        $group = KBGroup::with("articles")->where("id", $group_id)->where("draft", false)->first();
        if(!$group)
            return back();
        return Inertia::render("front/knowledge_base/group", compact("group"));
    }

    public function article($slug = null){
        $article = KBArticle::with("group")->where("slug", $slug)->where("draft", false)->first();
        if(!$article)
            return back();
        $group = KBGroup::with("articles")->where("id", $article->group_id)->where("draft", false)->first();
        if(!$group)
            return back();
        return Inertia::render("front/knowledge_base/article", compact("group", "article"));
    }

    public function search(Request $request){
        $articles = KBArticle::where("subject", "like",  "%".$request->q."%")
            ->where("draft", false)->orderby("order", "asc")->get();
        return $articles;
    }
}
