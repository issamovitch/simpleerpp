<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Inertia\Inertia;

class ForgotPasswordController extends BaseController
{
    use SendsPasswordResetEmails;

    public function __construct(){
        parent::__construct();
    }

    public function showLinkRequestForm(){
        return Inertia::render('auth/passwords_email');
    }
}
