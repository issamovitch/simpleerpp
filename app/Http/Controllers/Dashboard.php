<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class Dashboard extends BaseController
{
    public function __construct(){
        parent::__construct();
    }

    public function index(){
        return Inertia::render('company/dashboard', ["title" => "homepage"]);
    }

}
