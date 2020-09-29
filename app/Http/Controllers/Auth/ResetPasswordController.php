<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Inertia\Inertia;



class ResetPasswordController extends BaseController
{

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct(){
        parent::__construct();
    }
    public function showResetForm(Request $request){
        $token = $request->route()->parameter('token');
        return Inertia::render('auth/passwords_reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
