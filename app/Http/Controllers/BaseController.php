<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Session;
use Auth;
use App\Models\Setting;
use View;

class BaseController extends Controller
{
    public function __construct()
    {
        $settings = Setting::all()->keyBy("key");
        $app_name = (@$settings["app_name"]) ? $settings["app_name"]->value : "SimpleERP";
        View::share('app_name', $app_name);
        $logo = (@$settings["logo"]) ? asset("storage/app/".$settings["logo"]->value) : asset("public/no-image.png");
        $login_page_image = (@$settings["login_page_image"]) ? asset("storage/app/".$settings["login_page_image"]->value) : '';
        View::share('logo', $logo);
        Inertia::share('flash', function () use($app_name, $logo, $login_page_image) {
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
            ];
        });
        Inertia::share('auth.user', function () {
            return Auth::user();
        });
    }

    public function index()
    {
        return Inertia::render('auth/login', ["title" => __("l.Home")]);
    }

}