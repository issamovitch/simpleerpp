<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Session;
use Auth;
use App\Models\Setting;
use View;
use App\Models\MailboxMessage;

class BaseController extends Controller
{
    public $settings;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $settings = Setting::all()->keyBy("key");
            $this->settings = $settings;
            $app_name = (@$settings["app_name"]) ? $settings["app_name"]->value : "SimpleERP";
            View::share('app_name', $app_name);
            $logo = (@$settings["logo"]) ? asset("storage/app/".$settings["logo"]->value) : asset("public/no-image.png");
            $login_page_image = (@$settings["login_page_image"]) ? asset("storage/app/".$settings["login_page_image"]->value) : '';
            View::share('logo', $logo);
            $unread_messages = collect();
            if(Auth::guard("web")->check()){
                $unread_messages = MailboxMessage::with("user_from", "user_to", "label")
                    ->where("to" , Auth::guard("web")->user()->id)
                    ->where(["draft" => 0, "trash" => 0, "read" => 0])->get();
            }
            Inertia::share('flash', function () use($app_name, $logo, $login_page_image, $unread_messages, $settings) {
                return [
                    'message' => Session::get('message'),
                    'success' => Session::get('success'),
                    'error' => Session::get('error'),
                    'errors' => Session::get('errors'),
                    'status' => Session::get('status'),
                    'hello' => Session::get('hello'),
                    "app_name" => $app_name,
                    "logo" => $logo,
                    "login_page_image" => $login_page_image,
                    "unread_messages" => $unread_messages,
                    "settings" => $settings
                ];
            });
            Inertia::share('auth.user', function () {
                return Auth::user();
            });
            return $next($request);
        });
    }

    public function index()
    {
        return Inertia::render('auth/login', ["title" => __("l.Home")]);
    }

}
