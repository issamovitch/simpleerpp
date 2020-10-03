<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\MailboxLabel;
use App\Models\MailboxMessage;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;
use Auth;

class Mailbox extends BaseController{

    public function __construct(){
        parent::__construct();
    }

    // Labels
    public function get_labels(Request $request){
        return MailboxLabel::orderby("created_at", "desc")->get();
    }

    public function save_label(Request $request){
        if($request->id){
            $label      = MailboxLabel::find($request->id);
            if(!$label)
                return;
        }else{
            $label      = new MailboxLabel;
        }
        $label->name    = $request->name;
        $label->color   = $request->color;
        $label->save();
    }

    public function delete_label($id = null){
        $label = MailboxLabel::find($id);
        if ($label)
            $label->delete();

        return back();
    }

    // Compose
    public function compose(){
        $users  = User::orderby("created_at", "desc")->get();
        $labels = MailboxLabel::orderby("created_at", "desc")->get();
        return Inertia::render("company/mailbox/compose", compact("users", "labels"));
    }

    public function save_message(Request $request){
        $request->validate(["to" => "required", "text" => "required"]);
        $message            = new MailboxMessage;
        $message->from      = Auth::guard("web")->user()->id;
        $message->to        = $request->to;
        $message->label_id  = $request->label_id;
        $message->subject   = $request->subject;
        $message->text      = $request->text;
        $message->read      = 0;
        $message->favorite  = 0;
        $message->draft     = ($request->draft and $request->draft == "1") ? 1 : 0;
        $message->trash     = 0;
        $message->save();

        if($request->has("attachments")){
            foreach ($request->attachments as $attachment){
                $path = $attachment->storeAs('uploads/attachments', time()."_".$attachment->getClientOriginalName());
                $attachment = new Attachment;
                $attachment->path = $path;
                $attachment->user_id = Auth::guard("web")->user()->id;
                $message->attachments()->save($attachment);
            }
        }

        mailit(@$message->user_to->email, $message->subject, $message->text, "Mailbox", $message->attachments(), @$message->user_from->email);

        return redirect()->route("mailbox.sent")->with("success", __("l.Data Added Successfully"));
    }

    // Inbox
    public function inbox(){
        $messages = MailboxMessage::with("user_from", "user_to", "label")
            ->where("to" , Auth::guard("web")->user()->id)
            ->where(["draft" => 0, "trash" => 0])
            ->orderby("created_at", "desc")
            ->paginate(20);
        $pagination = pagination($messages);
        return Inertia::render("company/mailbox/inbox", compact("messages", "pagination"));
    }

    // Draft
    public function draft(){
        $messages = MailboxMessage::with("user_from", "user_to", "label")
            ->where("from", Auth::guard("web")->user()->id)
            ->where(["draft" => 1, "trash" => 0])
            ->orderby("created_at", "desc")
            ->paginate(20);
        $pagination = pagination($messages);
        return Inertia::render("company/mailbox/draft", compact("messages", "pagination"));
    }

    // Trash
    public function trash(){
        $user_id = Auth::guard("web")->user()->id;
        $messages = MailboxMessage::with("user_from", "user_to", "label")
            ->where(function ($q) use ($user_id) {
                $q->where('to', $user_id)->orWhere('from', $user_id);
            })
            ->where("trash", 1)
            ->orderby("created_at", "desc")
            ->paginate(20);
        $pagination = pagination($messages);
        return Inertia::render("company/mailbox/trash", compact("messages", "pagination"));
    }

    // Sent
    public function sent(){
        $messages = MailboxMessage::with("user_from", "user_to", "label")
            ->where("from" , Auth::guard("web")->user()->id)
            ->where(["draft" => 0, "trash" => 0])
            ->orderby("created_at", "desc")->paginate(20);
        $pagination = pagination($messages);
        return Inertia::render("company/mailbox/sent", compact("messages", "pagination"));
    }

    // Favorite
    public function favorite(){
        $user_id = Auth::guard("web")->user()->id;
        $messages = MailboxMessage::with("user_from", "user_to", "label")
            ->where(function ($q) use ($user_id) {
                $q->where('to', $user_id)->orWhere('from', $user_id);
            })
            ->where("favorite", 1)
            ->orderby("created_at", "desc")
            ->paginate(20);
        $pagination = pagination($messages);
        return Inertia::render("company/mailbox/favorite", compact("messages", "pagination"));
    }

    // Operations
    public function unfavorite($id = null){
        $user_id = Auth::guard("web")->user()->id;
        $message = MailboxMessage::where(["id" => $id])->where("favorite", 1)
            ->where(function ($q) use ($user_id) {
                $q->where('to', $user_id)->orWhere('from', $user_id);
            })->first();
        if ($message) {
            $message->favorite = 0;
            $message->save();
        }

        return back();
    }

    public function dofavorite($id = null){
        $user_id = Auth::guard("web")->user()->id;
        $message = MailboxMessage::where(["id" => $id])->where("favorite", 0)
            ->where(function ($q) use ($user_id) {
                $q->where('to', $user_id)->orWhere('from', $user_id);
            })->first();
        if ($message) {
            $message->favorite = 1;
            $message->save();
        }

        return back();
    }

    public function message($id = null){
        $user_id        = Auth::guard("web")->user()->id;
        $message        = MailboxMessage::with("user_from", "user_to", "label", "attachments")->where(["id" => $id])
            ->where(function ($q) use ($user_id) {
                $q->where('to', $user_id)->orWhere('from', $user_id);
            })->first();
        if (!$message)
            return back();
        $message->read  = 1;
        $message->save();
        foreach ($message->attachments as $attachment){
            $attachment->pathinfo = pathinfo(storage_path("app/". $attachment->path));
            $attachment->size = formatBytes(filesize(storage_path("app/". $attachment->path)));
        }

        return Inertia::render("company/mailbox/message", compact("message"));
    }

    public function delete(Request $request){
        $user_id = Auth::guard("web")->user()->id;
        foreach ($request->ids as $id) {
            $message = MailboxMessage::with("attachments")->where("id" , $id)
                ->where(function ($q) use ($user_id) {
                    $q->where('to', $user_id)->orWhere('from', $user_id);
                })->first();
            if ($message) {
                if ($message->trash) {
                    foreach ($message->attachments as $attachment){
                        if(file_exists(storage_path("app/". $attachment->path)) and is_file(storage_path("app/". $attachment->path)))
                            unlink(storage_path("app/". $attachment->path));
                        $attachment->delete();
                    }
                    $message->delete();
                } else {
                    $message->trash = true;
                    $message->save();
                }
            }
        }

        return back()->with("success", __("l.Data Deleted Successfully"));
    }

    public function delete_message($id = null)
    {
        $user_id = Auth::guard("web")->user()->id;
        $message = MailboxMessage::with("attachments")->where("id" , $id)
            ->where(function ($q) use ($user_id) {
                $q->where('to', $user_id)->orWhere('from', $user_id);
            })->first();
        if (!$message)
            return back();

        if ($message->trash) {
            foreach ($message->attachments as $attachment){
                if(file_exists(storage_path("app/". $attachment->path)) and is_file(storage_path("app/". $attachment->path)))
                    unlink(storage_path("app/". $attachment->path));
                $attachment->delete();
            }
            $message->delete();
        } else {
            $message->trash = true;
            $message->save();
        }

        return redirect()->route("mailbox.inbox")->with("success", __("l.Data Deleted Successfully"));

    }

    public function search(Request $request){
        $user_id = Auth::guard("web")->user()->id;
        $messages = MailboxMessage::with("user_from", "user_to", "label");
        if($request->current == "inbox")
            $messages = $messages->where(["to" => Auth::guard("web")->user()->id])->where(["draft" => 0, "trash" => 0]);
        elseif ($request->current == "sent")
            $messages = $messages->where(["from" => Auth::guard("web")->user()->id])->where(["draft" => 0, "trash" => 0]);
        elseif ($request->current == "draft")
            $messages = $messages->where(["from" => Auth::guard("web")->user()->id])->where(["draft" => 1, "trash" => 0]);
        elseif ($request->current == "trash")
            $messages = $messages->where(function ($q) use ($user_id) {$q->where('to', $user_id)->orWhere('from', $user_id);})->where("trash", 1);
        elseif ($request->current == "favorite")
            $messages = $messages->where(function ($q) use ($user_id) {$q->where('to', $user_id)->orWhere('from', $user_id);})->where("favorite", 1);
        $messages = $messages->orderby("created_at", "desc")
            ->where('subject', "like", "%" . $request->q . "%")
            ->get();

        return $messages;
    }

}
